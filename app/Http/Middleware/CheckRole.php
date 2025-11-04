<?php
// ... (Konten file Middleware CheckRole.php sama seperti respons sebelumnya)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Silakan login terlebih dahulu.'
            ], 401);
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Forbidden. Anda tidak memiliki hak akses untuk sumber daya ini.'
        ], 403);
    }
}

