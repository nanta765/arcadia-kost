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

        // Hitung tanggal selesai dan total harga (selalu 1 bulan)
        $startDate = Carbon::parse($request->start_date);
        $duration = 1;
        $endDate = $startDate->copy()->addMonths($duration);
        $totalPrice = $roomType->price * $duration;

        // Simpan ke database bookings
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $availableRoom->id,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'duration_months' => $duration, // <-- FIXED TO 1 MONTH
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Ubah status kamar menjadi occupied agar tidak bisa dipesan orang lain
        $availableRoom->update(['status' => 'occupied']);

        // Arahkan kembali ke dashboard dengan pesan sukses
        $booking = Booking::where('user_id', Auth::id())->latest()->first();

        return redirect()->route('booking.pay', $booking)
            ->with('success', 'Booking berhasil! Silakan selesaikan pembayaran.');
    }

    public function myBookings()
    {
        // Ambil data booking milik user ini, urutkan dari yang terbaru
        // Kita juga memuat (eager load) relasi 'room' dan 'room.roomType' agar tidak memberatkan database
        $bookings = Booking::with(['room', 'room.roomType', 'review'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-bookings', compact('bookings'));
    }

    public function pay(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        $booking->load('room.roomType');

        $roomName = $booking->room->roomType->name . ' - ' . $booking->room->room_number;
        $duration = $booking->duration_months . ' Month(s)';
        $monthlyRent = $booking->total_price;
        $deposit = 0;
        $serviceFee = 0;
        $totalAmount = $booking->total_price;

        // Bank info & QR
        $bankName = 'BCA';
        $bankAccount = '1234567890';
        $bankHolder = 'Kost Arca Manajemen';

        $qrContent = "TRANSFER KOST ARCA\n";
        $qrContent .= "Bank: {$bankName}\n";
        $qrContent .= "No. Rek: {$bankAccount}\n";
        $qrContent .= "A.N: {$bankHolder}\n";
        $qrContent .= "Nominal: Rp " . number_format($totalAmount, 0, ',', '.') . "\n";
        $qrContent .= "Booking ID: #{$booking->id}";

        $qrCode = QrCode::size(220)
            ->backgroundColor(255, 255, 255)
            ->color(0, 38, 42)
            ->generate($qrContent);

        return view('booking.payment', compact(
            'booking', 'roomName', 'duration', 'monthlyRent', 'deposit', 'serviceFee',
            'totalAmount', 'qrCode', 'bankName', 'bankAccount', 'bankHolder'
        ));
    }

    // 2. Mengolah Upload Gambar Bukti Transfer
    public function processCheckout(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:qr,bank_transfer',
            'payment_receipt' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:3072',
        ]);

        if ($request->hasFile('payment_receipt')) {
            if ($booking->proof_of_payment) {
                Storage::disk('public')->delete($booking->proof_of_payment);
            }
            $path = $request->file('payment_receipt')->store('proofs', 'public');
            $booking->update([
                'proof_of_payment' => $path,
                'status' => 'review',
            ]);
        } else {
            $booking->update(['status' => 'review']);
        }

        return redirect()->route('my-bookings')
            ->with('success', 'Pembayaran berhasil diproses! Silakan tunggu konfirmasi Admin.');
    }

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

    public function extend(Request $request, Booking $booking)
    {
        // Pastikan hanya pemilik booking yang bisa perpanjang
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        // Buat booking baru melanjutkan tanggal selesai yang lama
        $newStartDate = Carbon::parse($booking->end_date);
        $duration = 1;
        $newEndDate = $newStartDate->copy()->addMonths($duration);
        
        // Meload room dan roomType untuk mendapatkan harga
        $booking->load('room.roomType');
        $totalPrice = $booking->room->roomType->price * $duration;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $booking->room_id,
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'duration_months' => $duration,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $newBooking = Booking::where('user_id', Auth::id())->latest()->first();

        return redirect()->route('booking.pay', $newBooking)
            ->with('success', 'Perpanjangan sewa berhasil dibuat. Silakan selesaikan pembayaran.');
    }
}
