<?php

namespace App\Repositories;

use App\Models\StatusBarang;

class StatusRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly StatusBarang $model
    )
    {

    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }


    public function create(array $data): StatusBarang
    {
        return $this->model->create($data);
    }

    public function update(StatusBarang $statusBarang, array $data): StatusBarang
    {
        $statusBarang->update($data);
        return $statusBarang;
    }

    public function delete(StatusBarang $statusBarang): bool
    {
        return $statusBarang->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
