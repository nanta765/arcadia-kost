<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingPageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\UserTrackerController;
use Illuminate\Support\Facades\Route;

// ── Public ─────────────────────────────────────────────────
Route::get('/', LandingPageController::class)->name('home');

// ── Breeze auth routes ────────────────────────────────────
require __DIR__ . '/auth.php';

// ── Authenticated (profile) ────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Verified ───────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking — room catalog
    Route::controller(BookingPageController::class)->group(function () {
        Route::get('/book', 'show')->name('booking.page');
        Route::get('/book/{room}/details', 'details')->name('booking.details')->whereNumber('room');
        Route::post('/book/{room}', 'store')->name('booking.store-room')->whereNumber('room');
    });

    // Bookings
    Route::prefix('booking')->name('booking.')->controller(BookingController::class)->group(function () {
        Route::get('/my-bookings', 'myBookings')->name('my-bookings');
        Route::get('/{roomType}', 'create')->name('create')->whereNumber('roomType');
        Route::post('/{roomType}', 'store')->name('store')->whereNumber('roomType');
        Route::get('/{booking}/pay', 'pay')->name('pay')->whereNumber('booking');
        Route::post('/{booking}/checkout', 'processCheckout')->name('checkout')->whereNumber('booking');
        Route::post('/{booking}/extend', 'extend')->name('extend')->whereNumber('booking');
    });

    // Reviews
    Route::prefix('booking/{booking}')->name('review.')->controller(ReviewController::class)->group(function () {
        Route::get('/review', 'create')->name('create');
        Route::post('/review', 'store')->name('store');
    })->whereNumber('booking');

    // Service requests
    Route::prefix('booking/{booking}/service-request')->name('service.')->controller(ServiceRequestController::class)->group(function () {
        Route::get('/', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    })->whereNumber('booking');

    // Chat
    Route::prefix('chat')->name('chat.')->controller(ChatController::class)->group(function () {
        Route::get('/active', 'getOrCreateChat')->name('active');
        Route::get('/{chat}/messages', 'getMessages')->name('messages')->whereNumber('chat');
        Route::post('/{chat}/message', 'sendMessage')->name('send')->whereNumber('chat');
        Route::get('/staff', 'getStaffChats')->name('staff');
    });

    // Admin User Tracker API (must not collide with Filament /admin/users resource)
    Route::get('/admin/tracker/customers', [UserTrackerController::class, 'index'])->name('admin.tracker.customers');
    Route::get('/admin/tracker/customers/search', [UserTrackerController::class, 'search'])->name('admin.tracker.customers.search');
    Route::get('/admin/tracker/profit', [UserTrackerController::class, 'profit'])->name('admin.tracker.profit');
});
