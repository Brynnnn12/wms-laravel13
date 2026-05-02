<?php

namespace App\Http\Requests\LokasiPenyimpanan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLokasiPenyimpananRequest extends FormRequest
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
            'nama_lokasi' => ['required', 'string', 'max:50', 'unique:lokasi_penyimpanans,nama_lokasi'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lokasi.required' => 'Nama lokasi penyimpanan wajib diisi.',
            'nama_lokasi.string' => 'Nama lokasi penyimpanan harus berupa string.',
            'nama_lokasi.max' => 'Nama lokasi penyimpanan tidak boleh lebih dari 50 karakter.',
            'nama_lokasi.unique' => 'Nama lokasi penyimpanan sudah ada, silakan gunakan nama lain.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lokasi' => 'Nama Lokasi Penyimpanan',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'nama_lokasi' => trim($this->nama_lokasi),
        ]);
    }
}
