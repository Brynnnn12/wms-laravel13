<?php

namespace App\Http\Requests\Barang;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis_barang_id' => ['required', 'exists:jenis_barangs,id'],
            'jml_barang' => ['required', 'integer', 'min:1'],
            'harga_satuan' => ['required', 'numeric', 'min:0'],
            'masa_penyusutan' => ['nullable', 'integer', 'min:0'],
            'nilai_residual' => ['nullable', 'numeric', 'min:0'],
            'label' => ['nullable', 'string', 'max:255'],
            'status_barang_id' => ['required', 'exists:status_barangs,id'],
            'kondisi_barang_id' => ['required', 'exists:kondisi_barangs,id'],
            'nama_ruang_id' => ['required', 'exists:nama_ruangs,id'],
            'tahun_anggaran' => ['nullable', 'integer', 'digits:4', 'min:1900', 'max:' . (date('Y') + 1)],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_barang' => 'nama barang',
            'jenis_barang_id' => 'jenis barang',
            'jml_barang' => 'jumlah barang',
            'harga_satuan' => 'harga satuan',
            'masa_penyusutan' => 'masa penyusutan',
            'label' => 'label',
            'status_barang_id' => 'status barang',
            'kondisi_barang_id' => 'kondisi barang',
            'nama_ruang_id' => 'nama ruang',
            'tahun_anggaran' => 'tahun anggaran',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',
            'jenis_barang_id.required' => 'Jenis barang wajib diisi.',
            'jenis_barang_id.exists' => 'Jenis barang yang dipilih tidak valid.',
            'jml_barang.required' => 'Jumlah barang wajib diisi.',
            'jml_barang.integer' => 'Jumlah barang harus berupa angka bulat.',
            'jml_barang.min' => 'Jumlah barang harus minimal 1.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.numeric' => 'Harga satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga satuan harus minimal 0.',
            'masa_penyusutan.integer' => 'Masa penyusutan harus berupa angka bulat.',
            'masa_penyusutan.min' => 'Masa penyusutan harus minimal 0.',
            'label.string' => 'Label harus berupa teks.',
            'label.max' => 'Label tidak boleh lebih dari 255 karakter.',
            'status_barang_id.required' => 'Status barang wajib diisi.',
            'status_barang_id.exists' => 'Status barang yang dipilih tidak valid.',
            'kondisi_barang_id.required' => 'Kondisi barang wajib diisi.',
            'kondisi_barang_id.exists' => 'Kondisi barang yang dipilih tidak valid.',
            'nama_ruang_id.required' => 'Nama ruang wajib diisi.',
            'nama_ruang_id.exists' => 'Nama ruang yang dipilih tidak valid.',
            'tahun_anggaran.integer' => 'Tahun anggaran harus berupa angka.',
            'tahun_anggaran.digits' => 'Tahun anggaran harus terdiri dari 4 digit.',
            'tahun_anggaran.min' => 'Tahun anggaran minimal adalah 1900.',
            'tahun_anggaran.max' => 'Tahun anggaran maksimal adalah tahun depan (' . (date('Y') + 1) . ').',
        ];
    }
}
