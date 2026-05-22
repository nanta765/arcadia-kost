<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus aturan ketat yang lama
        DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');

        // 2. Buat aturan baru yang memasukkan status 'review'
        DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'review'::character varying, 'active'::character varying, 'cancelled'::character varying]::text[]))");
    }

    public function down(): void
    {
        // Kembalikan ke asal jika migrasi di-rollback
        DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');
        DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'active'::character varying, 'cancelled'::character varying]::text[]))");
    }
};
