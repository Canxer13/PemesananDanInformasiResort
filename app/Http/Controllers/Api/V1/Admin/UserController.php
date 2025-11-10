<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use OpenApi\Annotations as OA;
use App\Http\Requests\UpdateUserRequest;

/**
 * @OA\Tag(
 * name="Super Admin - Users",
 * description="Endpoint untuk manajemen user oleh Super Admin"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Put(
     * path="/api/v1/superadmin/users/{id}",
     * summary="Update data pengguna (Super Admin)",
     * tags={"Super Admin - Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="full_name", type="string", example="Admin Diedit"),
     * @OA\Property(property="email", type="string", format="email", example="adminbaru@detuna.com"),
     * @OA\Property(property="role", type="string", enum={"pelanggan", "admin"}, example="admin")
     * )
     * ),
     * @OA\Response(response=200, description="Pengguna berhasil diupdate", @OA\JsonContent(ref="#/components/schemas/User")),
     * @OA\Response(response=404, description="Pengguna tidak ditemukan"),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.'], 404);
        }

        $validatedData = $request->validated();
        $user->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Pengguna berhasil diupdate.', 'data' => $user]);
    }
    
    /**
     * @OA\Get(
     * path="/api/v1/superadmin/users",
     * summary="Get semua data pengguna (Super Admin)",
     * tags={"Super Admin - Users"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     * response=200,
     * description="Daftar semua pengguna",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     * ),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['success' => true, 'data' => $users]);
    }

    /**
     * @OA\Post(
     * path="/api/v1/superadmin/users/admin",
     * summary="Membuat akun Admin baru (Super Admin)",
     * tags={"Super Admin - Users"},
     * security={{"sanctum":{}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data akun admin baru",
     * @OA\JsonContent(
     * required={"full_name", "email", "password"},
     * @OA\Property(property="full_name", type="string", example="Admin Baru"),
     * @OA\Property(property="email", type="string", format="email", example="adminbaru@detuna.com"),
     * @OA\Property(property="password", type="string", format="password", example="passwordadmin123")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Akun admin berhasil dibuat",
     * @OA\JsonContent(ref="#/components/schemas/User")
     * ),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function createAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::min(8)],
        ]);
        
        // Tambahkan 'role' secara manual
        $validatedData['role'] = 'admin';

        // Password akan di-hash secara otomatis oleh Model User
        $user = User::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Akun admin berhasil dibuat.', 'data' => $user], 201);
    }

    /**
     * @OA\Delete(
     * path="/api/v1/superadmin/users/{id}",
     * summary="Menghapus pengguna (Super Admin)",
     * tags={"Super Admin - Users"},
     * security={{"sanctum":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Pengguna berhasil dihapus"),
     * @OA\Response(response=404, description="Pengguna tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.'], 404);
        }

        // Tambahkan logika agar tidak bisa menghapus diri sendiri
        if ($user->user_id == auth()->id()) {
             return response()->json(['success' => false, 'message' => 'Anda tidak bisa menghapus akun Anda sendiri.'], 403);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.'], 200);
    }
}

