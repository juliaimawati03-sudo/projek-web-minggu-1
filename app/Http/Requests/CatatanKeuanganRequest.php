<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatatanKeuanganRequest extends FormRequest
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
        return [
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|not_in:0',
            'keterangan' => 'required|string|max:500',
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.not_in' => 'Nominal tidak boleh 0.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ];
    }
}
