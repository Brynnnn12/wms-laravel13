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
        return $this->repository->delete($statusBarang);
    }

    public function bulkDelete(array $ids)
    {
        return $this->repository->bulkDelete($ids);
    }


}
