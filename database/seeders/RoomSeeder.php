<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Tipe Kamarnya dulu
        $standardType = RoomType::create([
            'name' => 'Standard Room',
            'description' => 'Premium boarding with complete facilities and a comfortable environment for students and professionals.

Room amenities:
- AC
- Water heater
- Desk
- Wardrobe

Shared facilities:
- Communal kitchen
- Rooftop area
- 24/7 CCTV surveillance
- 24/7 on-site staff

Perfect for residents seeking a modern, safe, and comfortable living space with full access to premium amenities.',
            'price' => 1750000,
        ]);

        // 2. Looping untuk membuat 18 Pintu Kamar fisik
        for ($i = 1; $i <= 18; $i++) {
            $number = str_pad($i, 2, '0', STR_PAD_LEFT);

            Room::create([
                'room_type_id' => $standardType->id, // Sambungkan ke tipe Standard
                'room_number' => 'Kamar ' . $number,
                'status' => 'available',
            ]);
        }
    }
}
