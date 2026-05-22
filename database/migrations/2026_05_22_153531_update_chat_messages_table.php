<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            // Menambahkan receiver_id jika belum ada
            if (!Schema::hasColumn('chat_messages', 'receiver_id')) {
                $table->unsignedBigInteger('receiver_id')->nullable()->after('sender_id');
                
                // Menambahkan relasi foreign key ke tabel users (opsional tapi disarankan)
                $table->foreign('receiver_id')->references('id')->on('users')->cascadeOnDelete();
            }

            // Menambahkan is_read untuk fitur "Unread Badge" jika belum ada
            if (!Schema::hasColumn('chat_messages', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            if (Schema::hasColumn('chat_messages', 'receiver_id')) {
                $table->dropForeign(['receiver_id']);
                $table->dropColumn('receiver_id');
            }
            if (Schema::hasColumn('chat_messages', 'is_read')) {
                $table->dropColumn('is_read');
            }
        });
    }
};