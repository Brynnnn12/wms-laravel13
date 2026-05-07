<?php

namespace App\Http\Requests\Opname;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStokOpnameRequest extends FormRequest
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
            'tanggal_so' => ['required', 'date'],
            'nama_ruang_id' => ['nullable', 'exists:nama_ruangs,id'],
            'keterangan' => ['nullable', 'string'],


        ];
    }

    public function attributes(): array
    {
        return [
            'tanggal_so' => 'tanggal stok opname',
            'nama_ruang_id' => 'nama ruang',
            'keterangan' => 'keterangan',
        ];
    }

    //pakai bahasa indonesia saja untuk pesan error
    public function messages(): array
    {
        return [
            'tanggal_so.required' => 'Tanggal stok opname wajib diisi.',
            'tanggal_so.date' => 'Tanggal stok opname harus berupa tanggal yang valid.',
            'nama_ruang_id.exists' => 'Nama ruang yang dipilih tidak valid.',
            'keterangan.string' => 'Keterangan harus berupa teks.',


        ];
    }


}
