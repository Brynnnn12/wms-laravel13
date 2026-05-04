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
            // ✅ VALIDASI ITEMS (duplikat & ruang)
            $this->validateItems($data['items'], $data['nama_ruang_id'] ?? null);

            $stokOpname = $this->repository->create([
                'user_id' => Auth::id(),
                'tanggal_so' => $data['tanggal_so'],
                'nama_ruang_id' => $data['nama_ruang_id'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                // ✅ AMBIL qty_sistem DARI DATABASE, bukan dari request
                $barang = $this->repository->findBarangById($item['barang_id']);

                $qtySistem = $barang->jml_barang;
                $qtyFisik = $item['qty_fisik'];
                $selisih = $qtyFisik - $qtySistem;

                // ✅ HANYA BUAT PENYESUAIAN JIKA SELISIH ≠ 0
                if ($selisih !== 0) {
                    $this->repository->createPenyesuaian([
                        'stok_opname_id' => $stokOpname->id,
                        'barang_id' => $item['barang_id'],
                        'user_id' => Auth::id(),
                        'qty_sistem' => $qtySistem,
                        'qty_fisik' => $qtyFisik,
                        'selisih' => $selisih,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }

                // ✅ SELALU UPDATE STOK, TERLEPAS ADA SELISIH ATAU TIDAK
                $this->repository->updateBarangStock($item['barang_id'], $qtyFisik);
            }

            return $stokOpname->load(['user', 'namaRuang', 'penyesuaian.barang']);
        });
    }

    private function validateItems(array $items, ?string $ruangId): void
    {
        $checked = [];

        foreach ($items as $index => $item) {
            $barangId = $item['barang_id'];

            // ✅ CEGAH DUPLIKAT
            if (in_array($barangId, $checked)) {
                throw new \Exception(
                    "Barang dengan ID '$barangId' muncul lebih dari sekali (duplikat)."
                );
            }

            $checked[] = $barangId;

            // ✅ AMBIL DATA BARANG DARI DB
            $barang = $this->repository->findBarangById($barangId);

            // ✅ VALIDASI RUANG
            if ($ruangId && $barang->nama_ruang_id !== $ruangId) {
                throw new \Exception(
                    "Barang '{$barang->nama_barang}' tidak berada di ruang yang dipilih."
                );
            }
        }
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
