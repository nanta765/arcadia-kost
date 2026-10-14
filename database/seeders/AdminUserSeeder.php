<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Buat akun admin (owner & staff) serta beberapa akun customer demo.
     * Hanya role 'owner' dan 'staff' yang bisa masuk ke panel /admin
     * (lihat User::canAccessPanel()).
     */
    public function run(): void
    {
        // --- AKUN ADMIN / PENGELOLA (bisa login ke /admin) ---
        User::updateOrCreate(
            ['email' => 'owner@arca.com'],
            [
                'name' => 'Owner Arca Kost',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'phone_number' => '081200000001',
                'profession' => 'Pemilik Kost',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@arca.com'],
            [
                'name' => 'Staff Arca Kost',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone_number' => '081200000002',
                'profession' => 'Staff Operasional',
                'email_verified_at' => now(),
            ]
        );

        // --- AKUN CUSTOMER DEMO (penghuni / calon penghuni) ---
        $customers = [
            ['name' => 'Nanta',         'email' => 'nanta@gmail.com', 'profession' => 'Mahasiswa Ilmu Komputer'],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@gmail.com', 'profession' => 'Mahasiswa Arsitektur'],
            ['name' => 'Sari Dewi',     'email' => 'sari@gmail.com',  'profession' => 'Pekerja Lepas'],
            ['name' => 'Dimas Saputra', 'email' => 'dimas@gmail.com', 'profession' => 'Mahasiswa Kedokteran'],
        ];

        foreach ($customers as $i => $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                    'phone_number' => '0813000000' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                    'profession' => $data['profession'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
