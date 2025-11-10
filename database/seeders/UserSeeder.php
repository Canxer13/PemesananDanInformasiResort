<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Kita panggil Hash untuk keamanan

class UserSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat
        User::truncate();

        // 1. Buat Akun Super Admin
        User::create([
            'full_name' => 'Super Admin',
            'email' => 'superadmin@detuna.com',
            'password' => 'password', // Otomatis di-hash oleh Model User
            'phone_number' => '081000000001',
            'role' => 'super_admin'
        ]);

        // 2. Buat Akun Admin
        User::create([
            'full_name' => 'Admin Resort',
            'email' => 'admin@detuna.com',
            'password' => 'password',
            'phone_number' => '081000000002',
            'role' => 'admin'
        ]);

        // 3. Buat Akun Pelanggan
        User::create([
            'full_name' => 'Pelanggan Satu',
            'email' => 'pelanggan@detuna.com',
            'password' => 'password',
            'phone_number' => '081000000003',
            'role' => 'pelanggan'
        ]);

        $this->command->info('Tabel User berhasil di-seed!');
    }
}