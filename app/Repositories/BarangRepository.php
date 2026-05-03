<?php

namespace App\Repositories;

use App\Models\Barang;

class BarangRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public  Barang $model
    )
    {
        //
    }

    public function paginate($perPage = 10, $search = null, array $filters = []) : \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->model->with(['jenisBarang', 'statusBarang', 'kondisiBarang', 'namaRuang'])
            ->when($search, function ($query, $search) {
                $query->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
            })
            ->when($filters['jenis_barang_id'] ?? null, function ($query, $jenisBarangId) {
                $query->where('jenis_barang_id', $jenisBarangId);
            })
            ->when($filters['status_barang_id'] ?? null, function ($query, $statusBarangId) {
                $query->where('status_barang_id', $statusBarangId);
            })
            ->when($filters['lokasi_penyimpanan_id'] ?? null, function ($query, $lokasiPenyimpananId) {
                $query->whereHas('namaRuang', function ($query) use ($lokasiPenyimpananId) {
                    $query->where('lokasi_penyimpanan_id', $lokasiPenyimpananId);
                });
            })
            ->when($filters['nama_ruang_id'] ?? null, function ($query, $namaRuangId) {
                $query->where('nama_ruang_id', $namaRuangId);
            })
            ->latest();

        return $query->paginate($perPage);
    }

    public function create(array $data) : Barang
    {
        return $this->model->create($data);
    }

    public function update(Barang $barang, array $data) : Barang
    {
        $barang->update($data);
        return $barang;
    }

    public function delete(Barang $barang) : void
    {
        $barang->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
