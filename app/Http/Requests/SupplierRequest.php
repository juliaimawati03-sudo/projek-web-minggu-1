<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    /**
     * Tentukan apakah user berhak melakukan request ini.
     */
    public function authorize(): bool
    {
        // Hanya admin yang login yang boleh
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi input.
     */
    public function rules(): array
    {
        // Ambil ID supplier (untuk mode update)
        $supplierId = $this->route('supplier') ?? $this->route('id');

        return [
            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('supplier', 'nama_supplier')->ignore($supplierId),
            ],
            'no_telepon' => 'required|string|max:20',
            'alamat'     => 'required|string',
        ];
    }

    /**
     * Pesan error kustom (Bahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah terdaftar.',
            'nama_supplier.max'      => 'Nama supplier maksimal 255 karakter.',
            'no_telepon.required'    => 'Nomor telepon wajib diisi.',
            'no_telepon.max'         => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required'        => 'Alamat wajib diisi.',
        ];
    }

    /**
     * Nama atribut yang lebih friendly untuk pesan error.
     */
    public function attributes(): array
    {
        return [
            'nama_supplier' => 'Nama Supplier',
            'no_telepon'    => 'Nomor Telepon',
            'alamat'        => 'Alamat',
        ];
    }
}