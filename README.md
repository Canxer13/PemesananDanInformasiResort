Sistem Pemesanan dan Informasi Resort (Backend API)

Ini adalah repositori untuk backend (API) dari "Sistem Pemesanan dan Informasi Resort Berbasis Web," sebuah proyek Capstone Project untuk Mata Kuliah Desain Dan Implementasi Framework Programming.

Proyek ini dibangun menggunakan Laravel 11 dan menyediakan API yang aman, cepat, dan terstruktur (RESTful) untuk menangani semua logika bisnis yang diperlukan oleh sebuah sistem reservasi modern.

1. Latar Belakang Proyek

Di industri pariwisata modern, sistem pemesanan manual sering menimbulkan masalah seperti kesalahan pencatatan, informasi ketersediaan yang tidak real-time, dan proses yang lambat.

Proyek ini dirancang untuk menyelesaikan masalah tersebut dengan menyediakan backend API terpusat yang:

Memberikan informasi ketersediaan kamar, harga, dan fasilitas secara real-time.

Membantu pengelola (Admin) mengelola data pemesanan secara efisien dan rapi.

Menyediakan fondasi untuk media promosi yang dinamis.

2. Teknologi yang Digunakan

Framework: Laravel 11

Bahasa: PHP 8.2+

Database: MySQL

Autentikasi: Laravel Sanctum (Token-based API)

Dokumentasi API: L5-Swagger (OpenAPI)

Validasi: Form Request Bawaan Laravel

Lingkungan: Docker (opsional) atau Laragon

3. Fitur Utama API

API ini mencakup 100% kebutuhan fungsional yang dijabarkan dalam proposal, dibagi berdasarkan peran pengguna:

3.1. Rute Publik (Tamu)

POST /register: Registrasi akun pelanggan baru.

POST /login: Login dan mendapatkan token Sanctum.

GET /rooms: Melihat semua daftar kamar.

GET /rooms/{id}: Melihat detail, foto, dan fasilitas satu kamar.

POST /rooms/check-availability: Mengecek ketersediaan kamar pada tanggal tertentu.

GET /resort-facilities: Melihat fasilitas umum resort.

GET /promotions: Melihat promo yang sedang aktif.

POST /contact-messages: Mengirim pesan lewat form kontak.

GET /rooms/{id}/reviews: Melihat ulasan publik untuk sebuah kamar.

3.2. Rute Pelanggan (Terautentikasi)

POST /logout: Logout dan menghapus token.

GET /me: Mendapatkan detail profil pengguna yang sedang login.

PUT /me/profile: Memperbarui profil (nama, no. HP).

PUT /me/password: Mengganti password.

POST /bookings: Membuat pemesanan baru.

GET /my-bookings: Melihat riwayat pemesanan pribadi.

POST /reviews: Mengirim ulasan untuk booking yang sudah selesai.

3.3. Rute Admin (Peran: admin, super_admin)

GET /admin/bookings: Melihat semua pemesanan.

PUT /admin/bookings/{id}/status: Mengubah status pemesanan (confirmed, canceled, dll).

GET/POST/PUT/DELETE /admin/rooms: CRUD penuh untuk data kamar.

GET/POST/PUT/DELETE /admin/resort-facilities: CRUD penuh untuk fasilitas umum.

GET/POST/PUT/DELETE /admin/promotions: CRUD penuh untuk data promo.

GET /admin/messages: Melihat semua pesan kontak masuk.

DELETE /admin/messages/{id}: Menghapus pesan.

3.4. Rute Super Admin (Peran: super_admin)

GET /superadmin/users: Melihat semua akun pengguna dan admin.

POST /superadmin/users/admin: Membuat akun Admin baru.

DELETE /superadmin/users/{id}: Menghapus akun.

GET /superadmin/reports/bookings: Melihat laporan pendapatan.

GET /superadmin/reports/occupancy: Melihat laporan okupansi.

GET /superadmin/logs: [FITUR LENGKAP] Melihat log aktivitas sistem (audit trail).

4. Panduan Instalasi Lokal

Untuk menjalankan proyek ini di komputer Anda:

Clone Repositori

git clone [https://github.com/Canxer13/PemesananDanInformasiResort.git](https://github.com/Canxer13/PemesananDanInformasiResort.git)
cd PemesananDanInformasiResort

Install Dependensi

composer install

Buat File .env
Salin file .env.example menjadi file .env baru.

cp .env.example .env

Generate Kunci Aplikasi

php artisan key:generate

Atur Database

Buka file .env Anda.

Sesuaikan pengaturan DB\_ (database). Jika Anda menggunakan Laragon, konfigurasinya biasanya:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=detuna_resort
DB_USERNAME=root
DB_PASSWORD=

Pastikan Anda sudah membuat database bernama detuna_resort di Laragon (via HeidiSQL/phpMyAdmin).

Jalankan Migrasi Database
Perintah ini akan membuat semua tabel yang diperlukan (Users, Rooms, Bookings, dll).

php artisan migrate:fresh

Jalankan Server Lokal

php artisan serve

Server Anda akan berjalan di http://127.0.0.1:8000.

5. Dokumentasi API (Swagger)

Seluruh API ini didokumentasikan sepenuhnya menggunakan Swagger (OpenAPI).

Setelah server Anda berjalan (langkah 7), Anda dapat mengakses dokumentasi API interaktif yang lengkap di browser Anda pada URL:

http://127.0.0.1:8000/api/documentation

Jika Anda melakukan perubahan pada anotasi @OA di controller atau model, jalankan perintah ini untuk memperbarui dokumentasi:

php artisan l5-swagger:generate

6. Tim Pengembang

Proyek ini disusun oleh tim dari Program Studi Teknik Informatika S-1, Institut Teknologi Nasional Malang:

I Putu Radith Sabiandika Pratama (2318091)

Karis Ilham Maulana (2318093)

Rangga Desta Pratama Putra (2318100)

Chris M.O.L. Da Costa (2318101)
