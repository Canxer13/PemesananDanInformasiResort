<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Super Admin - Activity Log",
 * description="Endpoint untuk melihat log aktivitas sistem (Super Admin)"
 * )
 */
class ActivityLogController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/superadmin/logs",
     * summary="Melihat semua log aktivitas (Super Admin)",
     * tags={"Super Admin - Activity Log"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="page", in="query", @OA\Schema(type="integer"), example=1),
     * @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer"), example=15),
     * @OA\Response(
     * response=200,
     * description="Daftar log aktivitas (paginasi)",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ActivityLog"))
     * )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        // Ambil log, urutkan dari yang terbaru, dan gunakan eager loading 'user'
        $logs = ActivityLog::with('user:user_id,full_name') // Hanya ambil ID dan nama user
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $logs]);
    }
}