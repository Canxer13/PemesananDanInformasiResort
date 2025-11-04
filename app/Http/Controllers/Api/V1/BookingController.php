<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest; // Ini dari tutorial (Bagian 9)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Bookings (Pelanggan)",
 * description="Endpoint untuk pelanggan membuat dan melihat booking mereka"
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/bookings",
     * summary="Membuat booking baru (Pelanggan)",
     * tags={"Bookings (Pelanggan)"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data booking baru",
     * @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Booking berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/Booking")
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthorized (Token tidak valid)"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validasi gagal (Data input tidak valid)"
     * )
     * )
     */
    public function store(StoreBookingRequest $request)
    {
        // Ambil data yang sudah divalidasi dari Form Request
        $validatedData = $request->validated();

        // Tambahkan data yang tidak diisi oleh user
        $validatedData['user_id'] = Auth::id(); // Ambil ID user yang sedang login
        $validatedData['booking_code'] = 'DT-' . now()->timestamp . '-' . strtoupper(Str::random(4));
        $validatedData['booking_status'] = 'pending';
        $validatedData['payment_status'] = 'pending';

        // Buat booking baru
        $booking = Booking::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat.',
            'data' => $booking
        ], 201);
    }

    /**
     * @OA\Get(
     * path="/api/v1/my-bookings",
     * summary="Melihat riwayat booking (Pelanggan)",
     * tags={"Bookings (Pelanggan)"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Daftar riwayat booking",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Booking")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthorized (Token tidak valid)"
     * )
     * )
     */
    public function myBookings(Request $request)
    {
        $userId = Auth::id();

        // Ambil semua booking milik user yang sedang login
        // Gunakan 'with' (eager loading) untuk performa
        $bookings = Booking::with('room') 
                           ->where('user_id', $userId)
                           ->orderBy('created_at', 'desc')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ], 200);
    }
}

