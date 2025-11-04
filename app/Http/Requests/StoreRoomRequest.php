<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StoreRoomRequest",
 * title="Store Room Request",
 * required={"name", "description", "price_per_night", "capacity"},
 * @OA\Property(property="name", type="string", example="Suite Mewah"),
 * @OA\Property(property="description", type="string", example="Deskripsi lengkap suite mewah."),
 * @OA\Property(property="price_per_night", type="number", format="decimal", example=5000000.00),
 * @OA\Property(property="capacity", type="integer", example=4),
 * @OA\Property(property="size", type="string", example="100 m²"),
 * @OA\Property(property="bed_type", type="string", example="2 King Beds"),
 * @OA\Property(property="status", type="string", enum={"available", "maintenance"}, example="available")
 * )
 */
class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh middleware 'role:admin,super_admin'
        // Jadi kita bisa return true di sini
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:50',
            'bed_type' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:available,maintenance',
        ];
    }
}
