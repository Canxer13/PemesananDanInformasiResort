<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StorePromotionRequest",
 * title="Store Promotion Request",
 * required={"title", "description", "start_date", "end_date"},
 * @OA\Property(property="title", type="string", example="Promo Lebaran"),
 * @OA\Property(property="description", type="string", example="Deskripsi promo..."),
 * @OA\Property(property="image_url", type="string", format="uri", example="https://example.com/image.jpg"),
 * @OA\Property(property="promo_code", type="string", example="LEBARAN2025"),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-04-01"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-04-10")
 * )
 */
class StorePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string|url',
            'promo_code' => 'nullable|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
}