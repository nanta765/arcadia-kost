<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingPageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceRequestController;
use App\Models\Room;
use App\Models\Review;
use App\Models\RoomType;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────
Route::get('/', LandingPageController::class)->name('home');

// ── Breeze auth routes ─────────────────────────────────
require __DIR__ . '/auth.php';

// ── Authenticated (profile) ─────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Verified ────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.home-nanta', [
            'roomTypes'      => RoomType::with('rooms')->get(),
            'availableRooms' => Room::where('status', 'available')->count(),
            'averageRating'  => round(Review::avg('rating') ?? 0, 1),
            'totalReviews'   => Review::count(),
        ]);
    })->name('dashboard');

    // Booking — new main booking page
    Route::get('/book', [BookingPageController::class, 'show'])->name('booking.page');
    Route::post('/book/{room}', [BookingPageController::class, 'store'])->name('booking.store-room');

    // Bookings
    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking/{roomType}', 'create')->name('booking.create');
        Route::post('/booking/{roomType}', 'store')->name('booking.store');
        Route::get('/booking/{booking}/pay', 'pay')->name('booking.pay');
        Route::post('/booking/{booking}/upload-proof', 'uploadProof')->name('booking.upload_proof');
        Route::post('/booking/{booking}/extend', 'extend')->name('booking.extend');
        Route::post('/checkout/process', 'processCheckout')->name('checkout.process');
    });

    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');

    // Reviews
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/booking/{booking}/review', 'create')->name('review.create');
        Route::post('/booking/{booking}/review', 'store')->name('review.store');
    });

    // Service requests
    Route::controller(ServiceRequestController::class)->group(function () {
        Route::get('/booking/{booking}/service-request', 'create')->name('service.create');
        Route::post('/booking/{booking}/service-request', 'store')->name('service.store');
    });

    // Chat (customer)
    Route::prefix('chat')->name('chat.')->controller(ChatController::class)->group(function () {
        Route::get('/active', 'getOrCreateChat')->name('active');
        Route::get('/{chat}/messages', 'getMessages')->name('messages');
        Route::post('/{chat}/message', 'sendMessage')->name('send');
        Route::get('/staff', 'getStaffChats')->name('staff');
    });
});

