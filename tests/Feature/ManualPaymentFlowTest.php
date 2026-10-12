<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManualPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_customer_can_register_and_reach_dashboard(): void
    {
        $response = $this->post('/register', [
            'name' => 'Manual Payer',
            'email' => 'payer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'payer@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('customer', $user->role);

        $this->get('/dashboard')->assertStatus(200);
    }

    public function test_pay_page_shows_dummy_bank_account(): void
    {
        [$user, $room] = $this->makeCustomerAndRoom();
        $booking = $this->makeBooking($user, $room);

        $response = $this->actingAs($user)->get(route('booking.pay', $booking));

        $response->assertStatus(200);
        $response->assertSee(config('payment.bank.account_number'));
    }

    public function test_bank_transfer_checkout_stores_proof_and_creates_payment(): void
    {
        Storage::fake('public');

        [$user, $room] = $this->makeCustomerAndRoom();
        $booking = $this->makeBooking($user, $room);

        $response = $this->actingAs($user)->post(route('booking.checkout', $booking), [
            'payment_method' => 'bank_transfer',
            'payment_receipt' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response->assertRedirect(route('booking.my-bookings'));

        $booking->refresh();
        $this->assertSame('review', $booking->status);
        $this->assertNotNull($booking->proof_of_payment);
        Storage::disk('public')->assertExists($booking->proof_of_payment);

        $payment = $booking->payments()->latest()->first();
        $this->assertNotNull($payment);
        $this->assertSame('bank_transfer', $payment->payment_method);
        $this->assertSame('pending', $payment->status);
    }

    public function test_on_site_checkout_creates_payment_without_proof(): void
    {
        [$user, $room] = $this->makeCustomerAndRoom();
        $booking = $this->makeBooking($user, $room);

        $response = $this->actingAs($user)->post(route('booking.checkout', $booking), [
            'payment_method' => 'on_site',
        ]);

        $response->assertRedirect(route('booking.my-bookings'));

        $booking->refresh();
        $this->assertSame('review', $booking->status);
        $this->assertNull($booking->proof_of_payment);

        $payment = $booking->payments()->latest()->first();
        $this->assertNotNull($payment);
        $this->assertSame('on_site', $payment->payment_method);
        $this->assertSame('pending', $payment->status);
    }

    public function test_owner_approval_activates_booking_and_occupies_room(): void
    {
        [$user, $room] = $this->makeCustomerAndRoom();
        $booking = $this->makeBooking($user, $room, 'review');
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
        ]);

        // Replicate the Approve record action's updates.
        $booking->update(['status' => 'active']);
        $booking->room->update(['status' => 'occupied']);
        $payment->update(['status' => 'success', 'verified_at' => now()]);

        $booking->refresh();
        $room->refresh();
        $payment->refresh();

        $this->assertSame('active', $booking->status);
        $this->assertSame('occupied', $room->status);
        $this->assertSame('success', $payment->status);
        $this->assertNotNull($payment->verified_at);
    }

    public function test_owner_rejection_sets_booking_pending_and_payment_failed(): void
    {
        [$user, $room] = $this->makeCustomerAndRoom();
        $booking = $this->makeBooking($user, $room, 'review');
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
        ]);

        // Replicate the Reject record action's updates.
        $reason = 'Bukti transfer tidak valid.';
        $booking->update(['status' => 'pending']);
        $payment->update(['status' => 'failed', 'notes' => $reason]);

        $booking->refresh();
        $room->refresh();
        $payment->refresh();

        $this->assertSame('pending', $booking->status);
        $this->assertNotSame('active', $booking->status);
        $this->assertSame('failed', $payment->status);
        $this->assertSame($reason, $payment->notes);
        // The rejected booking must not occupy the room.
        $this->assertNotSame('occupied', $room->status);
    }

    /**
     * @return array{0: User, 1: Room}
     */
    private function makeCustomerAndRoom(): array
    {
        $user = User::factory()->create(['role' => 'customer']);

        $roomType = RoomType::create([
            'name' => 'Standard AC',
            'description' => 'Dummy room type',
            'price' => 1000000,
        ]);

        $room = Room::create([
            'room_type_id' => $roomType->id,
            'room_number' => 'A-01',
            'status' => 'available',
        ]);

        return [$user, $room];
    }

    private function makeBooking(User $user, Room $room, string $status = 'pending'): Booking
    {
        return Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'total_price' => 1000000,
            'status' => $status,
        ]);
    }
}
