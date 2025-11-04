<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="RoomFacility",
 * title="Room Facility",
 * description="Model Fasilitas di dalam Kamar",
 * @OA\Property(property="facility_id", type="integer", example=201),
 * @OA\Property(property="room_id", type="integer", example=1),
 * @OA\Property(property="facility_name", type="string", example="Wi-Fi Gratis")
 * )
 */
class RoomFacility extends Model
{
    use HasFactory;
    protected $table = 'room_facilities';
    protected $primaryKey = 'facility_id';
    protected $fillable = ['room_id', 'facility_name'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}

