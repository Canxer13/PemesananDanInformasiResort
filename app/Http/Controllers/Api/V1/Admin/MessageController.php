<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Admin - Messages",
 * description="Endpoint untuk manajemen pesan kontak oleh Admin"
 * )
 */
class MessageController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/messages",
     * summary="Get semua pesan (Admin)",
     * tags={"Admin - Messages"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="status", in="query", @OA\Schema(type="string", enum={"all", "read", "unread"}), example="unread"),
     * @OA\Response(
     * response=200,
     * description="Daftar pesan",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Message"))
     * )
     * )
     */
    public function index(Request $request)
    {
        $query = Message::query();

        if ($request->query('status') === 'read') {
            $query->where('is_read', true);
        } elseif ($request->query('status') === 'unread') {
            $query->where('is_read', false);
        }
        // Jika 'all' atau tidak ada, ambil semua

        $messages = $query->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $messages]);
    }

    /**
     * @OA\Get(
     * path="/api/v1/admin/messages/{id}",
     * summary="Get detail pesan (Admin)",
     * tags={"Admin - Messages"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Detail pesan"),
     * @OA\Response(response=404, description="Pesan tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['success' => false, 'message' => 'Pesan tidak ditemukan.'], 404);
        }
        
        // Tandai sebagai sudah dibaca saat dibuka
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return response()->json(['success' => true, 'data' => $message]);
    }

    /**
     * @OA\Put(
     * path="/api/v1/admin/messages/{id}/read",
     * summary="Tandai pesan sebagai 'sudah dibaca'",
     * tags={"Admin - Messages"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Pesan ditandai dibaca")
     * )
     */
    public function markAsRead($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['success' => false, 'message' => 'Pesan tidak ditemukan.'], 404);
        }
        $message->is_read = true;
        $message->save();
        return response()->json(['success' => true, 'message' => 'Pesan ditandai sebagai sudah dibaca.']);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/admin/messages/{id}",
     * summary="Hapus pesan",
     * tags={"Admin - Messages"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Pesan berhasil dihapus")
     * )
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json(['success' => false, 'message' => 'Pesan tidak ditemukan.'], 404);
        }
        $message->delete();
        return response()->json(['success' => true, 'message' => 'Pesan berhasil dihapus.']);
    }
}