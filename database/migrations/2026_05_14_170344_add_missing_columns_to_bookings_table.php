<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambahkan end_date jika belum ada
            if (!Schema::hasColumn('bookings', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }

            // Jaga-jaga kalau kolom total_price juga belum kamu buat sebelumnya
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->integer('total_price')->nullable();
            }

            // Jaga-jaga kalau kolom status juga belum kamu buat
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'total_price', 'status']);
        });
    }
};
