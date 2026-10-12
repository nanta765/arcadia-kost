<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Booking extends Model
{
    // Tambahkan baris ini agar semua kolom bebas diisi oleh form
    protected $guarded = [];

    // Pastikan relasi ini juga sudah ada ya
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    protected static function booted()
    {
        static::deleted(function ($booking) {
            // Ketika booking dihapus, kembalikan status kamar menjadi available
            if ($booking->room) {
                $booking->room->update(['status' => 'available']);
            }
        });
    }
}
