<?php

namespace App\Http\Requests\Opname;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePenyesuaianRequest extends FormRequest
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
        $rules = [
            'stok_opname_id' => ['required', 'exists:stok_opnames,id'],
        ];

        // Untuk create (multiple items)
        if ($this->isMethod('post')) {
            $rules['items'] = ['required', 'array', 'min:1'];
            $rules['items.*.barang_id'] = ['required', 'exists:barangs,id'];
            $rules['items.*.qty_fisik'] = ['required', 'integer', 'min:0'];
            $rules['items.*.keterangan'] = ['nullable', 'string'];
        }

        // Untuk update (single item)
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['barang_id'] = ['required', 'exists:barangs,id'];
            $rules['qty_fisik'] = ['required', 'integer', 'min:0'];
            $rules['keterangan'] = ['nullable', 'string'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'stok_opname_id' => 'stok opname',
            'items' => 'item penyesuaian',
            'items.*.barang_id' => 'barang',
            'items.*.qty_fisik' => 'jumlah fisik',
            'items.*.keterangan' => 'keterangan',
        ];
    }

    public function messages(): array
    {
        return [
            'stok_opname_id.required' => 'Stok opname wajib dipilih.',
            'stok_opname_id.exists' => 'Stok opname tidak valid.',
            'items.*.barang_id.required' => 'Barang wajib dipilih.',
            'items.*.barang_id.exists' => 'Barang tidak valid.',
            'items.*.qty_fisik.required' => 'Jumlah fisik wajib diisi.',
            'items.*.qty_fisik.integer' => 'Jumlah fisik harus berupa angka bulat.',
            'items.*.qty_fisik.min' => 'Jumlah fisik tidak boleh negatif.',
            'items.*.keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }
}
