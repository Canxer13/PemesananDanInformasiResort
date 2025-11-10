<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        Booking::truncate();

        // Dapatkan data user dan kamar yang sudah kita buat
        $pelanggan = User::where('email', 'pelanggan@detuna.com')->first();
        $room1 = Room::find(1); // Deluxe
        $room2 = Room::find(2); // Villa

        // 1. Booking yang SUDAH SELESAI (untuk di-review)
        Booking::create([
            'booking_code' => 'DT-' . time() . '-01',
            'user_id' => $pelanggan->user_id,
            'room_id' => $room1->room_id,
            'check_in_date' => '2024-10-01',
            'check_out_date' => '2024-10-03',
            'total_price' => $room1->price_per_night * 2,
            'booking_status' => 'completed',
            'payment_status' => 'paid',
        ]);

        // 2. Booking yang AKAN DATANG (untuk "My Bookings")
        Booking::create([
            'booking_code' => 'DT-' . time() . '-02',
            'user_id' => $pelanggan->user_id,
            'room_id' => $room2->room_id,
            'check_in_date' => '2025-12-20',
            'check_out_date' => '2025-12-22',
            'total_price' => $room2->price_per_night * 2,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);

        // 3. Booking yang PENDING (untuk di-approve Admin)
        Booking::create([
            'booking_code' => 'DT-' . time() . '-03',
            'user_id' => $pelanggan->user_id,
            'room_id' => $room1->room_id,
            'check_in_date' => '2025-11-25',
            'check_out_date' => '2025-11-26',
            'total_price' => $room1->price_per_night * 1,
            'booking_status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $this->command->info('Tabel Booking berhasil di-seed!');
    }
}