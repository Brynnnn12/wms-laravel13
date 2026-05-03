<?php

namespace App\Services;

use App\Models\JenisBarang;
use App\Repositories\JenisBarangRepository;
use Illuminate\Support\Facades\DB;

class JenisBarangService
{
    /**
     * Pastikan nama class sesuai dengan nama file: JenisBarangService
     */
    public function __construct(
        private readonly JenisBarangRepository $repository
    ) {
    }

    /**
     * Menampilkan data dengan pagination dan pencarian
     */
    public function paginate(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * Membuat jenis barang baru dengan generate kode otomatis
     */
    public function create(array $data): JenisBarang
    {
        return DB::transaction(function () use ($data) {
            $data['kode_jenis'] = $this->generateKodeJenis();

            return $this->repository->create($data);
        });
    }

    /**
     * Memperbarui data jenis barang
     */
    public function update(JenisBarang $jenis_barang, array $data): JenisBarang
    {
        return $this->repository->update($jenis_barang, $data);
    }

    /**
     * Menghapus satu data jenis barang
     */
    public function delete(JenisBarang $jenis_barang): bool|null
    {
        return $this->repository->delete($jenis_barang);
    }

    /**
     * Menghapus banyak data sekaligus
     */
    public function bulkDelete(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }

    /**
     * Logika Generate Kode Jenis: JNS-2026-001
     */
    private function generateKodeJenis(): string
    {
        $year = now()->format('Y');

        // Mencari kode terakhir di tahun yang sama
        $latest = JenisBarang::query()
            ->whereYear('created_at', $year)
            ->where('kode_jenis', 'like', "JNS-$year-%")
            ->latest('id')
            ->first();

        if (! $latest) {
            return "JNS-$year-001";
        }

        // Mengambil angka urut terakhir menggunakan regex
        preg_match('/(\d+)$/', $latest->kode_jenis, $matches);

        $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        $nextNumber = $lastNumber + 1;

        return 'JNS-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
