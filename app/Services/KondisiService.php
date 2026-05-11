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
        //jika kondisi masih di pakai di barang maka nggak bisa di hapus
        if ($kondisiBarang->barangs()->count() > 0) {
            throw ValidationException::withMessages([
                'kondisi_barang_id' => 'Kondisi barang tidak bisa dihapus karena masih digunakan oleh barang.',
            ]);
        };

        return $this->repository->delete($kondisiBarang);
    }

    public function bulkDelete(array $ids)
    {
        if (KondisiBarang::whereIn('id', $ids)->whereHas('barangs')->exists()) {
            throw ValidationException::withMessages([
                'kondisi_barang_id' => 'Beberapa kondisi barang tidak bisa dihapus karena masih digunakan oleh barang.',
            ]);
        };
        return $this->repository->bulkDelete($ids);
    }
}
