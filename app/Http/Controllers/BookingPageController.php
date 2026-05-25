<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingPageController extends Controller
{
    public function show()
    {
        $rooms = Room::with('roomType')
            ->orderBy('room_number')
            ->get();

        return view('booking.booking-page', compact('rooms'));
    }

    public function store(Request $request, Room $room)
    {
        if ($room->status !== 'available') {
            return back()->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addMonth();
        $totalPrice = $room->roomType->price;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_months' => 1,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $room->update(['status' => 'occupied']);

        $booking = Booking::where('user_id', Auth::id())->latest()->first();

        return redirect()->route('booking.pay', $booking)
            ->with('success', 'Booking berhasil! Silakan selesaikan pembayaran.');
    }
}