<?php

namespace App\Services;

use App\Models\Barang;
use App\Repositories\BarangRepository;
use App\Models\Penyesuaian;
use App\Models\Penyusutan;
use Carbon\Carbon; // Pastikan Carbon diimport

class BarangService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected BarangRepository $repository
    ) {
        //
    }

    public function paginate($perPage = 10, $search = null, array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $search, $filters);
    }

    public function create(array $data): Barang
    {
        // 1. Pass $data ke generateKodeBarang agar bisa baca tanggal_perolehan
        $data['kode_barang'] = $this->generateKodeBarang($data);

        // 2. Kalkulasi harga total
        $data['harga_total'] = $data['harga_satuan'] * $data['jml_barang'];

        return $this->repository->create($data);
    }

    public function update(Barang $barang, array $data): Barang
    {
        if (Penyesuaian::where('barang_id', $barang->id)->exists() || Penyusutan::where('barang_id', $barang->id)->exists()) {
            throw new \Exception('Barang sudah di-stok opname atau penyusutan, tidak bisa diedit.');
        }
        // Jangan ubah jumlah barang (jml_barang) di update
        unset($data['jml_barang']);

        //jika harga_satuan diupdate, maka harga_total juga harus diupdate
        if (isset($data['harga_satuan'])) {
            $hargaSatuan = $data['harga_satuan'];
            $jmlBarang = $barang->jml_barang;
            $data['harga_total'] = $hargaSatuan * $jmlBarang;
        }
        return $this->repository->update($barang, $data);
    }

    public function delete(Barang $barang): void
    {
        if (Penyesuaian::where('barang_id', $barang->id)->exists() || Penyusutan::where('barang_id', $barang->id)->exists()) {
            throw new \Exception('Barang sudah di-stok opname atau penyusutan, tidak bisa dihapus.');
        }
        $this->repository->delete($barang);
    }

    public function bulkDelete(array $ids): int
    {
        $barangs = Barang::whereIn('id', $ids)->get();
        foreach ($barangs as $barang) {
            if (Penyesuaian::where('barang_id', $barang->id)->exists() || Penyusutan::where('barang_id', $barang->id)->exists()) {
                throw new \Exception('Salah satu barang sudah di-stok opname atau penyusutan, tidak bisa dihapus.');
            }
        }
        return $this->repository->bulkDelete($ids);
    }

    private function generateKodeBarang(array $data): string
    {
        // Ambil tahun dari tanggal_perolehan, jika tidak ada baru gunakan tahun sekarang
        $year = isset($data['tanggal_perolehan'])
            ? Carbon::parse($data['tanggal_perolehan'])->format('Y')
            : now()->format('Y');

        $latest = Barang::query()
            ->whereYear('tanggal_perolehan', $year) // Cari berdasarkan tanggal beli
            ->where('kode_barang', 'like', "BRG-$year-%")
            ->latest('kode_barang') // Urutkan berdasarkan kode stringnya
            ->first();

        if (!$latest) {
            return "BRG-$year-0001";
        }

        preg_match('/(\d+)$/', $latest->kode_barang, $matches);
        $lastNumber = isset($matches) ? (int) $matches : 0;
        $nextNumber = $lastNumber + 1;

        return "BRG-$year-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
