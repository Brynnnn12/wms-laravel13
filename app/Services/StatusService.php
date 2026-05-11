<?php

namespace App\Services;

use App\Models\StatusBarang;
use App\Repositories\StatusRepository;

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
        return $this->repository->create($data);
    }

    public function update(StatusBarang $statusBarang, array $data)
    {

    }

    public function delete(StatusBarang $statusBarang)
    {
        if ($statusBarang->barangs()->count() > 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'status_barang_id' => 'Status barang tidak bisa dihapus karena masih digunakan oleh barang.',
            ]);
        };
        return $this->repository->delete($statusBarang);
    }

    public function bulkDelete(array $ids)
    {
        if (StatusBarang::whereIn('id', $ids)->whereHas('barangs')->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'status_barang_id' => 'Beberapa status barang tidak bisa dihapus karena masih digunakan oleh barang.',
            ]);
        };
        return $this->repository->bulkDelete($ids);
    }


}
