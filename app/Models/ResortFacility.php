<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="ResortFacility",
 * title="Resort Facility",
 * description="Model Fasilitas Umum Resort",
 * @OA\Property(property="resort_facility_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Infinity Pool"),
 * @OA\Property(property="description", type="string", example="Kolam renang tanpa batas menghadap laut."),
 * @OA\Property(property="photo_url", type="string", format="uri", example="https://example.com/pool.jpg")
 * )
 */
class ResortFacility extends Model
{
    use HasFactory;

    protected $primaryKey = 'resort_facility_id';
    public $timestamps = false; // Kita tidak menambahkan timestamps di migrasi ini

    protected $fillable = [
        'name',
        'description',
        'photo_url',
    ];
}

