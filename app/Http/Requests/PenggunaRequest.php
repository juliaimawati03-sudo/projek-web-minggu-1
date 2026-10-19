<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenggunaRequest extends FormRequest
{
    /**
     * Apakah user berhak melakukan request ini?
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi.
     */
    public function rules(): array
    {
        $userId = $this->route('id'); // untuk mode update

        return [
            'nama' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('user', 'username')->ignore($userId),
            ],
            'password' => $userId
                ? 'nullable|string|min:6'          // update: opsional
                : 'required|string|min:6',         // create: wajib
            'role' => 'required|in:admin,kasir,pelanggan',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:500',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.max' => 'Username maksimal 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus Admin, Kasir, atau Pelanggan.',
        ];
    }
}
