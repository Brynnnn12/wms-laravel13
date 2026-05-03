<?php

namespace App\Services;

use App\Models\Barang;
use App\Repositories\BarangRepository;

class BarangService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected BarangRepository $repository
    )
    {
        //
    }

    public function paginate($perPage = 10, $search = null, array $filters = []) : \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $search, $filters);
    }

    public function create(array $data) : Barang
    {
        $data['kode_barang'] = 'BRG-' . str_pad($this->repository->model->count() + 1, 4, '0', STR_PAD_LEFT);
        $data['harga_total'] = $data['harga_satuan'] * $data['jml_barang'];
        return $this->repository->create($data);
    }

    public function update(Barang $barang, array $data) : Barang
    {
        //jika harga_satuan atau jml_barang diupdate, maka harga_total juga harus diupdate
        if (isset($data['harga_satuan']) || isset($data['jml_barang'])) {
            $hargaSatuan = $data['harga_satuan'] ?? $barang->harga_satuan;
            $jmlBarang = $data['jml_barang'] ?? $barang->jml_barang;
            $data['harga_total'] = $hargaSatuan * $jmlBarang;
        }
        return $this->repository->update($barang, $data);
    }

    public function delete(Barang $barang) : void
    {
        $this->repository->delete($barang);
    }

    public function bulkDelete(array $ids) : int
    {
        return $this->repository->bulkDelete($ids);
    }
}
