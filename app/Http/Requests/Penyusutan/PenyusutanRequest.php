<?php

namespace App\Http\Requests\Penyusutan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PenyusutanRequest extends FormRequest
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
            'bulan' => ['required', 'integer', 'min:1', 'max:12'],
            'tahun' => ['required', 'integer', 'min:2000'],
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'bulan' => 'bulan',
            'tahun' => 'tahun',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'bulan.required' => 'Bulan wajib diisi.',
            'bulan.integer' => 'Bulan harus berupa angka.',
            'bulan.min' => 'Bulan minimal 1.',
            'bulan.max' => 'Bulan maksimal 12.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2000.',
        ];
    }
}
