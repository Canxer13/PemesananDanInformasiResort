<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Messages (Publik)",
 * description="Endpoint untuk form kontak publik"
 * )
 */
class MessageController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/contact-messages",
     * summary="Kirim pesan kontak (Publik)",
     * tags={"Messages (Publik)"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreMessageRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Pesan berhasil dikirim",
     * @OA\JsonContent(ref="#/components/schemas/Message")
     * )
     * )
     */
    public function store(StoreMessageRequest $request)
    {
        // Set is_read = false secara default
        $data = $request->validated();
        $data['is_read'] = false;

        $message = Message::create($data);

        // TODO: Kirim notifikasi email ke Admin (Opsional tapi direkomendasikan)

        return response()->json(['success' => true, 'message' => 'Pesan Anda berhasil dikirim.', 'data' => $message], 201);
    }
}