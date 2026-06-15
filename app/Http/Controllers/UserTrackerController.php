<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserTrackerController extends Controller
{
    private function authorize(): void
    {
        if (auth()->user()?->role !== 'owner') {
            abort(403, 'Unauthorized.');
        }
    }

    public function profit(Request $request): JsonResponse
    {
        $this->authorize();

        $query = Booking::selectRaw("
                to_char(start_date, 'Mon YYYY') as label,
                EXTRACT(YEAR FROM start_date) as year,
                EXTRACT(MONTH FROM start_date) as month,
                COALESCE(SUM(total_price), 0) as gross,
                COUNT(*) as booking_count
            ")
            ->whereIn('status', ['active', 'completed', 'review', 'pending']);

        if ($userId = $request->query('user_id')) {
            $query->where('user_id', $userId);
        }

        $rows = $query
            ->groupBy(DB::raw("EXTRACT(YEAR FROM start_date)"), DB::raw("EXTRACT(MONTH FROM start_date)"), DB::raw("to_char(start_date, 'Mon YYYY')"))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $grossData = [];
        $netData = [];

        foreach ($rows as $row) {
            $labels[] = $row->label;
            $gross = (int) $row->gross;
            $grossData[] = $gross;
            $netData[] = $gross - ($row->booking_count * 1_400_000);
        }

        return response()->json([
            'labels'      => $labels,
            'gross'       => $grossData,
            'net'         => $netData,
            'total_gross' => array_sum($grossData),
            'total_net'   => array_sum($netData),
        ]);
    }

    public function index(): JsonResponse
    {
        $this->authorize();

        $users = User::with(['bookings' => function ($q) {
                $q->latest()->take(1);
            }, 'bookings.room.roomType'])
            ->where('role', 'customer')
            ->orderBy('name')
            ->get();

        return response()->json([
            'users' => $users->map(function ($user) {
                $lastBooking = $user->bookings->first();

                return [
                    'id'              => $user->id,
                    'name'            => $user->name,
                    'email'           => $user->email,
                    'profession'      => $user->profession,
                    'profile_photo'   => $user->profile_photo,
                    'last_booking'    => $lastBooking ? [
                        'room_number' => $lastBooking->room?->room_number,
                        'room_type'   => $lastBooking->room?->roomType?->name,
                        'status'      => $lastBooking->status,
                    ] : null,
                    'total_bookings'  => $user->bookings->count(),
                ];
            })->values(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $this->authorize();

        $id = $request->query('id');
        if (!$id) {
            return response()->json(['error' => 'User ID is required.'], 422);
        }

        $user = User::with([
            'bookings' => function ($query) {
                $query->with(['room.roomType', 'payments'])
                      ->orderBy('created_at', 'desc');
            },
        ])->find($id);

        if (!$user) {
            return response()->json(['found' => false, 'message' => 'User not found.']);
        }

        $bookings = $user->bookings;

        return response()->json([
            'found'    => true,
            'user'     => $this->formatUser($user),
            'bookings' => $this->formatBookings($bookings),
            'payments' => $this->formatPayments($bookings),
        ]);
    }

    private function formatUser(User $user): array
    {
        return [
            'id'             => $user->id,
            'name'           => $user->name,
            'email'          => $user->email,
            'role'           => $user->role,
            'phone_number'   => $user->phone_number,
            'profession'     => $user->profession,
            'address'        => $user->address,
            'profile_photo'  => $user->profile_photo,
            'created_at'     => $user->created_at?->format('Y-m-d'),
        ];
    }

    private function formatBookings($bookings): array
    {
        return $bookings->map(function ($booking) {
            $statusColor = match ($booking->status) {
                'active', 'completed'   => 'success',
                'pending'               => 'warning',
                'review'                => 'info',
                'cancelled'             => 'danger',
                default                 => 'gray',
            };

            return [
                'id'              => $booking->id,
                'room_number'     => $booking->room?->room_number,
                'room_type'       => $booking->room?->roomType?->name,
                'start_date'      => $booking->start_date,
                'end_date'        => $booking->end_date,
                'duration_months' => $booking->duration_months,
                'total_price'     => (int) $booking->total_price,
                'status'          => $booking->status,
                'status_color'    => $statusColor,
                'created_at'      => $booking->created_at?->toDateString(),
            ];
        })->values()->toArray();
    }

    private function formatPayments($bookings): array
    {
        return $bookings->flatMap(function ($booking) {
            return $booking->payments->map(function ($payment) use ($booking) {
                $statusColor = match ($payment->status) {
                    'success'   => 'success',
                    'pending'   => 'warning',
                    'failed'    => 'danger',
                    default     => 'gray',
                };

                return [
                    'id'             => $payment->id,
                    'booking_id'     => $booking->id,
                    'amount'         => (int) $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'status'         => $payment->status,
                    'status_color'   => $statusColor,
                    'date'           => $payment->created_at?->toDateString(),
                ];
            });
        })->values()->toArray();
    }
}
