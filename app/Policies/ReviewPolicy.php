<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['owner', 'staff']);
    }

    public function view(User $user, Review $review): bool
    {
        return in_array($user->role, ['owner', 'staff']);
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->role === 'owner'; // Hanya owner yang boleh menghapus ulasan fisik
    }
}
