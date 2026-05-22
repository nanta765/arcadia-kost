<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pengirim (Anak kost)
            $table->foreignId('room_id')->constrained()->cascadeOnDelete(); // Kamar yang dimaksud
            
            // Jenis permintaan: 'cleaning' (bersihkan kamar), 'repair' (perbaikan), dll.
            $table->string('type'); 
            
            // Catatan tambahan dari anak kost (misal: "tolong bersihkan jam 2 siang saat kuliah")
            $table->text('notes')->nullable(); 
            
            // Status pengerjaan oleh staf
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};