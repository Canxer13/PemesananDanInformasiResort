<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="UpdateResortFacilityRequest",
 * title="Update Resort Facility Request",
 * @OA\Property(property="name", type="string", example="Nama Fasilitas (Update)"),
 * @OA\Property(property="description", type="string", example="Deskripsi baru...")
 * )
 */
class UpdateResortFacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'photo_url' => 'sometimes|nullable|string|url',
        ];
    }
}