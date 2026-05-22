<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    // 1. Menampilkan Halaman Form
    public function create(RoomType $roomType)
    {
        return view('booking.create', compact('roomType'));
    }

    // 2. Memproses Data saat Form di-submit
    public function store(Request $request, RoomType $roomType)
    {
        // Validasi inputan user
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1', // Sewa berapa bulan
        ]);

        // Cek apakah ada kamar fisik yang statusnya 'available' untuk tipe ini
        $availableRoom = Room::where('room_type_id', $roomType->id)
            ->where('status', 'available')
            ->first();

        // Jika tidak ada kamar kosong, kembalikan dengan pesan error
        if (!$availableRoom) {
            return back()->with('error', 'Mohon maaf, semua kamar untuk tipe ini sedang penuh.');
        }

        // Hitung tanggal selesai dan total harga
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addMonths((int) $request->duration);
        $totalPrice = $roomType->price * (int) $request->duration;

        // Simpan ke database bookings
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $availableRoom->id,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'duration_months' => (int) $request->duration, // <-- TAMBAHKAN BARIS INI
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Ubah status kamar menjadi occupied agar tidak bisa dipesan orang lain
        $availableRoom->update(['status' => 'occupied']);

        // Arahkan kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Booking berhasil! Anda mendapatkan ' . $availableRoom->room_number);
    }

    public function myBookings()
    {
        // Ambil data booking milik user ini, urutkan dari yang terbaru
        // Kita juga memuat (eager load) relasi 'room' dan 'room.roomType' agar tidak memberatkan database
        $bookings = Booking::with(['room', 'room.roomType'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-bookings', compact('bookings'));
    }

    public function pay(Booking $booking)
    {
        // Validasi pengaman agar tidak diintip user lain
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        // Detail Rekening Pemilik Kost
        $namaBank = "BCA";
        $noRekening = "1234567890";
        $atasNama = "Kost Arca Manajemen";
        $nominal = "Rp " . number_format($booking->total_price, 0, ',', '.');

        // Menyusun teks informasi yang akan muncul saat QR di-scan
        $qrContent = "TRANSFER MANUAL KOST ARCA\n";
        $qrContent .= "Bank: {$namaBank}\n";
        $qrContent .= "No. Rek: {$noRekening}\n";
        $qrContent .= "A.N: {$atasNama}\n";
        $qrContent .= "Nominal: {$nominal}\n";
        $qrContent .= "Booking ID: #{$booking->id}";

        // Generate QR Code berbentuk SVG mentah
        $qrCode = QrCode::size(220)
            ->backgroundColor(255, 255, 255)
            ->color(44, 62, 80) // Warna gelap yang elegan
            ->generate($qrContent);

        return view('booking.payment', compact('booking', 'qrCode', 'noRekening', 'atasNama', 'namaBank'));
    }

    // 2. Mengolah Upload Gambar Bukti Transfer
    public function uploadProof(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi ketat file gambar resi
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:3072', // Maksimal 3MB
        ]);

        if ($request->hasFile('proof_of_payment')) {
            // Hapus foto lama jika user mengunggah ulang resi baru
            if ($booking->proof_of_payment) {
                Storage::disk('public')->delete($booking->proof_of_payment);
            }

            // Simpan gambar baru ke folder storage/app/public/proofs
            $path = $request->file('proof_of_payment')->store('proofs', 'public');

            // Update data di database dan ubah status menjadi review (menunggu konfirmasi admin)
            $booking->update([
                'proof_of_payment' => $path,
                'status' => 'review',
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Silakan tunggu konfirmasi Admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function storeRequest(Request $request, Booking $booking)
    {
        $request->validate([
            'type' => 'required|string', // misal nilainya 'cleaning'
            'notes' => 'nullable|string|max:500',
        ]);

        ServiceRequest::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'room_id' => $booking->room_id,
            'type' => $request->type,
            'notes' => $request->notes,
            'status' => 'pending', // Otomatis masuk sebagai antrean baru
        ]);

        return redirect()->back()->with('success', 'Permintaan Anda telah dikirim ke Staff Kost!');
    }
}
