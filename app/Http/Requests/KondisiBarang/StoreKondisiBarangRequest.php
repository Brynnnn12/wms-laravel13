<?php

namespace App\Http\Requests\KondisiBarang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreKondisiBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('kondisi barang.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_kondisi' => 'required|string|max:50|unique:kondisi_barangs,nama_kondisi|regex:/^[a-zA-Z0-9\s]+$/',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_kondisi' => 'nama kondisi',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kondisi.required' => 'Nama kondisi wajib diisi.',
            'nama_kondisi.string' => 'Nama kondisi harus berupa teks.',
            'nama_kondisi.max' => 'Nama kondisi tidak boleh lebih dari 50 karakter.',
            'nama_kondisi.unique' => 'Nama kondisi sudah ada. Silakan gunakan nama lain.',
            'nama_kondisi.regex' => 'Nama kondisi hanya boleh berisi huruf, angka, dan spasi.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_kondisi' => trim($this->input('nama_kondisi')),
        ]);
    }
}
