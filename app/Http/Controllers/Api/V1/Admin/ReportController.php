<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 * name="Super Admin - Reports",
 * description="Endpoint untuk laporan dan analitik (Super Admin)"
 * )
 */
class ReportController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/superadmin/reports/bookings",
     * summary="Laporan booking (Super Admin)",
     * tags={"Super Admin - Reports"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="start_date", in="query", required=true, @OA\Schema(type="string", format="date"), example="2025-01-01"),
     * @OA\Parameter(name="end_date", in="query", required=true, @OA\Schema(type="string", format="date"), example="2025-01-31"),
     * @OA\Response(
     * response=200,
     * description="Hasil laporan booking",
     * @OA\JsonContent(
     * @OA\Property(property="total_revenue", type="number", format="decimal", example=150000000.00),
     * @OA\Property(property="total_bookings", type="integer", example=50),
     * @OA\Property(property="top_rooms", type="array", @OA\Items(
     * @OA\Property(property="room_name", type="string", example="Deluxe Suite"),
     * @OA\Property(property="booking_count", type="integer", example=20)
     * ))
     * )
     * )
     * )
     */
    public function bookingReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        // 1. Total Pendapatan dari booking yang 'confirmed' atau 'completed'
        $totalRevenue = Booking::whereIn('booking_status', ['confirmed', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        // 2. Total Booking
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // 3. Kamar Terpopuler
        $topRooms = Booking::select('rooms.name as room_name', DB::raw('COUNT(bookings.booking_id) as booking_count'))
            ->join('rooms', 'bookings.room_id', '=', 'rooms.room_id')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('rooms.name')
            ->orderBy('booking_count', 'desc')
            ->limit(3) // Ambil 3 teratas
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start' => $startDate,
                    'end' => $endDate,
                ],
                'total_revenue' => (float) $totalRevenue,
                'total_bookings' => $totalBookings,
                'top_rooms' => $topRooms,
            ]
        ]);
    }

    /**
     * @OA\Get(
     * path="/api/v1/superadmin/reports/occupancy",
     * summary="Laporan tingkat hunian (Super Admin)",
     * tags={"Super Admin - Reports"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="month", in="query", required=true, @OA\Schema(type="integer"), example=1),
     * @OA\Parameter(name="year", in="query", required=true, @OA\Schema(type="integer"), example=2025),
     * @OA\Response(response=200, description="Hasil laporan hunian")
     * )
     */
    public function occupancyReport(Request $request)
    {
        // Fitur ini lebih kompleks dan memerlukan logika penghitungan
        // malam yang dipesan per kamar vs total malam yang tersedia.
        // Untuk saat ini, kita kembalikan placeholder.
        
        // TODO: Implementasikan logika kalkulasi okupansi yang mendalam.
        
        return response()->json([
            'success' => true,
            'message' => 'Fitur laporan okupansi sedang dalam pengembangan.',
            'data' => [
                'room_id' => 1,
                'name' => 'Deluxe Suite',
                'occupancy_rate_placeholder' => '75%',
                'booked_days_placeholder' => 23,
            ]
        ]);
    }
}