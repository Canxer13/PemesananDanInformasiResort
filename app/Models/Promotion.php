<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Promotion",
 * title="Promotion",
 * description="Model Promo Resort",
 * @OA\Property(property="promo_id", type="integer", example=1),
 * @OA\Property(property="title", type="string", example="Diskon Liburan Sekolah"),
 * @OA\Property(property="description", type="string", example="Diskon 30% untuk pemesanan di bulan Juni."),
 * @OA\Property(property="image_url", type="string", format="uri", example="https://example.com/promo.jpg"),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-06-01"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-06-30")
 * )
 */
class Promotion extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'promo_id';
    public $timestamps = false; // Kita tidak menambahkan timestamps di migrasi ini

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'promo_code',
        'start_date',
        'end_date',
    ];

    /**
     * Tipe data untuk tanggal
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}