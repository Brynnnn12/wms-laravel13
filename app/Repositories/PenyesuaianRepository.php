<?php

namespace App\Repositories;

use App\Models\Penyesuaian;
use App\Models\StokOpname;
use Illuminate\Database\Eloquent\Collection;

class PenyesuaianRepository
{
    public function create(array $data): Penyesuaian
    {
        return Penyesuaian::create($data);
    }

    public function findById(string $id): ?Penyesuaian
    {
        return Penyesuaian::with(['stokOpname', 'barang', 'user'])->find($id);
    }

    public function findByStokOpnameAndBarang(string $stokOpnameId, string $barangId): ?Penyesuaian
    {
        return Penyesuaian::where('stok_opname_id', $stokOpnameId)
            ->where('barang_id', $barangId)
            ->first();
    }

    public function findByStokOpname(string $stokOpnameId): Collection
    {
        return Penyesuaian::where('stok_opname_id', $stokOpnameId)->get();
    }

    public function getAll(int $perPage = 15, array $filters = [])
    {
        $query = Penyesuaian::query()
            ->with(['stokOpname', 'barang', 'user']);

        // Filter Stok Opname
        if ($filters['stok_opname_id'] ?? null) {
            $query->where('stok_opname_id', $filters['stok_opname_id']);
        }

        // Filter Barang
        if ($filters['barang_id'] ?? null) {
            $query->where('barang_id', $filters['barang_id']);
        }

        // Search
        if ($filters['search'] ?? null) {
            $query->where(function ($q) use ($filters) {
                $q->whereHas('barang', fn($sq) => $sq->where('nama_barang', 'like', "%{$filters['search']}%"))
                    ->orWhereHas('stokOpname', fn($sq) => $sq->whereHas('namaRuang', fn($ssq) => $ssq->where('nama_ruang', 'like', "%{$filters['search']}%")));
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function getQtySistem(string $barangId): int
    {
        return \App\Models\Barang::find($barangId)->jml_barang ?? 0;
    }

    public function getBarangName(string $barangId): string
    {
        return \App\Models\Barang::find($barangId)->nama_barang ?? 'Unknown';
    }

    public function getStokOpnamesForPenyesuaian(): Collection
    {
        /**
         * Ambil stok opname yang belum memiliki penyesuaian sama sekali.
         * Ini mencegah duplikasi penyesuaian untuk sesi opname yang sama.
         */
        return StokOpname::with('namaRuang')
            ->whereDoesntHave('penyesuaian') // Hanya ambil yang belum ada penyesuaian
            ->orderBy('tanggal_so', 'desc')
            ->get();
    }
}
