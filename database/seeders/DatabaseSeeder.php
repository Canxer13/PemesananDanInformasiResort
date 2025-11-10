<?php

namespace Database\Seeders;

// use App\Models\User; // Anda tidak perlu ini di sini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN BARIS INI

class DatabaseSeeder extends Seeder
{
    /**
     * Seed aplikasi database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Panggil semua seeder yang telah kita buat.
        // Masing-masing seeder akan menjalankan truncate()
        $this->call([
            UserSeeder::class,
            ResortFacilitySeeder::class,
            PromotionSeeder::class,
            RoomSeeder::class,          // Harus ada sebelum Booking
            BookingSeeder::class,       // Harus ada sebelum Review
            ReviewSeeder::class,
        ]);

        // 3. Nyalakan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}