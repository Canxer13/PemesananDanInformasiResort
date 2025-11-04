<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Admin - Bookings",
 * description="Endpoint untuk manajemen booking oleh Admin"
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/bookings",
     * summary="Get semua data booking (Admin)",
     * tags={"Admin - Bookings"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     * name="status",
     * in="query",
     * description="Filter berdasarkan status booking (pending, confirmed, canceled, completed)",
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Daftar semua booking",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Booking"))
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthorized (Token tidak valid)" 
     * ),
     * @OA\Response(
     * response=403,
     * description="Forbidden (Tidak memiliki peran Admin)"
     * )
     * )
     */
    public function index(Request $request)
    {
        // Validasi query parameter sederhana
        $request->validate([
            'status' => 'sometimes|in:pending,confirmed,canceled,completed'
        ]);

        // Mulai query
        $bookings = Booking::with('user', 'room'); // Eager loading untuk performa

        // Terapkan filter jika ada
        if ($request->has('status')) {
            $bookings->where('booking_status', $request->status);
        }

        $data = $bookings->orderBy('created_at', 'desc')->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * @OA\Put(
     * path="/api/v1/admin/bookings/{id}/status",
     * summary="Update status booking (Admin)",
     * tags={"Admin - Bookings"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID Booking",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Status baru untuk booking",
     * @OA\JsonContent(
     * required={"booking_status"},
     * @OA\Property(property="booking_status", type="string", enum={"pending", "confirmed", "canceled", "completed"}, example="confirmed"),
     * @OA\Property(property="payment_status", type="string", enum={"pending", "paid", "failed"}, example="paid")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Status booking berhasil diperbarui",
     * @OA\JsonContent(ref="#/components/schemas/Booking")
     * ),
     * @OA\Response(response=404, description="Booking tidak ditemukan"),
     * @OA\Response(response=422, description="Validasi gagal (status tidak valid)")
     * )
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
        }

        $validatedData = $request->validate([
            'booking_status' => 'sometimes|string|in:pending,confirmed,canceled,completed',
            'payment_status' => 'sometimes|string|in:pending,paid,failed',
        ]);

        // Update hanya jika data dikirim
        if ($request->has('booking_status')) {
            $booking->booking_status = $validatedData['booking_status'];
        }

        if ($request->has('payment_status')) {
            $booking->payment_status = $validatedData['payment_status'];
        }

        $booking->save();

        return response()->json(['success' => true, 'message' => 'Status booking diperbarui.', 'data' => $booking]);
    }
}

