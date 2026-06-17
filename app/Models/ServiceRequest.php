<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected static function booted(): void
    {
        static::updating(function (self $request) {
            if ($request->isDirty('status')) {
                $request->completed_at = $request->status === 'completed' ? now() : null;
            }
        });
    }

    protected $fillable = [
        'booking_id',
        'user_id',
        'room_id',
        'type',
        'notes',
        'status',
        'deadline',
        'scheduled_date',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'string',
            'scheduled_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}