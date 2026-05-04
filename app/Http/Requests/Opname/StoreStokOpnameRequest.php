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

            'items' => ['required', 'array', 'min:1'],
            'items.*.barang_id' => ['required', 'exists:barangs,id'],
            'items.*.qty_fisik' => ['required', 'integer', 'min:0'],
            'items.*.keterangan' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'tanggal_so' => 'tanggal stok opname',
            'nama_ruang_id' => 'nama ruang',
            'keterangan' => 'keterangan',
            'items' => 'items',
            'items.*.barang_id' => 'ID barang',
            'items.*.qty_fisik' => 'jumlah barang fisik',
            'items.*.keterangan' => 'keterangan item',
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

            'items.required' => 'Items wajib diisi.',
            'items.array' => 'Items harus berupa array.',
            'items.min' => 'Minimal ada 1 item.',
            'items.*.barang_id.required' => 'ID barang wajib diisi untuk setiap item.',
            'items.*.barang_id.exists' => 'ID barang yang dipilih tidak valid.',
            'items.*.qty_fisik.required' => 'Jumlah barang fisik wajib diisi untuk setiap item.',
            'items.*.qty_fisik.integer' => 'Jumlah barang fisik harus berupa angka bulat.',
            'items.*.qty_fisik.min' => 'Jumlah barang fisik tidak boleh negatif.',
            'items.*.keterangan.string' => 'Keterangan item harus berupa teks.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validasi duplikat dan keterangan sudah ditangani di Service
            // Di sini cukup validasi keterangan wajib jika ada selisih
            // tapi hanya sebagai hint saja, validasi utama di Service
        });
    }
}
