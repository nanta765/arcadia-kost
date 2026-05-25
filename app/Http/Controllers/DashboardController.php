<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;
use App\Models\RoomType;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.home-nanta', [
            'roomTypes'      => RoomType::with('rooms')->get(),
            'availableRooms' => Room::where('status', 'available')->count(),
            'averageRating'  => round(Review::avg('rating') ?? 0, 1),
            'totalReviews'   => Review::count(),
        ]);
    }
}
