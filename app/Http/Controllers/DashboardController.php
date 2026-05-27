<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeBooking = Booking::with(['room.roomType'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $serviceRequests = ServiceRequest::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentPayments = Payment::with('booking.room.roomType')
            ->whereHas('booking', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(10)
            ->get();

        $recentActivity = collect()
            ->concat($bookings->map(fn($b) => [
                'type'    => 'booking',
                'date'    => $b->created_at,
                'title'   => 'Booking — Room ' . $b->room->room_number . ' (' . $b->room->roomType->name . ')',
                'amount'  => $b->total_price,
                'status'  => $b->status,
                'icon'    => 'night_shelter',
            ]))
            ->concat($recentPayments->map(fn($p) => [
                'type'    => 'payment',
                'date'    => $p->created_at,
                'title'   => 'Payment — ' . ($p->booking->room->roomType->name ?? 'N/A'),
                'amount'  => $p->amount,
                'status'  => $p->status,
                'icon'    => 'payments',
            ]))
            ->concat($serviceRequests->map(fn($s) => [
                'type'    => 'service',
                'date'    => $s->created_at,
                'title'   => ucfirst($s->type) . ' Request — Room ' . ($s->room->room_number ?? 'N/A'),
                'amount'  => null,
                'status'  => $s->status,
                'icon'    => $s->type === 'cleaning' ? 'mop' : 'build',
            ]))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        $daysUntilDue = null;
        $nextDueDate = null;
        if ($activeBooking) {
            $dueDay = (int) \Carbon\Carbon::parse($activeBooking->start_date)->day;
            $today = now()->startOfDay();

            // Build the due date for this month; if the day doesn't exist
            // (e.g. 31 in June), use the last day of this month.
            $daysInMonth = $today->daysInMonth;
            $actualDay = min($dueDay, $daysInMonth);
            $nextDue = $today->copy()->setDay($actualDay);

            if ($nextDue->lt($today)) {
                $nextDue->addMonthNoOverflow();
                $daysInNext = $nextDue->daysInMonth;
                $finalDay = min($dueDay, $daysInNext);
                $nextDue->setDay($finalDay);
            }

            if ($nextDue->isSameDay($today)) {
                $daysUntilDue = 0;
            } else {
                $daysUntilDue = (int) $today->diffInDays($nextDue);
            }
            $nextDueDate = $nextDue;
        }

        return view('pages.dashboard', [
            'activeBooking'      => $activeBooking,
            'bookings'           => $bookings,
            'recentActivity'     => $recentActivity,
            'pendingRequests'    => $serviceRequests->where('status', 'pending')->count(),
            'availableRooms'     => Room::where('status', 'available')->count(),
            'averageRating'      => round(Review::avg('rating') ?? 0, 1),
            'totalReviews'       => Review::count(),
            'wifiPassword'       => env('WIFI_PASSWORD', 'ARCADIA_2025_RES'),
            'daysUntilDue'       => $daysUntilDue,
            'nextDueDate'        => $nextDueDate,
        ]);
    }
}
