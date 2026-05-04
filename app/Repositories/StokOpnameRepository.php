<?php

namespace App\Repositories;

use App\Models\Barang;
use App\Models\Penyesuaian;
use App\Models\StokOpname;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
        $query = StokOpname::query()
            ->with(['user', 'namaRuang', 'penyesuaian']);

        // ✅ LOGIKA POLICY: Jika bukan super-admin, hanya ambil data milik sendiri
        // Ini memastikan user Inventaris tidak melihat daftar opname orang lain
        if (!Auth::user()->hasRole('super-admin')) {
            $query->where('user_id', Auth::id());
        }

        return $query
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
            ->withQueryString();
    }

    public function getBarangByRuang(string $ruangId): Collection
    {
        // Tetap seperti ini, sudah benar untuk menyuplai "Kamus Barang" ke Frontend
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

    public function updateBarangStock(string $barangId, int $qtyFisik): void
    {
        // Menggunakan update pada instance model agar trigger observer (jika ada) tetap jalan
        $barang = Barang::find($barangId);
        if ($barang) {
            $barang->update(['jml_barang' => $qtyFisik]);
        }
    }
}
