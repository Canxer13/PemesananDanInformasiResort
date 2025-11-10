<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomPhoto;
use App\Models\RoomFacility;

class RoomSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Hapus data lama
        Room::truncate();
        RoomPhoto::truncate();
        RoomFacility::truncate();

        // 1. Buat Kamar Tipe Deluxe
        $deluxe = Room::create([
            'name' => 'Deluxe Ocean View',
            'description' => 'Kamar mewah seluas 45 m² dengan pemandangan langsung ke samudra. Nikmati matahari terbenam dari balkon pribadi Anda. Dilengkapi dengan bathtub marmer dan fasilitas modern.',
            'price_per_night' => 2500000.00,
            'capacity' => 2,
            'size' => '45 m²',
            'bed_type' => '1 King Bed',
            'status' => 'available'
        ]);

        // Tambahkan Foto untuk Kamar Deluxe
        $deluxe->photos()->createMany([
            ['photo_url' => 'https://placehold.co/1200x800/5D4037/FFFFFF?text=Deluxe+View+1', 'is_primary' => true],
            ['photo_url' => 'https://placehold.co/1200x800/5D4037/FFFFFF?text=Deluxe+Bathroom', 'is_primary' => false],
            ['photo_url' => 'https://placehold.co/1200x800/5D4037/FFFFFF?text=Deluxe+Balcony', 'is_primary' => false],
        ]);

        // Tambahkan Fasilitas untuk Kamar Deluxe
        $deluxe->facilities()->createMany([
            ['facility_name' => 'WiFi Gratis Kecepatan Tinggi'],
            ['facility_name' => 'AC'],
            ['facility_name' => 'Smart TV 55 inch'],
            ['facility_name' => 'Bathtub'],
            ['facility_name' => 'Balkon Pribadi'],
            ['facility_name' => 'Mini Bar'],
        ]);


        // 2. Buat Kamar Tipe Villa
        $villa = Room::create([
            'name' => 'Family Garden Villa (2 Kamar)',
            'description' => 'Villa luas seluas 120 m² dengan taman pribadi dan kolam renang mini. Sempurna untuk liburan keluarga, dilengkapi dengan 2 kamar tidur terpisah dan ruang tamu.',
            'price_per_night' => 5000000.00,
            'capacity' => 4,
            'size' => '120 m²',
            'bed_type' => '1 King Bed & 2 Twin Beds',
            'status' => 'available'
        ]);

        // Tambahkan Foto untuk Villa
        $villa->photos()->createMany([
            ['photo_url' => 'https://placehold.co/1200x800/FFA726/FFFFFF?text=Villa+Pool+1', 'is_primary' => true],
            ['photo_url' => 'https://placehold.co/1200x800/FFA726/FFFFFF?text=Villa+Bedroom+1', 'is_primary' => false],
            ['photo_url' => 'https://placehold.co/1200x800/FFA726/FFFFFF?text=Villa+Bedroom+2', 'is_primary' => false],
            ['photo_url' => 'https://placehold.co/1200x800/FFA726/FFFFFF?text=Villa+Living+Room', 'is_primary' => false],
        ]);

        // Tambahkan Fasilitas untuk Villa
        $villa->facilities()->createMany([
            ['facility_name' => 'WiFi Gratis Kecepatan Tinggi'],
            ['facility_name' => 'AC di setiap kamar'],
            ['facility_name' => 'Smart TV 65 inch'],
            ['facility_name' => 'Kolam Renang Pribadi'],
            ['facility_name' => 'Dapur Kecil (Kitchenette)'],
            ['facility_name' => 'Taman Pribadi'],
        ]);

        $this->command->info('Tabel Room (termasuk Foto & Fasilitas) berhasil di-seed!');
    }
}