<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Admin - Promotions",
 * description="Endpoint untuk manajemen promo oleh Admin"
 * )
 */
class PromotionController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/promotions",
     * summary="Get semua promo (Admin)",
     * tags={"Admin - Promotions"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Daftar promo",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Promotion"))
     * )
     * )
     */
    public function index()
    {
        $promotions = Promotion::all();
        return response()->json(['success' => true, 'data' => $promotions]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/admin/promotions",
     * summary="Membuat promo baru",
     * tags={"Admin - Promotions"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StorePromotionRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Promo berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/Promotion")
     * )
     * )
     */
    public function store(StorePromotionRequest $request)
    {
        $promotion = Promotion::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Promo berhasil dibuat.', 'data' => $promotion], 201);
    }

    /**
     * @OA\Get(
     * path="/api/v1/admin/promotions/{id}",
     * summary="Get detail promo (Admin)",
     * tags={"Admin - Promotions"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Detail promo",
     * @OA\JsonContent(ref="#/components/schemas/Promotion")
     * ),
     * @OA\Response(response=404, description="Promo tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Promo tidak ditemukan.'], 404);
        }
        return response()->json(['success' => true, 'data' => $promotion]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/admin/promotions/{id}",
     * summary="Memperbarui promo (Update)",
     * tags={"Admin - Promotions"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdatePromotionRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Promo berhasil diperbarui",
     * @OA\JsonContent(ref="#/components/schemas/Promotion")
     * )
     * )
     */
    public function update(UpdatePromotionRequest $request, $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Promo tidak ditemukan.'], 404);
        }
        $promotion->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Promo berhasil diperbarui.', 'data' => $promotion]);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/admin/promotions/{id}",
     * summary="Menghapus promo",
     * tags={"Admin - Promotions"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Promo berhasil dihapus")
     * )
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['success' => false, 'message' => 'Promo tidak ditemukan.'], 404);
        }
        $promotion->delete();
        return response()->json(['success' => true, 'message' => 'Promo berhasil dihapus.']);
    }
}