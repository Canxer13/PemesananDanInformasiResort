<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA; // Pastikan ini ada

/**
 * @OA\Info(
 * version="1.0.0",
 * title="API De Tuna Resort",
 * description="Dokumentasi API untuk Sistem Informasi & Pemesanan De Tuna Resort",
 * @OA\Contact(
 * email="admin@detuna.com"
 * )
 * )
 * @OA\Server(
 * url="http://127.0.0.1:8000",
 * description="Server API De Tuna (Lokal - php artisan serve)"
 * )
 * @OA\Server(
 * url="http://detuna-api.test",
 * description="Server API De Tuna (Lokal - Laragon)"
 * )
 * @OA\SecurityScheme(
 * securityScheme="sanctum",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Masukkan token (Bearer Token)"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}