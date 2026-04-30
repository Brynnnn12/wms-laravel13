<?php

namespace App\Repositories;

use App\Models\JenisBarang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JenisBarangRepository
{
    public function __construct(
        protected JenisBarang $model
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): JenisBarang
    {
        return $this->model->create($data);
    }

    public function update(JenisBarang $jenisBarang, array $data): JenisBarang
    {
        $jenisBarang->update($data);
        return $jenisBarang->refresh();
    }

    public function delete(JenisBarang $jenisBarang): bool
    {
        return $jenisBarang->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
