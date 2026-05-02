<?php

namespace App\Repositories;

use App\Models\KondisiBarang;

class KondisiRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected KondisiBarang $model
    )
    {

    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->query()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): KondisiBarang
    {
        return $this->model->create($data);
    }

    public function update(KondisiBarang $kondisiBarang, array $data): KondisiBarang
    {
        $kondisiBarang->update($data);
        return $kondisiBarang->refresh();
    }

    public function delete(KondisiBarang $kondisiBarang): bool
    {
        return $kondisiBarang->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return $this->model->query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
