<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="StoreReviewRequest",
 * title="Store Review Request",
 * required={"booking_id", "rating"},
 * @OA\Property(property="booking_id", type="integer", example=101),
 * @OA\Property(property="rating", type="integer", example=5, minimum=1, maximum=5),
 * @OA\Property(property="comment", type="string", example="Sangat memuaskan!")
 * )
 */
class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'booking_id' => 'required|integer|exists:bookings,booking_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ];
    }

    /**
     * Validasi kustom tambahan
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $booking = Booking::find($this->booking_id);

            // 1. Cek apakah booking ada
            if (!$booking) {
                return; // Aturan 'exists' sudah menangani ini, tapi baik untuk safety
            }

            // 2. Cek apakah booking ini milik user yang sedang login
            if ($booking->user_id !== Auth::id()) {
                $validator->errors()->add('booking_id', 'Anda tidak berhak memberi ulasan untuk booking ini.');
                return;
            }

            // 3. Cek apakah status booking sudah 'completed'
            if ($booking->booking_status !== 'completed') {
                $validator->errors()->add('booking_id', 'Anda hanya bisa memberi ulasan untuk booking yang sudah selesai.');
                return;
            }

            // 4. Cek apakah user sudah pernah memberi ulasan untuk booking ini
            $existingReview = \App\Models\Review::where('booking_id', $this->booking_id)->first();
            if ($existingReview) {
                $validator->errors()->add('booking_id', 'Anda sudah pernah memberi ulasan untuk booking ini.');
            }
        });
    }
}