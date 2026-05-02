<?php

namespace App\Services;

use App\Models\NamaRuang;
use App\Repositories\RuanganRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class RuanganService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly RuanganRepository $repository
    )
    {
        //
    }

    public function paginate(int $perpage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($perpage);
    }

    public function create(array $data) : NamaRuang
    {
        return $this->repository->create($data);
    }

    public function update(NamaRuang $namaRuang, array $data) : NamaRuang
    {
        return $this->repository->update($namaRuang, $data);
    }

    public function delete(NamaRuang $namaRuang): bool
    {
        return $this->repository->delete($namaRuang);
    }

    public function deleteBulk(array $ids): int
    {
        return $this->repository->deleteBulk($ids);
    }
}
