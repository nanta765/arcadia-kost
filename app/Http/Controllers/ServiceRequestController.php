<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    // Menampilkan halaman form request
    public function create(Booking $booking)
    {
        // Pastikan hanya pemilik pesanan yang bisa akses
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        // Pastikan status kamar aktif (penghuni sah)
        if ($booking->status !== 'active') {
            return redirect()->back()->with('error', 'Layanan ini hanya untuk penghuni aktif.');
        }

        return view('service.create', compact('booking'));
    }

    // Memproses form yang dikirim
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:cleaning,repair',
            'notes' => 'nullable|string|max:500',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'deadline' => 'required|string|in:Morning 08:00-11:00,Afternoon 13:00-16:00,Evening 17:00-20:00',
        ]);

        ServiceRequest::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'room_id' => $booking->room_id,
            'type' => $request->type,
            'notes' => $request->notes,
            'scheduled_date' => $request->scheduled_date,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.my-bookings')->with('success', 'Permintaan layanan berhasil dikirim! Staf kami akan segera datang.');
    }
}