<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan halaman form ulasan untuk anak kost
    public function create(Booking $booking)
    {
        // Pastikan hanya pemilik pesanan yang bisa akses
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        // Pastikan status booking sudah 'active' (hanya penghuni sah yang bisa mengulas)
        if ($booking->status !== 'active') {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan ulasan untuk kamar yang sudah aktif.');
        }

        // Cek apakah user sudah pernah memberikan ulasan untuk pesanan ini agar tidak dobel
        if ($booking->review) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        // Lemparkan data ke view (Nanti kita buat file view-nya di resources/views/review/create.blade.php)
        return view('review.create', compact('booking'));
    }

    // Memproses data form ulasan (bintang dan komentar)
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi rating wajib 1-5, komentar opsional
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Simpan data ulasan ke tabel reviews
        Review::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'room_id' => $booking->room_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Asumsi nama route untuk halaman My Bookings adalah 'my-bookings'
        return redirect()->route('my-bookings')->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
