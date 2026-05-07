<?php

namespace App\Services;

use App\Models\Penyesuaian;
use App\Repositories\PenyesuaianRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenyesuaianService
{
    public function __construct(
        private PenyesuaianRepository $repository,
    ) {}

    public function store(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Validasi apakah stok opname sudah pernah digunakan untuk penyesuaian
            $existingPenyesuaian = $this->repository->findByStokOpname($data['stok_opname_id']);
            if ($existingPenyesuaian->isNotEmpty()) {
                throw new \Exception('Stok opname ini sudah pernah digunakan untuk penyesuaian. Pilih stok opname yang belum pernah diproses.');
            }

            $penyesuaians = [];

            foreach ($data['items'] as $item) {
                $penyesuaian = $this->repository->create([
                    'stok_opname_id' => $data['stok_opname_id'],
                    'barang_id' => $item['barang_id'],
                    'user_id' => Auth::id(),
                    'qty_sistem' => $this->repository->getQtySistem($item['barang_id']),
                    'qty_fisik' => $item['qty_fisik'],
                    'selisih' => $item['qty_fisik'] - $this->repository->getQtySistem($item['barang_id']),
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                $penyesuaians[] = $penyesuaian;
            }

            return $penyesuaians;
        });
    }

    public function update(Penyesuaian $penyesuaian, array $data): Penyesuaian
    {
        return DB::transaction(function () use ($penyesuaian, $data) {
            $penyesuaian->update([
                'qty_fisik' => $data['qty_fisik'],
                'selisih' => $data['qty_fisik'] - $penyesuaian->qty_sistem,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            return $penyesuaian;
        });
    }

    public function getList(int $perPage = 15)
    {
        $filters = request()->only(['stok_opname_id', 'barang_id', 'search']);
        return $this->repository->getAll($perPage, $filters);
    }

    public function getStokOpnamesForPenyesuaian()
    {
        return $this->repository->getStokOpnamesForPenyesuaian();
    }
}
