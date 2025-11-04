<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StoreBookingRequest",
 * title="Store Booking Request",
 * required={"room_id", "check_in_date", "check_out_date", "total_price"},
 * @OA\Property(property="room_id", type="integer", example=1),
 * @OA\Property(property="check_in_date", type="string", format="date", example="2025-12-20"),
 * @OA\Property(property="check_out_date", type="string", format="date", example="2025-12-22"),
 * @OA\Property(property="total_price", type="number", format="decimal", example=5000000.00),
 * @OA\Property(property="guests", type="integer", example=2, description="Jumlah tamu")
 * )
 */
class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi ditangani oleh middleware 'auth:sanctum' pada rute
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
            'room_id' => 'required|integer|exists:rooms,room_id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required|numeric|min:0',
            'guests' => 'nullable|integer|min:1',
        ];
    }
}