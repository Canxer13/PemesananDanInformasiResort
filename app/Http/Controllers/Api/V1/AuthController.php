<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/register",
     * summary="Registrasi Pengguna Baru",
     * tags={"Auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"full_name", "email", "password", "password_confirmation"},
     * @OA\Property(property="full_name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     * @OA\Property(property="phone_number", type="string", example="08123456789")
     * )
     * ),
     * @OA\Response(response=201, description="Registrasi berhasil", @OA\JsonContent(ref="#/components/schemas/User")),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Password sudah di-hash otomatis oleh Model User
        $user = User::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data' => $user
        ], 201);
    }

    /**
     * @OA\Post(
     * path="/api/v1/login",
     * summary="Login Pengguna",
     * tags={"Auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email", "password"},
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123")
     * )
     * ),
     * @OA\Response(response=200, description="Login berhasil", @OA\JsonContent(
     * @OA\Property(property="token", type="string", example="1|Abc..."),
     * @OA\Property(property="user", ref="#/components/schemas/User")
     * )),
     * @OA\Response(response=401, description="Kredensial salah")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'Kredensial yang diberikan salah.'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ], 200);
    }

    /**
     * @OA\Post(
     * path="/api/v1/logout",
     * summary="Logout Pengguna",
     * tags={"Auth"},
     * security={{"sanctum":{}}},
     * @OA\Response(response=200, description="Logout berhasil")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logout berhasil.'], 200);
    }

    /**
     * @OA\Get(
     * path="/api/v1/me",
     * summary="Get Data Pengguna (Current)",
     * tags={"Auth"},
     * security={{"sanctum":{}}},
     * @OA\Response(response=200, description="Data pengguna", @OA\JsonContent(ref="#/components/schemas/User"))
     * )
     */
    public function me(Request $request)
    {
         return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $request->user()
        ], 200);
    }
}
