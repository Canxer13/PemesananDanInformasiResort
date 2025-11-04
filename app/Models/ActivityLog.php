<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="ActivityLog",
 * title="Activity Log",
 * description="Model Log Aktivitas",
 * @OA\Property(property="log_id", type="integer", example=1),
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="action", type="string", example="booking_updated"),
 * @OA\Property(property="description", type="string", example="Admin mengubah status booking..."),
 * @OA\Property(property="model_type", type="string", example="App\Models\Booking"),
 * @OA\Property(property="model_id", type="integer", example=101),
 * @OA\Property(property="ip_address", type="string", example="127.0.0.1"),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class ActivityLog extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
    ];

    /**
     * Relasi: Log ini milik satu User (pelaku).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}