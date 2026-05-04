<?php

namespace App\Repositories;

use App\Models\Barang;
use App\Models\Penyesuaian;
use App\Models\StokOpname;
use Illuminate\Database\Eloquent\Collection;

class StokOpnameRepository
{
    public function create(array $data): StokOpname
    {
        return StokOpname::create($data);
    }

    public function findById(string $id): ?StokOpname
    {
        return StokOpname::with(['user', 'namaRuang', 'penyesuaian.barang'])
            ->find($id);
    }

    public function getAll(int $perPage = 15, array $filters = [])
    {
        return StokOpname::query()
            ->with(['user', 'namaRuang', 'penyesuaian'])
            // Filter Ruang
            ->when($filters['ruang_id'] ?? null, function ($query, $ruangId) {
                $query->where('nama_ruang_id', $ruangId);
            })
            // Filter Rentang Tanggal
            ->when($filters['tanggal_dari'] ?? null, function ($query, $tglDari) {
                $query->whereDate('tanggal_so', '>=', $tglDari);
            })
            ->when($filters['tanggal_sampai'] ?? null, function ($query, $tglSampai) {
                $query->whereDate('tanggal_so', '<=', $tglSampai);
            })
            // Global Search
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('namaRuang', fn($sq) => $sq->where('nama_ruang', 'like', "%{$search}%"))
                        ->orWhereHas('user', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString(); // Agar link pagination tidak hilang saat difilter
    }

    public function getBarangByRuang(string $ruangId): Collection
    {
        return Barang::where('nama_ruang_id', $ruangId)
            ->select('id', 'kode_barang', 'nama_barang', 'jml_barang')
            ->get();
    }

    public function findBarangById(string $id): Barang
    {
        return Barang::findOrFail($id);
    }

    public function createPenyesuaian(array $data): Penyesuaian
    {
        return Penyesuaian::create($data);
    }

    public function getPenyesuaianByStokOpname(string $stokOpnameId): Collection
    {
        return Penyesuaian::where('stok_opname_id', $stokOpnameId)
            ->with(['barang', 'user'])
            ->get();
    }

    public function updateBarangStock(string $barangId, int $qtyFisik): void
    {
        Barang::where('id', $barangId)->update(['jml_barang' => $qtyFisik]);
    }
}
