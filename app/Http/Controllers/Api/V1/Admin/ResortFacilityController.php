<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResortFacility;
use App\Http\Requests\StoreResortFacilityRequest;
use App\Http\Requests\UpdateResortFacilityRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Admin - Resort Facilities",
 * description="Endpoint untuk manajemen fasilitas umum resort oleh Admin"
 * )
 */
class ResortFacilityController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/resort-facilities",
     * summary="Get semua fasilitas resort (Admin)",
     * tags={"Admin - Resort Facilities"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Daftar fasilitas",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ResortFacility"))
     * )
     * )
     */
    public function index()
    {
        $facilities = ResortFacility::all();
        return response()->json(['success' => true, 'data' => $facilities]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/admin/resort-facilities",
     * summary="Membuat fasilitas resort baru",
     * tags={"Admin - Resort Facilities"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreResortFacilityRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Fasilitas berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/ResortFacility")
     * )
     * )
     */
    public function store(StoreResortFacilityRequest $request)
    {
        $facility = ResortFacility::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Fasilitas berhasil dibuat.', 'data' => $facility], 201);
    }

    /**
     * @OA\Get(
     * path="/api/v1/admin/resort-facilities/{id}",
     * summary="Get detail fasilitas (Admin)",
     * tags={"Admin - Resort Facilities"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Detail fasilitas",
     * @OA\JsonContent(ref="#/components/schemas/ResortFacility")
     * ),
     * @OA\Response(response=404, description="Fasilitas tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $facility = ResortFacility::find($id);
        if (!$facility) {
            return response()->json(['success' => false, 'message' => 'Fasilitas tidak ditemukan.'], 404);
        }
        return response()->json(['success' => true, 'data' => $facility]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/admin/resort-facilities/{id}",
     * summary="Memperbarui fasilitas (Update)",
     * description="Menggunakan POST untuk update karena PUT/PATCH bermasalah dengan form-data/file upload",
     * tags={"Admin - Resort Facilities"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateResortFacilityRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Fasilitas berhasil diperbarui",
     * @OA\JsonContent(ref="#/components/schemas/ResortFacility")
     * ),
     * @OA\Response(response=404, description="Fasilitas tidak ditemukan")
     * )
     */
    public function update(UpdateResortFacilityRequest $request, $id)
    {
        $facility = ResortFacility::find($id);
        if (!$facility) {
            return response()->json(['success' => false, 'message' => 'Fasilitas tidak ditemukan.'], 404);
        }
        $facility->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Fasilitas berhasil diperbarui.', 'data' => $facility]);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/admin/resort-facilities/{id}",
     * summary="Menghapus fasilitas",
     * tags={"Admin - Resort Facilities"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Fasilitas berhasil dihapus")
     * )
     */
    public function destroy($id)
    {
        $facility = ResortFacility::find($id);
        if (!$facility) {
            return response()->json(['success' => false, 'message' => 'Fasilitas tidak ditemukan.'], 404);
        }
        $facility->delete();
        return response()->json(['success' => true, 'message' => 'Fasilitas berhasil dihapus.']);
    }
}