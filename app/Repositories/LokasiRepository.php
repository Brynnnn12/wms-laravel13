<?php

namespace App\Repositories;

use App\Models\LokasiPenyimpanan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LokasiRepository
{
    public function __construct(
        private readonly LokasiPenyimpanan $model
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): LokasiPenyimpanan
    {
        return $this->model->create($data);
    }

    public function update(
        LokasiPenyimpanan $lokasiPenyimpanan,
        array $data
    ): LokasiPenyimpanan {
        $lokasiPenyimpanan->update($data);

        return $lokasiPenyimpanan->fresh();
    }

    public function delete(
        LokasiPenyimpanan $lokasiPenyimpanan
    ): bool|null {
        return $lokasiPenyimpanan->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model
            ->query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
