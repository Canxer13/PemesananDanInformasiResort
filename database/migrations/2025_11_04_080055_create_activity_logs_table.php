<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            // User mana yang melakukan aksi
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->string('action'); // CONTOH: 'booking_updated', 'room_created'
            $table->text('description'); // CONTOH: 'Admin (Admin) mengubah status booking #DT-123 menjadi "confirmed"'
            $table->string('model_type'); // CONTOH: 'App\Models\Booking'
            $table->unsignedBigInteger('model_id'); // CONTOH: 101 (Booking ID)
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};