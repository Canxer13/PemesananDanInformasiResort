<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="User",
 * title="User",
 * description="Model Pengguna",
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="full_name", type="string", example="John Doe"),
 * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 * @OA\Property(property="phone_number", type="string", example="08123456789"),
 * @OA\Property(property="role", type="string", enum={"pelanggan", "admin", "super_admin"}, example="pelanggan"),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['full_name', 'email', 'password', 'phone_number', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    // Otomatis hash password saat di-set
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }

    // Relasi
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'user_id');
    }
}

