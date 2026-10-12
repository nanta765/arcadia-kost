<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Urutan penting:
     * 1. AdminUserSeeder  -> buat admin (owner/staff) + customer
     * 2. RoomSeeder       -> buat tipe kamar + 18 kamar
     * 3. BookingSeeder    -> buat booking demo (butuh customer + kamar)
     * 4. ReviewSeeder     -> buat review demo (butuh booking)
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
