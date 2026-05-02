<?php

namespace App\Services;

use App\Models\KondisiBarang;
use App\Repositories\KondisiRepository;
use Illuminate\Validation\ValidationException;


class KondisiService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly KondisiRepository $repository
    )
    {
        //
    }

    public function paginate(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(KondisiBarang $kondisiBarang, array $data)
    {

        return $this->repository->update($kondisiBarang, $data);
    }

    public function delete(KondisiBarang $kondisiBarang)
    {
        return $this->repository->delete($kondisiBarang);
    }

    public function bulkDelete(array $ids)
    {
        return $this->repository->bulkDelete($ids);
    }
}
