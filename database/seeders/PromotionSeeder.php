<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        Promotion::truncate();

        Promotion::create([
            'title' => 'Promo Liburan Akhir Pekan',
            'description' => 'Dapatkan diskon 30% untuk pemesanan di akhir pekan (Jumat-Minggu).',
            'image_url' => 'https://placehold.co/800x400/FF2D20/FFFFFF?text=Promo+30%25',
            'promo_code' => 'WEEKEND30',
            'start_date' => '2024-01-01',
            'end_date' => '2025-12-31',
        ]);

        Promotion::create([
            'title' => 'Promo Menginap Lebih Lama',
            'description' => 'Menginap 3 malam, bayar 2 malam saja.',
            'image_url' => 'https://placehold.co/800x400/00529B/FFFFFF?text=Bayar+2+Dapat+3',
            'promo_code' => 'STAY3PAY2',
            'start_date' => '2024-01-01',
            'end_date' => '2025-12-31',
        ]);

        $this->command->info('Tabel Promotion berhasil di-seed!');
    }
}