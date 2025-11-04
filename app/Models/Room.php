<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Room",
 * title="Room",
 * description="Model Tipe Kamar",
 * @OA\Property(property="room_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Deluxe Ocean View"),
 * @OA\Property(property="description", type="string", example="Kamar indah dengan pemandangan laut."),
 * @OA\Property(property="price_per_night", type="number", format="decimal", example=2500000.00),
 * @OA\Property(property="capacity", type="integer", example=2),
 * @OA\Property(property="size", type="string", example="45 m²"),
 * @OA\Property(property="bed_type", type="string", example="1 King Bed"),
 * @OA\Property(property="status", type="string", enum={"available", "maintenance"}, example="available")
 * )
 *
 * @OA\Schema(
 * schema="RoomWithRelations",
 * title="Room With Relations",
 * description="Model Kamar dengan relasi foto dan fasilitas",
 * allOf={@OA\Schema(ref="#/components/schemas/Room")},
 * @OA\Property(
 * property="photos",
 * type="array",
 * @OA\Items(ref="#/components/schemas/RoomPhoto")
 * ),
 * @OA\Property(
 * property="facilities",
 * type="array",
 * @OA\Items(ref="#/components/schemas/RoomFacility")
 * )
 * )
 */
class Room extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_id';
    protected $fillable = ['name', 'description', 'price_per_night', 'capacity', 'size', 'bed_type', 'status'];

    // Relasi
    public function photos()
    {
        return $this->hasMany(RoomPhoto::class, 'room_id', 'room_id');
    }
    public function facilities()
    {
        return $this->hasMany(RoomFacility::class, 'room_id', 'room_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'room_id');
    }
}

