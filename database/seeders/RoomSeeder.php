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
            'description' => 'Kost premium dengan fasilitas lengkap dan lingkungan yang nyaman untuk mahasiswa maupun pekerja.

Fasilitas kamar:
- AC
- Water heater
- Meja
- Lemari

Fasilitas umum:
- Dapur bersama
- Rooftop area
- CCTV aktif 24 jam
- Penjaga kost 24 jam

Cocok untuk penghuni yang mencari tempat tinggal modern, aman, dan nyaman dengan akses fasilitas yang lengkap.',
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
