<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

        // Dummy kost bank info for the manual transfer flow
        $bank = config('payment.bank');
        $bankName = $bank['name'];
        $bankAccount = $bank['account_number'];
        $bankHolder = $bank['account_holder'];

        return view('booking.payment', compact(
            'booking', 'roomName', 'duration', 'monthlyRent', 'deposit', 'serviceFee',
            'totalAmount', 'bankName', 'bankAccount', 'bankHolder'
        ));
    }

    // 2. Mengolah Upload Gambar Bukti Transfer
    public function processCheckout(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:bank_transfer,on_site',
        ]);

        $method = $request->input('payment_method');

        if ($method === 'bank_transfer') {
            $request->validate([
                'payment_receipt' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            ]);

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

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => $method,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.my-bookings')
            ->with('success', 'Pembayaran berhasil diproses! Silakan tunggu konfirmasi Admin.');
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
