<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ini adalah file migrasi.
// Isinya HANYA kode untuk membuat tabel 'bookings'.
// JANGAN letakkan kode 'class Booking extends Model' di sini.

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->string('booking_code')->unique();
            // Relasi ke tabel 'users'
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            // Relasi ke tabel 'rooms'
            $table->foreignId('room_id')->constrained('rooms', 'room_id')->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->decimal('total_price', 10, 2);
            $table->enum('booking_status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

