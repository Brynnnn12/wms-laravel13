<?php

namespace App\Repositories;

use App\Models\Penyusutan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PenyusutanRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(
        protected Penyusutan $model
    ) {
    }

    /**
     * Simpan atau perbarui data penyusutan berdasarkan unique key.
     */
    public function updateOrCreatePenyusutan(array $attributes, array $values): Penyusutan
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Ambil laporan penyusutan per periode.
     */
    public function getLaporan(int $bulan, int $tahun, int $perPage = 10): LengthAwarePaginator
    {
        return $this->baseQuery($bulan, $tahun)
            ->orderBy('barang_id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Cek apakah penyusutan sudah ada untuk barang dan periode tertentu.
     */
    public function cekExist(string $barangId, int $bulan, int $tahun): bool
    {
        return $this->model->newQuery()
            ->where('barang_id', $barangId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }

    /**
     * Ringkasan total aset dan nilai buku per periode.
     *
     * @return array{total_barang:int, total_nilai_buku:float}
     */
    public function getSummary(int $bulan, int $tahun): array
    {
        $query = $this->model->newQuery()
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);

        return [
            'total_barang' => (int) $query->distinct('barang_id')->count('barang_id'),
            'total_nilai_buku' => (float) $query->sum('nilai_buku'),
        ];
    }

    /**
     * Query dasar laporan penyusutan.
     */
    private function baseQuery(int $bulan, int $tahun): Builder
    {
        return $this->model->newQuery()
            ->with('barang')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);
    }
}
