<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Siapa yang bisa melihat menu "Pengguna" di sidebar dasbor admin?
    public function viewAny(User $user): bool
    {
        // Hanya owner yang boleh melihat daftar pengguna
        return $user->role === 'owner';
    }

    // Siapa yang bisa melihat detail spesifik satu akun pengguna?
    public function view(User $user, User $model): bool
    {
        return $user->role === 'owner';
    }

    // Siapa yang bisa menambah pengguna baru (misal: merekrut staff baru)?
    public function create(User $user): bool
    {
        return $user->role === 'owner';
    }

    // Siapa yang bisa mengedit data pengguna?
    public function update(User $user, User $model): bool
    {
        return $user->role === 'owner';
    }

    // Siapa yang bisa menghapus akun pengguna (memecat staff)?
    public function delete(User $user, User $model): bool
    {
        return $user->role === 'owner';
    }
}
