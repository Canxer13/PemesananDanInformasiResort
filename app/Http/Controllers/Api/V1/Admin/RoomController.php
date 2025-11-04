<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest; // Ini akan kita buat
use App\Http\Requests\UpdateRoomRequest; // Ini akan kita buat
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Admin - Rooms",
 * description="Endpoint untuk manajemen kamar oleh Admin"
 * )
 */
class RoomController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/rooms",
     * summary="Get semua data kamar (Admin)",
     * tags={"Admin - Rooms"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Daftar semua kamar",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Room"))
     * ),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index()
    {
        // Admin bisa melihat semua kamar, termasuk yang statusnya 'maintenance'
        $rooms = Room::with('photos', 'facilities')->orderBy('room_id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $rooms]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/admin/rooms",
     * summary="Membuat kamar baru",
     * tags={"Admin - Rooms"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data kamar baru",
     * @OA\JsonContent(ref="#/components/schemas/StoreRoomRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Kamar berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/Room")
     * ),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(StoreRoomRequest $request)
    {
        $validatedData = $request->validated();
        $room = Room::create($validatedData);
        return response()->json(['success' => true, 'message' => 'Kamar berhasil dibuat.', 'data' => $room], 201);
    }

    /**
     * @OA\Get(
     * path="/api/v1/admin/rooms/{id}",
     * summary="Get detail kamar (Admin)",
     * tags={"Admin - Rooms"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Detail kamar",
     * @OA\JsonContent(ref="#/components/schemas/Room")
     * ),
     * @OA\Response(response=404, description="Kamar tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $room = Room::with('photos', 'facilities')->find($id);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Kamar tidak ditemukan.'], 404);
        }
        return response()->json(['success' => true, 'data' => $room]);
    }

    /**
     * @OA\Put(
     * path="/api/v1/admin/rooms/{id}",
     * summary="Memperbarui kamar",
     * tags={"Admin - Rooms"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * description="Data kamar yang diperbarui",
     * @OA\JsonContent(ref="#/components/schemas/UpdateRoomRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Kamar berhasil diperbarui",
     * @OA\JsonContent(ref="#/components/schemas/Room")
     * ),
     * @OA\Response(response=404, description="Kamar tidak ditemukan"),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Kamar tidak ditemukan.'], 404);
        }

        $validatedData = $request->validated();
        $room->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Kamar berhasil diperbarui.', 'data' => $room]);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/admin/rooms/{id}",
     * summary="Menghapus kamar",
     * tags={"Admin - Rooms"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Kamar berhasil dihapus"),
     * @OA\Response(response=404, description="Kamar tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Kamar tidak ditemukan.'], 404);
        }

        // TODO: Tambahkan logika untuk menghapus foto dari storage (jika Anda menyimpannya secara lokal)
        
        $room->delete();

        return response()->json(['success' => true, 'message' => 'Kamar berhasil dihapus.'], 200);
    }
}

