<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResortFacility;

class ResortFacilitySeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        ResortFacility::truncate();

        ResortFacility::create([
            'name' => 'Infinity Pool',
            'description' => 'Kolam renang tanpa batas dengan pemandangan langsung ke samudra.',
            'photo_url' => 'https://placehold.co/600x400/000000/FFFFFF?text=Infinity+Pool'
        ]);

        ResortFacility::create([
            'name' => 'De Tuna Spa',
            'description' => 'Layanan spa dan pijat tradisional Bali untuk relaksasi total.',
            'photo_url' => 'https://placehold.co/600x400/000000/FFFFFF?text=De+Tuna+Spa'
        ]);

        ResortFacility::create([
            'name' => 'Gym Center',
            'description' => 'Pusat kebugaran dengan peralatan modern dan lengkap.',
            'photo_url' => 'https://placehold.co/600x400/000000/FFFFFF?text=Gym+Center'
        ]);

        $this->command->info('Tabel ResortFacility berhasil di-seed!');
    }
}