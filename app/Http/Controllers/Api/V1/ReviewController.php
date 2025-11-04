<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Reviews (Pelanggan & Publik)",
 * description="Endpoint untuk mengelola ulasan"
 * )
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/rooms/{id}/reviews",
     * summary="Get semua ulasan untuk satu kamar (Publik)",
     * tags={"Reviews (Pelanggan & Publik)"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", description="Room ID")),
     * @OA\Response(
     * response=200,
     * description="Daftar ulasan",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="user_name", type="string", example="Budi S."),
     * @OA\Property(property="rating", type="integer", example=5),
     * @OA\Property(property="comment", type="string", example="Keren!"),
     * @OA\Property(property="created_at", type="string", format="date-time")
     * )
     * )
     * ),
     * @OA\Response(response=404, description="Kamar tidak ditemukan")
     * )
     */
    public function index($room_id)
    {
        // Ambil ulasan, tapi join dengan user untuk dapat nama
        // dan join dengan booking untuk filter room_id
        $reviews = Review::select('reviews.rating', 'reviews.comment', 'reviews.created_at', 'users.full_name as user_name')
            ->join('bookings', 'reviews.booking_id', '=', 'bookings.booking_id')
            ->join('users', 'reviews.user_id', '=', 'users.user_id')
            ->where('bookings.room_id', $room_id)
            ->orderBy('reviews.created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $reviews]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/reviews",
     * summary="Membuat ulasan baru (Pelanggan)",
     * tags={"Reviews (Pelanggan & Publik)"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreReviewRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Ulasan berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/Review")
     * ),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(StoreReviewRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id(); // Set user_id dari user yang login

        $review = Review::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Ulasan Anda berhasil dikirim.', 'data' => $review], 201);
    }
}