<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan yang request adalah Super Admin
        return Auth::check() && Auth::user()->role == 'super_admin';
    }

    public function rules(): array
    {
        // Dapatkan user ID dari URL
        $userId = $this->route('id');

        return [
            'full_name' => 'sometimes|required|string|max:255',
            // Pastikan email unik, TAPI abaikan user ID saat ini
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId, 'user_id'),
            ],
            'phone_number' => 'sometimes|nullable|string|max:20',
            'role' => 'sometimes|required|string|in:pelanggan,admin,super_admin',
        ];
    }
}