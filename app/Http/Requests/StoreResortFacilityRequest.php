<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StoreResortFacilityRequest",
 * title="Store Resort Facility Request",
 * required={"name", "description"},
 * @OA\Property(property="name", type="string", example="Nama Fasilitas Baru"),
 * @OA\Property(property="description", type="string", example="Deskripsi fasilitas..."),
 * @OA\Property(property="photo_url", type="string", format="uri", example="https://example.com/image.jpg")
 * )
 */
class StoreResortFacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Ditangani oleh middleware 'role'
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo_url' => 'nullable|string|url',
        ];
    }
}