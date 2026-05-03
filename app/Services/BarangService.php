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
        $data['kode_barang'] = $this->generateKodeBarang();
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

    private function generateKodeBarang(): string
    {
        $year = now()->format('Y');

        // Mencari kode terakhir di tahun yang sama
        $latest = Barang::query()
            ->whereYear('created_at', $year)
            ->where('kode_barang', 'like', "BRG-$year-%")
            ->latest('id')
            ->first();

        if (! $latest) {
            return "BRG-$year-0001";
        }

        // Mengambil angka urut terakhir menggunakan regex
        preg_match('/(\d+)$/', $latest->kode_barang, $matches);

        $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        $nextNumber = $lastNumber + 1;

        return "BRG-$year-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
