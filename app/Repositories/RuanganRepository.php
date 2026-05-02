<?php

namespace App\Repositories;

use App\Models\NamaRuang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class RuanganRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly NamaRuang $model
    )
    {
        //
    }

    public function paginate(int $perpage = 10): LengthAwarePaginator
    {
        return $this->model->with('lokasiPenyimpanan')->paginate($perpage);
    }

    public function create(array $data): NamaRuang
    {
        return $this->model->create($data);
    }

    public function update(NamaRuang $namaRuang, array $data): NamaRuang
    {
        $namaRuang->update($data);

        return $namaRuang->refresh();
    }

    public function delete(NamaRuang $namaRuang): bool
    {
        return (bool) $namaRuang->delete();
    }

    public function deleteBulk(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
