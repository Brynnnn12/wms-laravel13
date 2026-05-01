<?php

namespace App\Http\Requests\JenisBarang;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJenisBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('jenis barang.update');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $jenisBarang = $this->route('jenisBarang');

        return [
            'jenis_barang' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('jenis_barangs', 'jenis_barang')
                    ->ignore($this->route('jenis_barang')->id),
            ],
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'jenis_barang' => 'jenis barang',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'jenis_barang.required' => 'Jenis barang wajib diisi.',
            'jenis_barang.string' => 'Jenis barang harus berupa teks.',
            'jenis_barang.max' => 'Jenis barang tidak boleh lebih dari 50 karakter.',
            'jenis_barang.regex' => 'Jenis barang hanya boleh berisi huruf, angka, dan spasi.',
            'jenis_barang.unique' => 'Jenis barang sudah digunakan.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'jenis_barang' => trim((string) $this->input('jenis_barang')),
        ]);
    }
}
