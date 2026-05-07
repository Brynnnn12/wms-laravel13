<?php

namespace App\Services;

use App\Models\Barang;
use App\Repositories\PenyusutanRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PenyusutanService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        private readonly PenyusutanRepository $repository
    ) {
    }

    /**
     * Ambil laporan penyusutan dengan pagination.
     */
    public function getLaporan(int $bulan, int $tahun, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getLaporan($bulan, $tahun, $perPage);
    }

    /**
     * Ambil ringkasan total aset dan nilai buku per periode.
     *
     * @return array{total_barang:int, total_nilai_buku:float}
     */
    public function getSummary(int $bulan, int $tahun): array
    {
        return $this->repository->getSummary($bulan, $tahun);
    }

    /**
     * Proses generate penyusutan untuk periode tertentu.
     */
    public function processDepreciation(int $bulan, int $tahun): void
    {
        DB::transaction(function () use ($bulan, $tahun) {
            $periodeAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            // Pastikan menggunakan Model::query() dan jangan gunakan get(['column'])
            // agar tetap menjadi instance Eloquent Model
            $barangs = Barang::whereNotNull('tanggal_perolehan')
                ->whereDate('tanggal_perolehan', '<=', $periodeAkhir)
                ->get(['id', 'harga_total', 'nilai_residual', 'masa_penyusutan', 'tanggal_perolehan']);

            foreach ($barangs as $barang) {
                // Jika masih error stdClass, kita bisa paksa casting atau pastikan loop
                // menerima instance yang benar
                $hasil = $this->hitungPenyusutanPerBarang($barang, $bulan, $tahun);

                if ($hasil === null) {
                    continue;
                }

                $this->repository->updateOrCreatePenyusutan(
                    [
                        'barang_id' => $barang->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    $hasil
                );
            }
        });
    }

    /**
     * Hitung penyusutan per barang untuk periode tertentu.
     *
     * @return array<string, float|string>|null
     */
    private function hitungPenyusutanPerBarang(Barang $barang, int $bulan, int $tahun): ?array
    {
        if (!$barang->tanggal_perolehan)
            return null;

        $masaPenyusutan = (int) $barang->masa_penyusutan;
        $hargaTotal = (float) $barang->harga_total;
        $nilaiResidual = (float) $barang->nilai_residual;

        if ($masaPenyusutan <= 0 || $hargaTotal <= 0)
            return null;

        // 1. Tentukan titik akhir laporan (misal 31 Mar 2026)
        $periodeLaporan = Carbon::create($tahun, $bulan, 1)->endOfMonth();
        $tglPerolehan = Carbon::parse($barang->tanggal_perolehan);

        // 2. HITUNG FREKUENSI (Logika Anniversary Date)
        // diffInMonths dengan parameter boolean 'false' akan menghitung selisih bulan penuh
        $frekuensi = (int) $tglPerolehan->diffInMonths($periodeLaporan, false);

        // 3. Dasar Penyusutan
        $nilaiDisusutkan = max($hargaTotal - $nilaiResidual, 0);
        $penyusutanBulanan = $nilaiDisusutkan / $masaPenyusutan;

        // Batasi frekuensi agar tidak melebihi masa penyusutan
        $frekuensi = min($frekuensi, $masaPenyusutan);

        if ($frekuensi <= 0) {
            $nilaiAwal = $hargaTotal;
            $nilaiPenyusutan = 0;
            $akumulasi = 0;
            $nilaiBuku = $hargaTotal;
        } else {
            $akumulasi = $penyusutanBulanan * $frekuensi;
            $akumulasiBulanLalu = $penyusutanBulanan * ($frekuensi - 1);

            $nilaiAwal = $hargaTotal - $akumulasiBulanLalu;
            $nilaiPenyusutan = $penyusutanBulanan;
            $nilaiBuku = $hargaTotal - $akumulasi;

            // Proteksi Masa Akhir
            if ($frekuensi >= $masaPenyusutan) {
                $nilaiPenyusutan = $nilaiAwal - $nilaiResidual;
                $akumulasi = $hargaTotal - $nilaiResidual;
                $nilaiBuku = $nilaiResidual;
            }
        }

        return [
            'nilai_awal' => round($nilaiAwal, 2),
            'nilai_penyusutan' => round($nilaiPenyusutan, 2),
            'akumulasi_penyusutan' => round($akumulasi, 2),
            'nilai_buku' => round(max($nilaiBuku, 0), 2),
            'generated_at' => now(),
        ];
    }
}
