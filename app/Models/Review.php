<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Review",
 * title="Review",
 * description="Model Ulasan Pelanggan",
 * @OA\Property(property="review_id", type="integer", example=1),
 * @OA\Property(property="booking_id", type="integer", example=101),
 * @OA\Property(property="user_id", type="integer", example=5),
 * @OA\Property(property="rating", type="integer", example=5, minimum=1, maximum=5),
 * @OA\Property(property="comment", type="string", example="Pelayanan sangat memuaskan!"),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Relasi: Ulasan ini milik satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Ulasan ini milik satu Booking.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}