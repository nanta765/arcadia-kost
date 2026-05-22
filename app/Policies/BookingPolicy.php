<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    // Mencegah menu Pesanan/Pembayaran muncul di sidebar staf
    public function viewAny(User $user): bool
    {
        return $user->role === 'owner';
    }

    // Mencegah staf mengintip detail pesanan lewat URL langsung
    public function view(User $user, Booking $booking): bool
    {
        return $user->role === 'owner';
    }

    public function create(User $user): bool
    {
        return $user->role === 'owner';
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->role === 'owner';
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->role === 'owner';
    }
}
