<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        Review::truncate();

        // Cari booking yang sudah 'completed'
        $completedBooking = Booking::where('booking_status', 'completed')->first();

        if ($completedBooking) {
            Review::create([
                'booking_id' => $completedBooking->booking_id,
                'user_id' => $completedBooking->user_id,
                'rating' => 5,
                'comment' => 'Pengalaman menginap yang luar biasa! Pemandangan dari kamar Deluxe sangat indah. Pelayanan ramah dan fasilitas lengkap. Pasti akan kembali lagi!'
            ]);

            $this->command->info('Tabel Review berhasil di-seed!');
        } else {
            $this->command->warn('Tidak ditemukan booking "completed" untuk di-review.');
        }
    }
}