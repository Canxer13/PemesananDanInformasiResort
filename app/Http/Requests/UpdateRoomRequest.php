<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="UpdateRoomRequest",
 * title="Update Room Request",
 * @OA\Property(property="name", type="string", example="Suite Mewah (Renovasi)"),
 * @OA\Property(property="description", type="string", example="Deskripsi baru."),
 * @OA\Property(property="price_per_night", type="number", format="decimal", example=5500000.00),
 * @OA\Property(property="capacity", type="integer", example=4),
 * @OA\Property(property="size", type="string", example="110 m²"),
 * @OA\Property(property="bed_type", type="string", example="2 King Beds"),
 * @OA\Property(property="status", type="string", enum={"available", "maintenance"}, example="maintenance")
 * )
 */
class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Saat update, kita buat semua opsional (menggunakan 'sometimes')
        // Ini berarti jika field tidak dikirim, tidak akan divalidasi/gagal
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price_per_night' => 'sometimes|required|numeric|min:0',
            'capacity' => 'sometimes|required|integer|min:1',
            'size' => 'sometimes|nullable|string|max:50',
            'bed_type' => 'sometimes|nullable|string|max:100',
            'status' => 'sometimes|nullable|string|in:available,maintenance',
        ];
    }
}
