<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'profession',
        'address',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- PENGATURAN HAK AKSES FILAMENT ---
    public function canAccessPanel(Panel $panel): bool
    {
        // BARU: Sekarang sistem akan mengecek kolom 'role', bukan mencocokkan email lagi.
        // Hanya akun yang punya role 'owner' dan 'staff' yang diizinkan masuk ke /admin
        return in_array($this->role, ['owner', 'staff']);
    }

    // --- RELASI DATABASE ---

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function customerChats()
    {
        return $this->hasMany(Chat::class, 'customer_id');
    }

    public function staffChats()
    {
        return $this->hasMany(Chat::class, 'staff_id');
    }

    public function sentChatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }
}