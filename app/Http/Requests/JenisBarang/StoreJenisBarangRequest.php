<?php

namespace App\Http\Requests\JenisBarang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJenisBarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('jenis barang.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_barang' => ['required', 'string', 'max:50','regex:/^[a-zA-Z0-9\s]+$/'],
        ];
    }

    public function attributes(): array
    {
        return [
            'jenis_barang' => 'jenis barang',
        ];
    }


    public function messages(): array
    {
        return [
            'jenis_barang.required' => 'Jenis barang wajib diisi.',
            'jenis_barang.string' => 'Jenis barang harus berupa teks.',
            'jenis_barang.max' => 'Jenis barang tidak boleh lebih dari 50 karakter.',
            'jenis_barang.regex' => 'Jenis barang hanya boleh berisi huruf, angka, dan spasi.',
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'jenis_barang' => trim($this->input('jenis_barang')),
        ]);
    }


}
