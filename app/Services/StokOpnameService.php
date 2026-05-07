<?php

namespace App\Services;

use App\Models\StokOpname;
use App\Repositories\StokOpnameRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameService
{
    public function __construct(
        private StokOpnameRepository $repository,
    ) {
    }

    public function store(array $data): StokOpname
    {
        return DB::transaction(function () use ($data) {
            $stokOpname = $this->repository->create([
                'user_id' => Auth::id(),
                'tanggal_so' => $data['tanggal_so'],
                'nama_ruang_id' => $data['nama_ruang_id'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            return $stokOpname->load(['user', 'namaRuang']);
        });
    }

    public function getDetail(string $id): ?StokOpname
    {
        return $this->repository->findById($id);
    }

    public function getList(int $perPage = 15)
    {
        $filters = request()->only(['ruang_id', 'tanggal_dari', 'tanggal_sampai', 'search']);
        return $this->repository->getAll($perPage, $filters);
    }

    public function getBarangByRuang(string $ruangId)
    {
        return $this->repository->getBarangByRuang($ruangId);
    }
}
