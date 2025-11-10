<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import semua Controller yang akan kita gunakan
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RoomController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\ReviewController;     // BARU
use App\Http\Controllers\Api\V1\MessageController;    // BARU

// Import Controller Admin
use App\Http\Controllers\Api\V1\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Api\V1\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Api\V1\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\V1\Admin\ResortFacilityController as AdminFacilityController; // BARU
use App\Http\Controllers\Api\V1\Admin\PromotionController as AdminPromotionController; // BARU
use App\Http\Controllers\Api\V1\Admin\MessageController as AdminMessageController; // BARU
use App\Http\Controllers\Api\V1\Admin\ReportController as AdminReportController; // BARU

//import Controller Super Admin
use App\Http\Controllers\Api\V1\Admin\ActivityLogController;


// Grup untuk API v1
Route::prefix('v1')->group(function () {

    // ==========================================
    // === Rute Publik (Tidak perlu login) ===
    // ==========================================
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    // Rooms
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/rooms/{id}', [RoomController::class, 'show']);
    Route::post('/rooms/check-availability', [RoomController::class, 'checkAvailability']);

    // Content
    Route::post('/contact-messages', [MessageController::class, 'store']); // BARU: Kirim pesan kontak
    // Rute untuk fasilitas & promo publik ada di bawah, di dalam RoomController untuk simplisitas
    Route::get('/resort-facilities', [RoomController::class, 'getPublicFacilities']); 
    Route::get('/promotions', [RoomController::class, 'getPublicPromotions']); 
    Route::get('/rooms/{id}/reviews', [ReviewController::class, 'index']); // BARU: Lihat review untuk kamar

    // ==================================================
    // === Rute Terproteksi (Harus login - 'auth:sanctum') ===
    // ==================================================
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/me/profile', [AuthController::class, 'updateProfile']); 
        Route::put('/me/password', [AuthController::class, 'updatePassword']); 

        // Rute Pelanggan
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::get('/my-bookings', [BookingController::class, 'myBookings']);
        Route::post('/reviews', [ReviewController::class, 'store']); // BARU: Pelanggan membuat review

        // ===================================================================
        // === Rute Admin (Peran 'admin' atau 'super_admin') ===
        // ===================================================================
        Route::middleware('role:admin,super_admin')->prefix('admin')->group(function () {

            // Manajemen Booking
            Route::get('/bookings', [AdminBookingController::class, 'index']);
            Route::get('/bookings/{id}', [AdminBookingController::class, 'show']);
            Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus']);

            // Manajemen Kamar (CRUD)
            Route::get('/rooms', [AdminRoomController::class, 'index']);
            Route::post('/rooms', [AdminRoomController::class, 'store']);
            Route::get('/rooms/{id}', [AdminRoomController::class, 'show']);
            Route::post('/rooms/{id}', [AdminRoomController::class, 'update']); // Gunakan POST untuk PUT/PATCH jika form-data
            Route::delete('/rooms/{id}', [AdminRoomController::class, 'destroy']);
            // (Tambahkan rute untuk foto & fasilitas kamar di sini jika perlu)

            // BARU: Manajemen Fasilitas Resort (CRUD)
            Route::apiResource('/resort-facilities', AdminFacilityController::class);
            Route::post('/resort-facilities/{id}', [AdminFacilityController::class, 'update']); // Alias untuk form-data

            // BARU: Manajemen Promo (CRUD)
            Route::apiResource('/promotions', AdminPromotionController::class);
             Route::post('/promotions/{id}', [AdminPromotionController::class, 'update']); // Alias untuk form-data

            // BARU: Manajemen Pesan Kontak
            Route::get('/messages', [AdminMessageController::class, 'index']);
            Route::get('/messages/{id}', [AdminMessageController::class, 'show']);
            Route::put('/messages/{id}/read', [AdminMessageController::class, 'markAsRead']);
            Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy']);
        });

        // ===================================================================
        // === Rute Super Admin (Hanya Peran 'super_admin') ===
        // ===================================================================
        Route::middleware('role:super_admin')->prefix('superadmin')->group(function () {

            // Manajemen User
            Route::get('/users', [AdminUserController::class, 'index']);
            Route::post('/users/admin', [AdminUserController::class, 'createAdmin']);
            Route::put('/users/{id}', [AdminUserController::class, 'update']);
            Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);

            // BARU: Laporan
            Route::get('/reports/bookings', [AdminReportController::class, 'bookingReport']);
            Route::get('/reports/occupancy', [AdminReportController::class, 'occupancyReport']);

            // BARU: Log Aktivitas Sistem
            Route::get('/logs', [ActivityLogController::class, 'index']);

        });
    });
});