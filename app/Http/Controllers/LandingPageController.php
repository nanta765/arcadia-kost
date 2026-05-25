<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\RoomType;

class LandingPageController extends Controller
{
    public function __invoke()
    {
        $reviews = Review::visible()
            ->with('user')
            ->latest()
            ->limit(6)
            ->get();

        $roomTypes = RoomType::with('rooms')->get();

        return view('pages.landing', compact('reviews', 'roomTypes'));
    }
}