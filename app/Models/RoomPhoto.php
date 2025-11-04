<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="RoomPhoto",
 * title="Room Photo",
 * description="Model Foto Kamar",
 * @OA\Property(property="photo_id", type="integer", example=101),
 * @OA\Property(property="room_id", type="integer", example=1),
 * @OA\Property(property="photo_url", type="string", format="url", example="http://example.com/images/room1.jpg"),
 * @OA\Property(property="is_primary", type="boolean", example=true)
 * )
 */
class RoomPhoto extends Model
{
    use HasFactory;
    protected $table = 'room_photos';
    protected $primaryKey = 'photo_id';
    protected $fillable = ['room_id', 'photo_url', 'is_primary'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}

