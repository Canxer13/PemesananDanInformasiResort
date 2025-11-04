<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Booking",
 * title="Booking",
 * description="Model Pemesanan",
 * @OA\Property(property="booking_id", type="integer", example=1),
 * @OA\Property(property="booking_code", type="string", example="DT-20251021-XYZ"),
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="room_id", type="integer", example=1),
 * @OA\Property(property="check_in_date", type="string", format="date", example="2025-12-20"),
 * @OA\Property(property="check_out_date", type="string", format="date", example="2025-12-22"),
 * @OA\Property(property="total_price", type="number", format="decimal", example=5000000.00),
 * @OA\Property(property="booking_status", type="string", enum={"pending", "confirmed", "canceled", "completed"}, example="pending"),
 * @OA\Property(property="payment_status", type="string", enum={"pending", "paid", "failed"}, example="pending"),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class Booking extends Model
{
    use HasFactory;
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'booking_code', 'user_id', 'room_id', 'check_in_date', 'check_out_date',
        'total_price', 'booking_status', 'payment_status',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id', 'booking_id');
    }
}

