# Implementation Plan — Registration Fix + Manual Payment + Owner Verification

Laravel 12 + Filament 5 + Breeze kost app. DB is PostgreSQL (`arca_kost`), tests run on sqlite `:memory:`.

## Exploration findings (ground truth, verified against code/DB)

- **Registration is NOT currently producing role=null on this schema.** The `users.role` column was created by `0001_01_01_000000_create_users_table.php` as `enum('role', ['customer','staff','owner'])->default('customer')`, and the live Postgres column has `column_default = 'customer'` and `is_nullable = NO` (verified via information_schema). Simulating `RegisteredUserController@store` directly produced a user with `role = 'customer'`, redirect to `/dashboard`, and `email_verified_at = null` (verified in tinker). `User` does NOT implement `MustVerifyEmail`, so the `verified` middleware passes for a null `email_verified_at`. The existing `tests/Feature/Auth/RegistrationTest.php` passes.
- **Real-world fragility / likely failure cause:** the controller never sets `role` explicitly (relies solely on the DB default), and the shared `resources/views/auth/login-page.blade.php` form has `action="{{ url('/login') }}"` by default and only swaps to `/register` via JavaScript (`toggleAuth`). If JS does not run / the user submits before toggling, the register fields post to `/login` and registration silently fails. The fix hardens both: set `role` explicitly in the controller + a model default so role can never be null, and make the register submission robust.
- **No live Midtrans code exists.** `midtrans/midtrans-php` is in composer.json but there is no `Midtrans\` import or Snap call anywhere in `app/`. `BookingController@pay` already hardcodes dummy bank details and renders a QR via `simplesoftwareio/simple-qrcode`; `processCheckout` already does a manual bank-transfer + proof-upload flow and sets `status = 'review'`. So Part B is a rework of the existing manual flow, not a Midtrans removal.
- **Booking status CHECK constraint** (`2026_05_20_085218` + `2026_06_15_000002`, pgsql-only) allows: `pending, review, active, cancelled, completed`. `'review'` is already the "submitted, awaiting owner check" state and is already rendered by the admin as "Butuh Konfirmasi" (warning badge). **Decision: reuse `'review'` for awaiting-verification** — it is already in the CHECK constraint and already understood by the admin UI and dashboard, so no new status and no constraint migration are needed (lowest risk, satisfies the task).
- **Data model decision:** `bookings` has `proof_of_payment` (reuse it) but NO `payment_method` column. `payments` (empty, 0 rows) has `booking_id, amount, payment_method, status enum(pending|success|failed), snap_token` and `App\Models\Payment` (`$guarded = []`). **Decision: record `payment_method` ('bank_transfer' | 'on_site') and verification state on a `Payment` row; keep the proof image path on `bookings.proof_of_payment`; use `bookings.status = 'review'` as the awaiting-verification state.** Add only the genuinely missing `payments.notes` (rejection reason) and `payments.verified_at` columns via one migration.
- **Filament admin:** `app/Filament/Resources/Bookings/BookingResource.php` defines `form()` and `table()` INLINE (it does NOT delegate to `Tables/BookingsTable.php` or `Schemas/BookingForm.php`, which are stale generator stubs). All admin booking UI changes go in `BookingResource.php`. Filament 5 action/notification conventions in this repo: `Filament\Actions\Action`, `Filament\Actions\EditAction`, `Filament\Notifications\Notification` (both vendor classes confirmed present). Room status strings are `'available'` / `'occupied'`; `Booking::booted()` has a `deleted` hook that frees the room.
- **Config convention:** `config/services.php` is stock. A new `config/payment.php` is the cleanest home for dummy bank details.

---

- [ ] 1. Harden customer registration so `role` can never be null and the register form always posts correctly.
      Set `'role' => 'customer'` explicitly in `RegisteredUserController@store` User::create. Add a protected `$attributes = ['role' => 'customer']` default to `App\Models\User` (DB default already exists; this adds a second layer). In `resources/views/auth/login-page.blade.php`, make registration robust without relying on JS: render the register fields (name, phone_number, profession, password_confirmation) so they are present on submit, and ensure the form posts to `/register` with `@csrf` when in register mode (e.g. set `action` from `$mode`, or keep the JS toggle but default the hidden mode/action correctly). Keep login behaviour unchanged.
      Files: app/Http/Controllers/Auth/RegisteredUserController.php, app/Models/User.php, resources/views/auth/login-page.blade.php
      Verify: `php artisan test --filter=RegistrationTest` passes; then add/extend a feature test (item 7) asserting a freshly registered user has `role='customer'` and `GET /dashboard` returns 200 (not redirected to /login or /verify-email).

- [ ] 2. Add dummy bank-account config.
      Create `config/payment.php` returning `['bank' => ['name' => env('KOST_BANK_NAME'), 'account_number' => env('KOST_BANK_ACCOUNT_NUMBER'), 'account_holder' => env('KOST_BANK_ACCOUNT_HOLDER')]]` with sensible dummy fallbacks. Append the three keys to `.env` AND `.env.example`:
      `KOST_BANK_NAME="Bank Central Asia (BCA)"`, `KOST_BANK_ACCOUNT_NUMBER="1234567890"`, `KOST_BANK_ACCOUNT_HOLDER="Arca Kost Dummy"`. Do NOT touch DB_* keys.
      Files: config/payment.php, .env, .env.example
      Verify: `php artisan config:clear && php artisan tinker --execute="echo config('payment.bank.account_number');"` prints the number (falls back to default even if .env unread).

- [ ] 3. Add migration for the two genuinely missing payment-verification fields.
      New migration adding nullable `verified_at` (timestamp) and `notes` (string, rejection reason) to `payments`. Do not alter the `status` enum (reuse pending/success/failed) or the bookings CHECK constraint.
      Files: database/migrations/<timestamp>_add_verification_fields_to_payments_table.php
      Verify: `php artisan migrate` runs clean on pgsql; `php artisan migrate:fresh --seed` still succeeds and seeders (Admin/Room/Booking/Review) complete.

- [ ] 4. Rework the customer pay page to offer exactly two manual methods with dummy bank details and no Midtrans/QR dependency.
      Rework `BookingController@pay` to pass bank details from `config('payment.bank')` (remove the hardcoded QR generation / `QrCode` use from the required path). Rework `resources/views/booking/payment.blade.php` to present two radio methods: `bank_transfer` (shows bank name / account number / holder + amount due + proof-upload field) and `on_site` (bayar langsung di tempat; no upload). Show/hide the upload section via the existing JS based on selection.
      Files: app/Http/Controllers/BookingController.php, resources/views/booking/payment.blade.php
      Verify: `GET /booking/{booking}/pay` as the booking owner returns 200 and renders both methods + the dummy account number from config (asserted in the feature test, item 7).

- [ ] 5. Rework `processCheckout` to persist the chosen manual method, create a Payment row, and set awaiting-verification state.
      Validate `payment_method` in:`bank_transfer,on_site`. For `bank_transfer`: require `payment_receipt` (mimes jpg,jpeg,png; max 4096), store on `public` disk under `proofs/`, save path to `bookings.proof_of_payment`. For `on_site`: no upload. In both cases create a `Payment` (booking_id, amount = booking total_price, payment_method, status 'pending') and set `bookings.status = 'review'`. Remove any `qr` method branch. No Midtrans calls.
      Files: app/Http/Controllers/BookingController.php
      Verify: feature test (item 7) posts both methods and asserts booking.status='review', a Payment row exists with the right method/status, and (bank_transfer only) proof_of_payment is set on the public disk.

- [ ] 6. Add owner verification UI + Approve/Reject actions in the Filament admin BookingResource.
      In `app/Filament/Resources/Bookings/BookingResource.php`: add a payment-method display (derive from the latest related Payment) and keep the `proof_of_payment` ImageColumn (already present) so the owner can see the uploaded proof. Add two record actions using `Filament\Actions\Action` + `Filament\Notifications\Notification`, visible only when `status === 'review'`:
      - **Approve**: set booking `status = 'active'`, set its room `status = 'occupied'`, set latest Payment `status = 'success'` and `verified_at = now()`; success notification.
      - **Reject**: set booking `status = 'pending'` (reusable, within CHECK constraint; do NOT activate), set latest Payment `status = 'failed'`, store optional reason into `payments.notes` (Action form Textarea); danger/warning notification.
      Keep owner/staff `canAccessPanel` untouched. Match the inline form/table style already in this file (do not switch to the stale Table/Form stub classes).
      Files: app/Filament/Resources/Bookings/BookingResource.php
      Verify: `php artisan test` green; manual check at `/admin` logged in as owner@arca.com — a 'review' booking shows the proof + method and Approve/Reject actions; Approve flips booking to active and room to occupied; Reject sets pending and does not activate. (Automate the state transitions in the item-7 test by invoking the same model updates the action performs.)

- [ ] 7. Add an end-to-end feature test covering registration + both payment methods + approve/reject.
      New `tests/Feature/ManualPaymentFlowTest.php` (RefreshDatabase, sqlite): (a) register a user, assert `role='customer'` and `GET /dashboard` == 200; (b) create a Room/RoomType + booking, hit `GET pay` (assert 200 + bank number), `POST checkout` with `payment_method=bank_transfer` + `Illuminate\Http\UploadedFile::fake()->image()` (assert booking status 'review', Payment row method 'bank_transfer' status 'pending', proof stored via `Storage::fake('public')`); (c) a second booking with `payment_method=on_site` (assert status 'review', Payment 'on_site', no proof); (d) approve path: set booking active + room occupied + Payment success and assert; (e) reject path: Payment failed + booking pending and assert. Follow the RefreshDatabase/HTTP style of `tests/Feature/Auth/RegistrationTest.php`.
      Files: tests/Feature/ManualPaymentFlowTest.php
      Verify: `php artisan test --filter=ManualPaymentFlowTest` passes.

- [ ] 8. Full-suite + integration verification.
      Run the whole suite and a fresh seed to confirm nothing regressed (admin access, seeders, existing auth/profile tests).
      Files: (none)
      Verify: `php artisan test` all green; `php artisan migrate:fresh --seed` succeeds; manual: owner@arca.com logs into `/admin`, a seeded customer logs into `/dashboard`.

## Notes / assumptions
- Reusing `'review'` for awaiting-verification avoids a CHECK-constraint migration; `'pending'` is reused for a rejected booking (back to unpaid). Both values are already allowed and already rendered by the admin UI.
- Midtrans package is left installed but unused; the live checkout path requires no Midtrans credentials and makes no Midtrans calls.
- Proof images use the `public` disk under `proofs/` (matches the existing column, controller, and the Filament ImageColumn `->disk('public')->directory('proofs')`).
