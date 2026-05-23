<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\RoomType;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ChatController;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/dashboard', function () {
    $roomTypes = RoomType::all();
    return view('dashboard', compact('roomTypes'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    // Route Dashboard Katalog
    Route::get('/dashboard', function () {
        $roomTypes = RoomType::all();
        return view('dashboard', compact('roomTypes'));
    })->name('dashboard');

    // Route untuk menampilkan Form Booking
    Route::get('/booking/{roomType}', [BookingController::class, 'create'])->name('booking.create');

    // Route untuk memproses Data Booking (Tombol Submit)
    Route::post('/booking/{roomType}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::get('/booking/{booking}/pay', [BookingController::class, 'pay'])->name('booking.pay');
    Route::post('/booking/{booking}/upload-proof', [BookingController::class, 'uploadProof'])->name('booking.upload_proof');
    Route::post('/booking/{booking}/extend', [BookingController::class, 'extend'])->name('booking.extend');

    Route::get('/booking/{booking}/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/booking/{booking}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/booking/{booking}/service-request', [ServiceRequestController::class, 'create'])->name('service.create');
    Route::post('/booking/{booking}/service-request', [ServiceRequestController::class, 'store'])->name('service.store');

    // Chat routes
    Route::get('/chat/active', [ChatController::class, 'getOrCreateChat'])->name('chat.active');
    Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/api/staff/chats', [ChatController::class, 'getStaffChats'])->name('staff.chats');
});

