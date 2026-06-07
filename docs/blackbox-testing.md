# Blackbox Testing — Arcadia Kost

**Tanggal:** <isi tanggal pengujian>
**Penguji:** <isi nama penguji>
**Lingkungan:** <isi lingkungan, contoh: local/staging>
**Browser:** <isi browser & versi>

---

## 1. Landing Page (Guest)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 1.1 | Mengakses halaman landing page | Buka browser, akses URL `/` | Halaman landing tampil dengan section: hero, facilities, room info, location, review carousel, dan footer |
| 1.2 | Verifikasi review publik hanya tampil yang visible | Akses landing page, scroll ke bagian "Resident Stories" | Hanya review dengan flag `is_visible = true` yang muncul di carousel. Review dengan `is_visible = false` tidak tampil |
| 1.3 | Navigasi mobile menu | Buka landing page di viewport < 768px, klik ikon hamburger | Mobile menu terbuka dan menampilkan semua link navigasi |
| 1.4 | Scroll ke section tertentu via navbar | Klik link navigasi (misal: Fasilitas, Kamar, Lokasi) di navbar | Halaman scroll otomatis ke section yang dituju |
| 1.5 | CTA button menuju register | Klik tombol CTA (Call to Action) di landing page | Diarahkan ke halaman register `/register` |

---

## 2. Autentikasi — Register

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 2.1 | Register dengan data valid | Akses `/register`, isi nama: "Budi Santoso", email: "budi@email.com", password: "password123", password_confirmation: "password123", klik Register | Akun berhasil dibuat, email verifikasi terkirim, redirect ke halaman login dengan pesan sukses |
| 2.2 | Register dengan email sudah terdaftar | Isi form register menggunakan email yang sudah ada (misal: owner@arca.com) | Validasi gagal, muncul pesan error "The email has already been taken" |
| 2.3 | Register dengan password tidak cocok | Isi form register, password: "pass123", password_confirmation: "pass456" | Validasi gagal, muncul pesan error "The password confirmation does not match" |
| 2.4 | Register dengan field kosong | Klik tombol Register tanpa mengisi field apapun | Validasi gagal, muncul pesan error di setiap field wajib (name, email, password) |
| 2.5 | Register dengan format email tidak valid | Isi email: "bukanemail", field lain valid, klik Register | Validasi gagal, muncul pesan error "The email must be a valid email address" |
| 2.6 | Register dengan password kurang dari 8 karakter | Isi password: "12345", field lain valid, klik Register | Validasi gagal, muncul pesan error "The password must be at least 8 characters" |

---

## 3. Autentikasi — Login

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 3.1 | Login dengan kredensial valid | Akses `/login`, isi email dan password customer yang sudah terverifikasi, klik Login | Berhasil login, redirect ke halaman dashboard `/dashboard` |
| 3.2 | Login dengan email belum verifikasi | Login menggunakan akun yang belum melakukan verifikasi email | Redirect ke halaman `/verify-email` dengan pesan peringatan |
| 3.3 | Login dengan password salah | Isi email valid, masukkan password yang salah, klik Login | Login gagal, muncul pesan error "These credentials do not match our records" |
| 3.4 | Login dengan email tidak terdaftar | Isi email: "tidakada@email.com", password sembarang, klik Login | Login gagal, pesan error sama seperti password salah (keamanan) |
| 3.5 | Login dengan field kosong | Klik tombol Login tanpa mengisi email dan password | Validasi gagal, muncul pesan error di field email dan password |
| 3.6 | Remember me | Centang "Remember me", login, tutup browser, buka kembali | User tetap login (session persistent) |
| 3.7 | Rate limiting login | Masukkan password salah 5x berturut-turut | Muncul pesan "Too many login attempts. Please try again in X seconds" |

---

## 4. Autentikasi — Forgot & Reset Password

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 4.1 | Forgot password dengan email terdaftar | Akses `/forgot-password`, isi email yang terdaftar, klik "Email Password Reset Link" | Email reset password terkirim, muncul pesan sukses |
| 4.2 | Forgot password dengan email tidak terdaftar | Isi email yang tidak terdaftar, klik submit | Tetap muncul pesan sukses (tidak membocorkan info user) |
| 4.3 | Reset password dengan token valid | Buka link dari email reset password, isi password baru & konfirmasi, klik submit | Password berhasil direset, redirect ke login |
| 4.4 | Reset password dengan token kadaluarsa | Gunakan token reset yang sudah lebih dari 60 menit | Gagal, muncul pesan error token tidak valid/kadaluarsa |
| 4.5 | Reset password — konfirmasi tidak cocok | Isi password baru: "newpass1", konfirmasi: "newpass2" | Validasi gagal, muncul pesan error |

---

## 5. Dashboard Customer

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 5.1 | Akses dashboard setelah login | Login sebagai customer, user akan otomatis redirect ke `/dashboard` | Dashboard menampilkan daftar room types dengan jumlah kamar tersedia, rata-rata rating, dan total review |
| 5.2 | Akses dashboard tanpa login | Akses `/dashboard` tanpa login | Redirect ke halaman login `/login` |
| 5.3 | Room type card menampilkan aksi Booking | Lihat card room type di dashboard | Ada tombol "Pesan Sekarang" atau "Booking" pada setiap room type |
| 5.4 | Dashboard kosong (tidak ada room type) | Hapus semua room types dari database | Dashboard tetap tampil tanpa error, menampilkan pesan "Belum ada tipe kamar tersedia" |

---

## 6. Booking

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 6.1 | Membuat booking baru | Di dashboard, klik tombol booking pada room type, submit form | Booking berhasil dibuat dengan status `pending`, redirect ke halaman pembayaran. Room status berubah menjadi `occupied` |
| 6.2 | Booking tanpa login | Akses `/booking/{roomType}` tanpa login | Redirect ke halaman login |
| 6.3 | Booking saat tidak ada kamar tersedia | Booking room type yang semua room-nya berstatus `occupied` | Booking gagal, muncul pesan error "Tidak ada kamar tersedia untuk tipe ini" |
| 6.4 | Otomatis assign kamar pertama tersedia | Booking room type yang memiliki 5 kamar (3 occupied, 2 available) | Sistem otomatis assign kamar available pertama (ID terkecil) |
| 6.5 | Durasi booking fixed 1 bulan | Buat booking, periksa start_date dan end_date | end_date = start_date + 1 bulan. duration_months = 1 |
| 6.6 | Total harga sesuai room type price | Booking room type dengan harga Rp 1.750.000 | total_price = Rp 1.750.000 |
| 6.7 | Akses halaman "My Bookings" | Sebagai customer, akses `/my-bookings` | Menampilkan daftar semua booking milik customer tersebut dengan status dan tombol aksi yang sesuai |
| 6.8 | My Bookings — booking dengan status berbeda | Miliki booking dengan status pending, review, active, cancelled, completed | Setiap booking menampilkan aksi yang sesuai: pending→tombol bayar, active→tombol review & servis, dll |
| 6.9 | Booking tanpa verifikasi email | Login dengan akun belum verifikasi, coba akses `/booking/{roomType}` | Redirect ke halaman verifikasi email |
| 6.10 | Duplikasi booking | Customer yang sudah memiliki booking active mencoba booking lagi (jika dibatasi) | Sesuai aturan bisnis (saat ini tidak ada batasan, izinkan atau tolak) |

---

## 7. Pembayaran

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 7.1 | Akses halaman pembayaran | Dari my-bookings, klik tombol Bayar pada booking `pending` | Halaman pembayaran tampil dengan info: nomor rekening BCA, jumlah yang harus dibayar, QR code, dan form upload bukti |
| 7.2 | Upload bukti pembayaran valid | Pilih file gambar (JPG/PNG, maks 2MB), klik upload | Bukti tersimpan, booking status berubah menjadi `review`, muncul pesan sukses |
| 7.3 | Upload bukti — file bukan gambar | Upload file PDF atau .txt | Validasi gagal, muncul pesan error "File harus berupa gambar (JPG/PNG)" |
| 7.4 | Upload bukti — file terlalu besar | Upload gambar > 2MB | Validasi gagal, muncul pesan error "Ukuran file maksimal 2MB" |
| 7.5 | Upload bukti tanpa file | Klik upload tanpa memilih file | Validasi gagal, muncul pesan error "File bukti pembayaran wajib diupload" |
| 7.6 | Akses pembayaran booking bukan miliknya | Customer A mencoba akses `/booking/{id_milik_customer_B}/pay` | Muncul error 403 Forbidden |
| 7.7 | Akses pembayaran booking sudah dibayar | Akses halaman pembayaran booking dengan status selain `pending` | Muncul pesan "Pembayaran sudah diproses" atau redirect |

---

## 8. Review

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 8.1 | Submit review dari booking active | Pada booking `active`, klik "Beri Review", pilih rating 4, isi komentar, submit | Review berhasil dibuat dengan `is_visible = false`, redirect ke my-bookings dengan pesan sukses |
| 8.2 | Submit review — booking bukan active | Coba akses `/booking/{booking_pending}/review` | Redirect dengan pesan error "Review hanya dapat diberikan untuk booking yang aktif" |
| 8.3 | Duplikasi review | Coba submit review kedua pada booking yang sudah direview | Redirect dengan pesan error "Anda sudah memberikan review untuk booking ini" |
| 8.4 | Submit review — booking bukan miliknya | Customer A mencoba submit review ke booking Customer B | Muncul error 403 Forbidden |
| 8.5 | Rating di luar range 1-5 | Manipulasi form, kirim rating 0 atau 6 via request | Validasi gagal, rating harus antara 1 sampai 5 |
| 8.6 | Komentar lebih dari 500 karakter | Isi komentar > 500 karakter | Validasi gagal, muncul pesan error "Komentar maksimal 500 karakter" |
| 8.7 | Submit review tanpa rating (bintang 0) | Kirim form review tanpa memilih rating | Validasi gagal, rating wajib diisi |
| 8.8 | Komentar kosong (opsional) | Submit review dengan rating 5 tanpa mengisi komentar | Review berhasil disimpan (komentar bersifat opsional) |

---

## 9. Service Request

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 9.1 | Membuat service request — cleaning | Pada booking `active`, klik "Request Service", pilih tipe "Cleaning", isi catatan, submit | Service request berhasil dibuat dengan status `pending` |
| 9.2 | Membuat service request — repair | Pada booking `active`, pilih tipe "Repair", isi catatan, submit | Service request berhasil dibuat dengan status `pending` |
| 9.3 | Service request dari booking bukan active | Coba akses service request dari booking `pending`/`cancelled` | Redirect dengan pesan error "Service request hanya dapat dibuat untuk booking yang aktif" |
| 9.4 | Service request tanpa catatan | Submit form service request tanpa mengisi notes | Validasi gagal, muncul pesan error "Catatan wajib diisi" |
| 9.5 | Service request — booking bukan miliknya | Customer A mencoba membuat service request pada booking Customer B | Muncul error 403 Forbidden |

---

## 10. Profile Customer

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 10.1 | Akses halaman profile | Login sebagai customer, akses `/profile` | Halaman profile menampilkan data: name, email, phone, address |
| 10.2 | Update profile — data valid | Edit nama, phone, alamat, klik save | Data berhasil diperbarui, muncul pesan sukses |
| 10.3 | Update email dengan email sudah terdaftar | Ganti email ke email customer lain | Validasi gagal, email sudah digunakan |
| 10.4 | Update email — user perlu verifikasi ulang | Ganti email ke yang baru | User perlu verifikasi email baru (jika fitur ini diimplementasi) |
| 10.5 | Hapus akun | Klik "Delete Account" | Akun terhapus, session diakhiri, redirect ke landing page |
| 10.6 | Hapus akun — ada booking active | Customer dengan booking active mencoba menghapus akun | Akun tetap terhapus (atau dicegah — tergantung implementasi) |

---

## 11. Chat Customer

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 11.1 | Membuka chat widget | Login sebagai customer, navigasi ke dashboard atau my-bookings | Chat bubble/widget muncul di pojok kanan bawah halaman |
| 11.2 | Membuka chat — chat baru | Klik chat bubble, widget terbuka | Menampilkan halaman chat kosong atau sapaan awal. Chat baru otomatis dibuat jika belum ada |
| 11.3 | Mengirim pesan | Ketik pesan, kirim via tombol atau Enter | Pesan tampil di thread chat, terkirim ke staff |
| 11.4 | Menerima pesan (polling) | Tunggu 3 detik setelah staff mengirim pesan | Pesan baru dari staff muncul di chat widget tanpa reload halaman |
| 11.5 | Chat polling berjalan otomatis | Buka chat, biarkan terbuka selama 30 detik | Setiap 3 detik sistem memeriksa pesan baru, tampil otomatis jika ada |
| 11.6 | Akses chat halaman penuh | Akses `/chat/active` (jika route customer tersedia) | Halaman chat penuh dengan thread pesan |

---

## 12. Admin Panel — Login & Akses

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 12.1 | Akses `/admin` sebagai owner | Login sebagai owner@arca.com, akses `/admin` | Berhasil masuk ke Filament admin panel |
| 12.2 | Akses `/admin` sebagai staff | Login sebagai staff, akses `/admin` | Berhasil masuk ke Filament admin panel |
| 12.3 | Akses `/admin` sebagai customer | Login sebagai customer, akses `/admin` | Redirect ke halaman depan dengan pesan error 403 atau "Anda tidak memiliki akses" |
| 12.4 | Akses `/admin` tanpa login | Akses `/admin` tanpa login | Redirect ke halaman login admin `/admin/login` |
| 12.5 | Admin login dengan kredensial salah | Login admin dengan password salah | Gagal login, pesan error ditampilkan |

---

## 13. Admin — Room Types (Staff & Owner)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 13.1 | Melihat daftar room types | Login sebagai staff, navigasi ke RoomTypes | Tabel menampilkan semua room types dengan kolom: Nama, Deskripsi, Harga |
| 13.2 | Menambah room type | Klik "New Room Type", isi nama, deskripsi, harga (Rp 2.000.000), klik Create | Room type baru tersimpan dan muncul di tabel |
| 13.3 | Menambah room type — nama kosong | Kirim form room type tanpa nama | Validasi gagal, nama wajib diisi |
| 13.4 | Menambah room type — harga negatif | Isi harga: -50000 | Validasi gagal, harga harus positif |
| 13.5 | Mengedit room type | Klik edit pada room type, ubah harga, klik Save | Data berhasil diperbarui |
| 13.6 | Menghapus room type tanpa room terkait | Hapus room type yang tidak memiliki kamar | Room type terhapus, data hilang dari tabel |
| 13.7 | Menghapus room type yang memiliki room | Hapus room type yang sudah memiliki room | Muncul pesan error atau room terkait ikut terhapus (tergantung cascade rules) |

---

## 14. Admin — Rooms (Staff & Owner)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 14.1 | Melihat daftar rooms | Login sebagai staff, navigasi ke Rooms | Tabel menampilkan semua rooms: Room Number, Tipe, Status |
| 14.2 | Menambah room | Klik "New Room", pilih room type, isi room number "Kamar 20", status "available", klik Create | Room baru tersimpan |
| 14.3 | Menambah room — nomor duplikat | Tambah room dengan nomor yang sudah ada | Room tetap bisa dibuat (atau validasi error — tergantung implementasi) |
| 14.4 | Mengubah status room | Edit room, ganti status dari "available" ke "maintenance", save | Status room berubah. Room tidak bisa dibooking saat maintenance |
| 14.5 | Menghapus room yang tidak terkait booking | Hapus room tanpa history booking | Room terhapus |
| 14.6 | Menghapus room yang memiliki booking | Hapus room yang sedang/sudah di-booking | Muncul error constraint atau booking terkait terpengaruh |

---

## 15. Admin — Bookings (Staff & Owner)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 15.1 | Melihat daftar bookings | Login sebagai staff, navigasi ke Bookings | Tabel menampilkan semua bookings dengan status, user, room, tanggal |
| 15.2 | Validasi booking — konfirmasi pembayaran | Buka detail booking `review`, verifikasi bukti pembayaran, ubah status ke `active` | Booking menjadi `active`, payment status menjadi `success`, room tetap `occupied` |
| 15.3 | Validasi booking — tolak/cancel | Buka detail booking `review`, tolak bukti pembayaran, ubah status ke `cancelled` | Booking menjadi `cancelled`, room status kembali `available` |
| 15.4 | Melihat bukti pembayaran | Buka detail booking status `review` | Gambar bukti pembayaran tampil/dapat diakses |
| 15.5 | Edit booking (owner only) | Login sebagai owner, edit booking — ubah start_date | Edit berhasil, data berubah |
| 15.6 | Edit booking (staff) | Login sebagai staff, coba edit booking | Tombol edit tidak tersedia atau muncul 403 |
| 15.7 | Hapus booking (owner only) | Login sebagai owner, hapus booking | Booking terhapus, room terkait menjadi `available` |
| 15.8 | Hapus booking (staff) | Login sebagai staff, coba hapus booking | Tombol hapus tidak tersedia atau muncul 403 |

---

## 16. Admin — Reviews (Staff & Owner)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 16.1 | Melihat daftar reviews | Login sebagai staff, navigasi ke Reviews | Tabel menampilkan semua reviews dengan rating, komentar, user, booking, status visible |
| 16.2 | Toggle visibility ON | Klik toggle "Tampil" pada review yang `is_visible = false` | `is_visible` menjadi `true`, review muncul di landing page |
| 16.3 | Toggle visibility OFF | Klik toggle pada review yang `is_visible = true` | `is_visible` menjadi `false`, review hilang dari landing page |
| 16.4 | Hapus review | Hapus review (owner/staff dengan permission) | Review terhapus |

---

## 17. Admin — Service Requests (Staff & Owner)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 17.1 | Melihat daftar service requests | Login sebagai staff, navigasi ke Service Requests | Tabel menampilkan semua requests: tipe, status, user, room, tanggal |
| 17.2 | Update status ke "In Progress" | Buka service request `pending`, ubah status ke `in_progress` | Status berubah, customer (jika ada notifikasi) diberi tahu |
| 17.3 | Update status ke "Completed" | Ubah status service request ke `completed` | Status berubah menjadi `completed` |
| 17.4 | Filter service request berdasarkan status | Gunakan filter tabel untuk menampilkan hanya yang `pending` | Tabel hanya menampilkan service requests dengan status `pending` |

---

## 18. Admin — Users (Owner Only)

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 18.1 | Akses Users sebagai owner | Login sebagai owner, navigasi ke Users | Tabel Users dapat diakses |
| 18.2 | Akses Users sebagai staff | Login sebagai staff, coba akses Users | Menu Users tidak terlihat atau 403 Forbidden |
| 18.3 | Membuat user baru (owner) | Klik "New User", isi data dengan role "staff" atau "customer", submit | User baru tersimpan |
| 18.4 | Mengubah role user | Edit user, ubah role dari "customer" ke "staff" | Role berubah, user sekarang bisa akses admin panel |
| 18.5 | Menghapus user tanpa booking terkait | Hapus user yang tidak memiliki booking/review/service request | User terhapus |
| 18.6 | Menghapus user dengan booking | Hapus user yang memiliki booking history | Muncul error constraint atau data terkait ikut terhapus |

---

## 19. Admin — Chat Staff

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 19.1 | Akses StaffChat | Login sebagai staff, navigasi ke Staff Chat | Halaman chat tampil dengan sidebar daftar chat dan area pesan |
| 19.2 | Sidebar menampilkan semua chat aktif | Kirim pesan dari beberapa customer berbeda | Sidebar menampilkan semua chat dengan nama customer |
| 19.3 | Pilih chat dari sidebar | Klik salah satu chat di sidebar | Thread pesan dari customer tersebut tampil di area utama |
| 19.4 | Mengirim balasan | Ketik pesan di area chat, kirim | Pesan terkirim ke customer, muncul di thread |
| 19.5 | Menerima pesan dari customer (polling) | Customer mengirim pesan saat staff sedang membuka chat | Pesan baru muncul dalam ~3 detik via polling |
| 19.6 | Indikator pesan belum dibaca | Customer mengirim pesan baru | Chat di sidebar menampilkan indikator/tanda pesan baru |

---

## 20. Admin — Dashboard & Revenue

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 20.1 | Dashboard menampilkan statistik | Login sebagai staff/owner, akses `/admin` | Dashboard menampilkan: StatsOverview (total bookings, available rooms, today's bookings, total revenue), RevenueChart, RecentBookings, ReviewStats |
| 20.2 | Revenue chart menampilkan data | Pastikan data monthly_revenues ada | Chart garis menampilkan revenue per bulan |
| 20.3 | Recent bookings table | Lihat tabel "Recent Bookings" | Menampilkan booking terbaru dengan user, room, status |
| 20.4 | Revenue calculation (artisan command) | Jalankan `php artisan app:calculate-monthly-revenue` | Data revenue bulan berjalan dan bulan lalu terhitung dan tersimpan di tabel `monthly_revenues` |
| 20.5 | Revenue calculation — tidak ada booking | Kosongkan tabel bookings, jalankan artisan command | monthly_revenues bernilai 0 untuk bulan tersebut, tidak error |

---

## 21. Logout

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 21.1 | Logout customer | Klik tombol logout pada navbar / dropdown user | Session berakhir, redirect ke landing page, akses `/dashboard` mengarah ke `/login` |
| 21.2 | Logout admin | Klik logout pada Filament admin panel | Session berakhir, redirect ke `/admin/login` |

---

## 22. Keamanan Dasar

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 22.1 | CSRF Protection | Submit form tanpa token CSRF (atau dengan token kadaluarsa) | Request ditolak, HTTP 419 |
| 22.2 | XSS — Input sanitasi | Input `<script>alert('xss')</script>` pada field komentar review | Script tidak dieksekusi, output di-escape |
| 22.3 | SQL Injection | Input `' OR '1'='1` pada form login | Tidak terjadi bypass login, input di-escape oleh Eloquent/parameterized queries |
| 22.4 | Direct access ke file upload | Akses langsung URL file bukti pembayaran tanpa login | File hanya bisa diakses oleh user yang berwenang (atau dilindungi) |
| 22.5 | Akses route verified tanpa verifikasi email | Akses `/booking/1` dengan user belum verifikasi email | Redirect ke halaman verifikasi email |

---

## 23. Responsivitas & Cross-Browser

| No | Skenario Pengujian | Deskripsi Pengujian (Test Case) | Hasil yang Diharapkan | Hasil Pengujian |
|---|---|---|---|---|
| 23.1 | Landing page — Mobile (320px) | Buka landing page di viewport 320px | Layout tetap rapi, tidak ada elemen yang overflow. Mobile menu berfungsi |
| 23.2 | Dashboard — Tablet (768px) | Buka dashboard di viewport 768px | Grid room types menyesuaikan layout tablet |
| 23.3 | My Bookings — Mobile | Buka my-bookings di viewport 375px | Tabel/card booking tetap terbaca, tombol aksi mudah dijangkau |
| 23.4 | Chat widget — Mobile | Buka chat widget di viewport 375px | Chat bubble tidak menutupi konten utama, chat fullscreen jika terlalu kecil |
| 23.5 | Cross-browser — Chrome | Jalankan semua skenario di Chrome | Semua fitur berfungsi normal |
| 23.6 | Cross-browser — Firefox | Jalankan semua skenario di Firefox | Semua fitur berfungsi normal |
| 23.7 | Cross-browser — Edge | Jalankan semua skenario di Edge | Semua fitur berfungsi normal |

---

**Keterangan Kolom Hasil Pengujian:**
- ✓ (Lulus) — Hasil sesuai harapan
- ✗ (Gagal) — Hasil tidak sesuai harapan, perlu perbaikan
- N/A — Tidak dapat diuji
