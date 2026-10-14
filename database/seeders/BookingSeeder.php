<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Buat beberapa booking demo untuk customer agar data dashboard & review terisi.
     * Dijalankan SETELAH AdminUserSeeder (butuh customer) dan RoomSeeder (butuh kamar).
     */
    public function run(): void
    {
        $rooms = Room::orderBy('id')->get();

        if ($rooms->isEmpty()) {
            $this->command->warn('Tidak ada kamar. Jalankan RoomSeeder dulu. Melewati BookingSeeder.');
            return;
        }

        // Pasangan customer -> status booking demo
        $plan = [
            ['email' => 'rizky@gmail.com', 'status' => 'active'],
            ['email' => 'sari@gmail.com',  'status' => 'active'],
            ['email' => 'dimas@gmail.com', 'status' => 'completed'],
            ['email' => 'nanta@gmail.com', 'status' => 'pending'],
        ];

        $roomIndex = 0;

        foreach ($plan as $item) {
            $user = User::where('email', $item['email'])->first();
            if (! $user) {
                continue;
            }

            $room = $rooms[$roomIndex % $rooms->count()];
            $roomIndex++;

            $duration = 6;
            $pricePerMonth = optional($room->roomType)->price ?? 1750000;
            $startDate = now()->subMonths(2)->startOfMonth();

            Booking::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $startDate->toDateString(),
                'end_date' => $startDate->copy()->addMonths($duration)->toDateString(),
                'duration_months' => $duration,
                'total_price' => $pricePerMonth * $duration,
                'status' => $item['status'],
            ]);

            // Tandai kamar sebagai terisi untuk booking yang aktif
            if (in_array($item['status'], ['active', 'completed'], true)) {
                $room->update(['status' => 'occupied']);
            }
        }
    }
}
