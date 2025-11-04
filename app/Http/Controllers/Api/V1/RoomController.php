<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RoomController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/rooms",
     * summary="Get Semua Kamar",
     * tags={"Rooms (Public)"},
     * @OA\Response(response=200, description="Daftar kamar", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Room")))
     * )
     */
    public function index()
    {
        // Menggunakan 'with' (Eager Loading) sangat PENTING untuk performa
        // Ini menghindari N+1 query problem.
        $rooms = Room::with('photos', 'facilities')
                    ->where('status', 'available')
                    ->get();

        return response()->json(['success' => true, 'data' => $rooms]);
    }

    /**
     * @OA\Get(
     * path="/api/v1/rooms/{id}",
     * summary="Get Detail Kamar",
     * tags={"Rooms (Public)"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detail kamar", @OA\JsonContent(ref="#/components/schemas/RoomWithRelations")),
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

    // (Tambahkan fungsi checkAvailability di sini)
}
