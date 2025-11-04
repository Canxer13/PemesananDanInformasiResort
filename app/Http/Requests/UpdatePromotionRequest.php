<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="UpdatePromotionRequest",
 * title="Update Promotion Request",
 * @OA\Property(property="title", type="string", example="Promo Liburan Sekolah (Update)"),
 * @OA\Property(property="description", type="string", example="Deskripsi promo yang baru."),
 * @OA\Property(property="image_url", type="string", format="uri", example="https://example.com/image-baru.jpg"),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-06-16"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-07-16")
 * )
 */
class UpdatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            // 'sometimes' berarti hanya divalidasi jika ada di request
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|nullable|string|url',
            'promo_code' => 'sometimes|nullable|string|max:50',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ];
    }
}