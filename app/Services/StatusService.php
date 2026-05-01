<?php

namespace App\Services;

use App\Models\StatusBarang;
use App\Repositories\StatusRepository;
use Illuminate\Validation\ValidationException;

class StatusService
{
    public function __construct(
        private readonly StatusRepository $repository
    ) {}

    public function paginate(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function create(array $data)
    {
        $this->validateUniqueNamaStatus($data['nama_status']);

        return $this->repository->create($data);
    }

    public function update(StatusBarang $statusBarang, array $data)
    {
        if (
            isset($data['nama_status']) &&
            $data['nama_status'] !== $statusBarang->nama_status
        ) {
            $this->validateUniqueNamaStatus(
                $data['nama_status'],
                $statusBarang->id
            );
        }

        return $this->repository->update($statusBarang, $data);
    }

    public function delete(StatusBarang $statusBarang)
    {
        return $this->repository->delete($statusBarang);
    }

    public function bulkDelete(array $ids)
    {
        return $this->repository->bulkDelete($ids);
    }

    private function validateUniqueNamaStatus(
        string $namaStatus,
        ?string $ignoreId = null
    ): void {
        $query = StatusBarang::where('nama_status', $namaStatus);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'nama_status' => 'Status barang dengan nama yang sama sudah ada.',
            ]);
        }
    }
}
