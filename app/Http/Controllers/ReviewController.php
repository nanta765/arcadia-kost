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

        // Only completed stays can be reviewed
        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan ulasan setelah masa tinggal selesai.');
        }

        // Cek apakah user sudah pernah memberikan ulasan untuk pesanan ini agar tidak dobel
        if ($booking->review) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $durationDone = $booking->end_date && now()->startOfDay()->gte($booking->end_date);

        return view('review.create', compact('booking', 'durationDone'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan ulasan setelah masa tinggal selesai.');
        }

        if ($booking->review) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        if ($booking->end_date && now()->startOfDay()->lt($booking->end_date)) {
            return redirect()->back()->with('error', 'Masa tinggal Anda belum berakhir. Silakan kembali setelah ' . \Carbon\Carbon::parse($booking->end_date)->format('d M Y') . '.');
        }

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
        return redirect()->route('booking.my-bookings')->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
