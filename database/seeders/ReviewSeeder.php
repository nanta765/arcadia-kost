<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing users with professions
        $users = [
            ['email' => 'nanta@gmail.com', 'profession' => 'Mahasiswa Ilmu Komputer'],
            ['email' => 'rizky@gmail.com', 'profession' => 'Mahasiswa Arsitektur'],
            ['email' => 'sari@gmail.com', 'profession' => 'Pekerja Lepas'],
            ['email' => 'dimas@gmail.com', 'profession' => 'Mahasiswa Kedokteran'],
            ['email' => 'owner@arca.com', 'profession' => 'Pemilik Kost'],
        ];

        foreach ($users as $data) {
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $user->update(['profession' => $data['profession']]);
            }
        }

        // Fetch available bookings for creating sample reviews
        $bookings = \App\Models\Booking::all();

        if ($bookings->isEmpty()) {
            $this->command->warn('No bookings found. Skipping review creation.');
            return;
        }

        // Make the existing review visible
        Review::where('id', 1)->update(['is_visible' => true]);

        // Get users
        $rizky = User::where('email', 'rizky@gmail.com')->first();
        $sari = User::where('email', 'sari@gmail.com')->first();
        $dimas = User::where('email', 'dimas@gmail.com')->first();

        // Create additional sample reviews using valid booking IDs
        $samples = [
            [
                'user' => $rizky,
                'rating' => 5,
                'comment' => 'Desain minimalis dan kebijakan zero clutter di area bersama membuat pulang ke kost setelah seharian kuliah terasa sangat menenangkan.',
            ],
            [
                'user' => $sari,
                'rating' => 5,
                'comment' => 'Aturan jam tenang benar-benar ditegakkan. Rasanya seperti sanctuary pribadi, bukan kos-kosan biasa.',
            ],
            [
                'user' => $dimas,
                'rating' => 4,
                'comment' => 'Internet cepat dan lingkungan bersih. Cocok untuk kuliah online dan mengerjakan tugas.',
            ],
        ];

        foreach ($samples as $sample) {
            $user = $sample['user'];
            if (!$user) {
                continue;
            }

            // Find a booking belonging to this user, or use the first available booking
            $booking = $bookings->firstWhere('user_id', $user->id) ?? $bookings->first();
            if (!$booking) {
                continue;
            }

            // Check if review already exists for this user
            $exists = Review::where('user_id', $user->id)->exists();
            if ($exists) {
                continue;
            }

            Review::create([
                'user_id' => $user->id,
                'room_id' => $booking->room_id,
                'booking_id' => $booking->id,
                'rating' => $sample['rating'],
                'comment' => $sample['comment'],
                'is_visible' => true,
            ]);
        }
    }
}