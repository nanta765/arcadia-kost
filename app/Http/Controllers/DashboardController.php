<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ServiceRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeBooking = Booking::with(['room.roomType', 'payments'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        // Completed bookings that haven't been reviewed yet
        $completedWithoutReview = Booking::with(['room.roomType'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->latest()
            ->get();

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

        // ── Billing Periods ─────────────────────────────────
        $billingPeriods = [];
        $daysUntilDue = null;
        $nextDueDate = null;

        if ($activeBooking) {
            $startDate = Carbon::parse($activeBooking->start_date);
            $dueDay = (int) $startDate->day;
            $today = now()->startOfDay();
            $monthsPaid = $activeBooking->payments->where('status', 'success')->count();
            $monthlyRent = (int) $activeBooking->room->roomType->price;

            for ($i = 0; $i < $activeBooking->duration_months; $i++) {
                $periodStart = $startDate->copy()->addMonthsNoOverflow($i);
                $dueDate = $periodStart->copy();

                // Clamp day to month length (e.g. 31 → 30 for June)
                $daysInMonth = $dueDate->daysInMonth;
                $dueDate->setDay(min($dueDay, $daysInMonth));

                if ($i < $monthsPaid) {
                    $status = 'paid';
                } elseif ($dueDate->lt($today)) {
                    $status = 'overdue';
                } elseif ($dueDate->diffInDays($today) <= 3) {
                    $status = 'due_soon';
                } else {
                    $status = 'upcoming';
                }

                $billingPeriods[] = [
                    'period'      => $i + 1,
                    'month_label' => $periodStart->format('M Y'),
                    'due_date'    => $dueDate->copy(),
                    'amount'      => $monthlyRent,
                    'status'      => $status,
                ];
            }

            // Current/next pending period
            $nextPeriod = collect($billingPeriods)->firstWhere('status', '!=', 'paid');
            if ($nextPeriod) {
                $nextDueDate = $nextPeriod['due_date'];
                $dueDate = $nextPeriod['due_date'];
                $daysUntilDue = (int) $dueDate->diffInDays($today, false);
            }
        }

        // ── Cleaning Schedule ───────────────────────────────
        $cleaningSchedules = ServiceRequest::with('room')
            ->where('user_id', $user->id)
            ->where('type', 'cleaning')
            ->whereNotNull('scheduled_date')
            ->where('scheduled_date', '>=', now()->startOfDay())
            ->orderBy('scheduled_date')
            ->get();

        $pastCleanings = ServiceRequest::with('room')
            ->where('user_id', $user->id)
            ->where('type', 'cleaning')
            ->whereNotNull('scheduled_date')
            ->where('scheduled_date', '<', now()->startOfDay())
            ->orderBy('scheduled_date', 'desc')
            ->take(3)
            ->get();

        return view('pages.dashboard', [
            'activeBooking'           => $activeBooking,
            'completedWithoutReview'  => $completedWithoutReview,
            'bookings'                => $bookings,
            'recentActivity'          => $recentActivity,
            'pendingRequests'         => $serviceRequests->where('status', 'pending')->count(),
            'availableRooms'          => Room::where('status', 'available')->count(),
            'averageRating'           => round(Review::avg('rating') ?? 0, 1),
            'totalReviews'            => Review::count(),
            'wifiPassword'            => env('WIFI_PASSWORD', 'ARCADIA_2025_RES'),
            'billingPeriods'          => $billingPeriods,
            'daysUntilDue'            => $daysUntilDue,
            'nextDueDate'             => $nextDueDate,
            'cleaningSchedules'       => $cleaningSchedules,
            'pastCleanings'           => $pastCleanings,
        ]);
    }
}
