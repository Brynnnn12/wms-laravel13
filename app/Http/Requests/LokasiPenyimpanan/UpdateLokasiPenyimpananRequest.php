<?php

namespace App\Http\Requests\LokasiPenyimpanan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLokasiPenyimpananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(
            'update',
            $this->route('lokasiPenyimpanan')
        );
    }

    public function rules(): array
    {
        $lokasiId = $this->route('lokasiPenyimpanan')->id;

        return [
            'nama_lokasi' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9\s]+$/',

                Rule::unique('lokasi_penyimpanans', 'nama_lokasi')
                    ->ignore($lokasiId),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lokasi' => 'nama lokasi',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.unique' => 'Nama lokasi sudah digunakan.',
            'nama_lokasi.max' => 'Nama lokasi maksimal 50 karakter.',
            'nama_lokasi.regex' => 'Nama lokasi hanya boleh berisi huruf, angka, dan spasi.',
        ];
    }
}
