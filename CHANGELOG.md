# Changelog (Log Perubahan)

Semua perubahan penting pada proyek "De Tuna Resort API" akan didokumentasikan di file ini.

Format file ini didasarkan pada [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [1.2.0] - 2025-11-08

Versi ini menyelesaikan 100% kebutuhan fungsional dan non-fungsional dari proposal, dengan menambahkan fitur-fitur profesional dan keamanan tingkat lanjut.

### Ditambahkan (Added)

-   **Fitur Log Aktivitas (Selesai):**
    -   `ActivityLog` Model & Migration (`create_activity_logs_table`).
    -   `BookingObserver` untuk secara otomatis mencatat _event_ `created`, `updated`, dan `deleted` pada _booking_.
    -   `EventServiceProvider` diperbarui untuk mendaftarkan `BookingObserver`.
    -   `GET /api/v1/superadmin/logs`: Endpoint baru untuk Super Admin melihat semua log aktivitas.
-   **Fitur Keamanan (Rate Limiting):**
    -   _Middleware_ `throttle:10,1` ditambahkan ke rute `POST /register` dan `POST /login` untuk mencegah serangan _brute force_.
-   **Fitur Performa (Async Jobs):**
    -   Koneksi _queue_ (antrian) diubah menjadi `database`.
    -   `queue:table` migration dijalankan.
    -   `SendBookingConfirmationEmail` Job dibuat untuk menangani pengiriman email di latar belakang.
-   **Fitur Kualitas Kode (Testing):**
    -   Konfigurasi `phpunit.xml` untuk menggunakan database tes (`detuna_resort_test`).
    -   `RegistrationFeatureTest` dibuat untuk memvalidasi fungsionalitas registrasi (kasus sukses dan gagal).
-   **Dokumentasi:**
    -   Anotasi Swagger (`@OA\Response(response=429, ...)`) ditambahkan ke `AuthController` untuk mencerminkan adanya _rate limiting_.

### Diubah (Changed)

-   `Admin/BookingController` (`updateStatus`) diubah untuk "melempar" (dispatch) `SendBookingConfirmationEmail` _Job_ ke _queue_, alih-alih menanganinya secara langsung.

---

## [1.1.0] - 2025-11-07

Versi ini melengkapi sebagian besar kebutuhan fungsional yang tersisa dari proposal, berfokus pada fitur-fitur Admin dan interaksi publik.

### Ditambahkan (Added)

-   **Manajemen Fasilitas Resort (Admin):**
    -   `apiResource('/admin/resort-facilities', ...)` (CRUD lengkap).
    -   `StoreResortFacilityRequest` dan `UpdateResortFacilityRequest` untuk validasi.
    -   `GET /api/v1/resort-facilities` (Endpoint publik).
-   **Manajemen Promo (Admin):**
    -   `apiResource('/admin/promotions', ...)` (CRUD lengkap).
    -   `StorePromotionRequest` dan `UpdatePromotionRequest` untuk validasi.
    -   `GET /api/v1/promotions` (Endpoint publik).
-   **Manajemen Ulasan (Pelanggan/Publik):**
    -   `POST /api/v1/reviews` (Pelanggan dapat mengirim ulasan).
    -   `GET /api/v1/rooms/{id}/reviews` (Publik dapat membaca ulasan).
    -   `StoreReviewRequest` dengan validasi kustom (hanya pemilik _booking_ yang sudah _completed_).
-   **Manajemen Pesan Kontak:**
    -   `POST /api/v1/contact-messages` (Publik dapat mengirim pesan).
    -   `StoreMessageRequest` untuk validasi.
    -   `GET /admin/messages` dan `DELETE /admin/messages/{id}` (Admin dapat mengelola pesan).
-   **Laporan (Super Admin):**
    -   `GET /superadmin/reports/bookings` (Melihat total pendapatan & kamar terpopuler).
    -   `GET /superadmin/reports/occupancy` (Placeholder untuk laporan okupansi).
-   **Dokumentasi:**
    -   Semua Model dan _Controller_ baru dilengkapi dengan anotasi Skema Swagger.

### Diubah (Changed)

-   `routes/api.php` dirombak total untuk memasukkan semua _endpoint_ baru dan mengorganisir rute berdasarkan peran.
-   `RoomController` (Publik) diperbarui untuk menyertakan _endpoint_ yang mengambil fasilitas dan promo publik.

---

## [1.0.0] - 2025-10-31

Rilis awal dan fondasi inti dari API "De Tuna Resort". Versi ini berfokus pada fungsionalitas MVP (Minimum Viable Product) sesuai proposal.

### Ditambahkan (Added)

-   **Proyek & Konfigurasi:**
    -   Proyek Laravel 11 dibuat.
    -   `l5-swagger` (OpenAPI) diinstal dan dikonfigurasi untuk dokumentasi API.
    -   `.gitignore` diimplementasikan untuk mengabaikan file sensitif (`.env`).
-   **Database:**
    -   Seluruh 9 migrasi database awal (Users, Rooms, Bookings, Photos, Facilities, dll.) dibuat.
    -   Semua Model (`User`, `Room`, `Booking`, dll.) dibuat dengan relasi Eloquent.
-   **Autentikasi & Keamanan:**
    -   `Laravel Sanctum` diinstal untuk autentikasi API berbasis token.
    -   `AuthController` (`/register`, `/login`, `/logout`, `/me`) dibuat.
    -   `CheckRole` _Middleware_ dibuat untuk membatasi akses (`admin`, `super_admin`).
-   **Fitur Inti:**
    -   `Admin/RoomController` (CRUD) dibuat.
    -   `Admin/BookingController` (`index`, `show`, `updateStatus`) dibuat.
    -   `BookingController` (Pelanggan) (`store`, `myBookings`) dibuat.
    -   `Admin/UserController` (Super Admin) (`index`, `createAdmin`, `destroy`) dibuat.
-   **Dokumentasi:**
    -   Anotasi Swagger (`@OA\Info`, `@OA\Server`, `@OA\SecurityScheme`) ditambahkan ke `Controller.php`.
    -   Anotasi Swagger ditambahkan ke semua Model dan Controller inti.
