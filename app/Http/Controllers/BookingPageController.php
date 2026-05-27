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

    public function details(Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->route('booking.page')->with('error', 'Room is no longer available.');
        }

        $room->load('roomType');

        return view('booking.details', compact('room'));
    }

    public function store(Request $request, Room $room)
    {
        if ($room->status !== 'available') {
            return back()->with('error', 'This room is no longer available.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration'   => 'required|integer|min:1|max:12',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $duration = (int) $request->duration;
        $endDate = $startDate->copy()->addMonths($duration);
        $totalPrice = $room->roomType->price * $duration;

        Booking::create([
            'user_id'         => Auth::id(),
            'room_id'         => $room->id,
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'duration_months' => $duration,
            'total_price'     => $totalPrice,
            'status'          => 'pending',
        ]);

        $room->update(['status' => 'occupied']);

        $booking = Booking::where('user_id', Auth::id())->latest()->first();

        return redirect()->route('booking.pay', $booking)
            ->with('success', 'Booking created! Please complete your payment.');
    }
}