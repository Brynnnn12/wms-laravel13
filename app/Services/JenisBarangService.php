<?php

namespace App\Services;

use App\Models\JenisBarang;
use App\Repositories\JenisBarangRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JenisBarangService
{
    public function __construct(
        private readonly JenisBarangRepository $repository
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function create(array $data): JenisBarang
    {
        $data['kode_jenis'] = $this->generateKodeJenis();

        return $this->repository->create($data);
    }

    public function update(JenisBarang $jenisBarang, array $data): JenisBarang
    {
        unset($data['kode_jenis']);

        return $this->repository->update($jenisBarang, $data);
    }

    public function delete(JenisBarang $jenisBarang): bool
    {
        return $this->repository->delete($jenisBarang);
    }

    public function bulkDelete(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }

    /**
     * Format:
     * JNS-2026-001
     * JNS-2026-002
     * Reset tiap awal tahun
     */
    private function generateKodeJenis(): string
    {
        $year = now()->format('Y');

        $latest = JenisBarang::query()
            ->whereYear('created_at', $year)
            ->where('kode_jenis', 'like', "JNS-$year-%")
            ->latest('id')
            ->first();

        if (! $latest) {
            return "JNS-$year-001";
        }

        preg_match('/(\d+)$/', $latest->kode_jenis, $matches);

        $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        $nextNumber = $lastNumber + 1;

        return 'JNS-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
