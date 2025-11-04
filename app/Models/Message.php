<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Message",
 * title="Message",
 * description="Model Pesan Kontak",
 * @OA\Property(property="message_id", type="integer", example=1),
 * @OA\Property(property="sender_name", type="string", example="Budi"),
 * @OA\Property(property="sender_email", type="string", format="email", example="budi@example.com"),
 * @OA\Property(property="subject", type="string", example="Pertanyaan"),
 * @OA\Property(property="message_body", type="string", example="Apakah tersedia..."),
 * @OA\Property(property="is_read", type="boolean", example=false),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';

    protected $fillable = [
        'sender_name',
        'sender_email',
        'subject',
        'message_body',
        'is_read', // Admin bisa mengubah ini
    ];

    /**
     * Tipe data untuk is_read
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];
}