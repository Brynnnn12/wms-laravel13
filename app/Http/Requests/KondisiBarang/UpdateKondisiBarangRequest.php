<?php

namespace App\Http\Requests\KondisiBarang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateKondisiBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('kondisi barang.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_kondisi' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('kondisi_barangs', 'nama_kondisi')
                    ->ignore($this->route('kondisi_barang')->id),
            ],
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
            'nama_kondisi.regex' => 'Nama kondisi hanya boleh berisi huruf, angka, dan spasi.',
            'nama_kondisi.unique' => 'Nama kondisi sudah ada. Silakan gunakan nama lain.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_kondisi' => trim($this->input('nama_kondisi')),
        ]);
    }
}
