<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StoreMessageRequest",
 * title="Store Message Request",
 * required={"sender_name", "sender_email", "message_body"},
 * @OA\Property(property="sender_name", type="string", example="Pengunjung"),
 * @OA\Property(property="sender_email", type="string", format="email", example="pengunjung@mail.com"),
 * @OA\Property(property="subject", type="string", example="Pertanyaan kamar"),
 * @OA\Property(property="message_body", type="string", example="Halo, saya ingin bertanya...")
 * )
 */
class StoreMessageRequest extends FormRequest
{
    /**
     * Pesan kontak bersifat publik, tidak perlu otorisasi.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|string|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message_body' => 'required|string',
        ];
    }
}