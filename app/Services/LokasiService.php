<?php

namespace App\Services;

use App\Models\LokasiPenyimpanan;
use App\Repositories\LokasiRepository;
use Illuminate\Support\Facades\DB;

class LokasiService
{
    public function __construct(
        private readonly LokasiRepository $repository
    ) {
    }

    public function paginate(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function create(array $data): LokasiPenyimpanan
    {
        return $this->repository->create($data);
    }

    public function update(
        LokasiPenyimpanan $lokasiPenyimpanan,
        array $data
    ): LokasiPenyimpanan {
        return $this->repository->update($lokasiPenyimpanan, $data);
    }

    public function delete(
        LokasiPenyimpanan $lokasiPenyimpanan
    ): bool|null {
        return $this->repository->delete($lokasiPenyimpanan);
    }

    public function bulkDelete(array $ids): int
    {
        return $this->repository->bulkDelete($ids);
    }


}
