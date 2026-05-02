<?php

namespace App\Http\Requests\StatusBarang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStatusBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_status' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\s]+$/', 'unique:status_barangs,nama_status'],
        ];
    }


    public function attributes(): array
    {
        return [
            'nama_status' => 'Nama Status Barang',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_status.required' => 'Nama status barang wajib diisi.',
            'nama_status.string' => 'Nama status barang harus berupa teks.',
            'nama_status.max' => 'Nama status barang tidak boleh lebih dari 50 karakter.',
            'nama_status.regex' => 'Nama status barang hanya boleh mengandung huruf, angka, dan spasi.',
            'nama_status.unique' => 'Nama status barang sudah ada. Silakan gunakan nama lain.',
        ];
    }
}
