<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KondisiBarang;
use App\Models\StatusBarang;
use App\Models\Penyesuaian;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik utama
        $totalBarang = Barang::count();
        $barangMasuk = Barang::where('created_at', '>=', now()->startOfMonth())->count();
        $barangKeluar = Penyesuaian::where('created_at', '>=', now()->startOfMonth())
            ->where('selisih', '<', 0)
            ->sum('selisih') * -1; // Convert to positive
        $stokMenipis = Barang::where('jml_barang', '<=', 10)->count();

        // Barang terupdate (5 terakhir yang diupdate)
        $barangTerupdate = Barang::with(['jenisBarang', 'kondisiBarang', 'statusBarang', 'namaRuang'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Jumlah barang berdasarkan kondisi
        $barangByKondisi = KondisiBarang::withCount('barangs')->get();

        // Jumlah barang berdasarkan status
        $barangByStatus = StatusBarang::withCount('barangs')->get();

        // Data untuk grafik transaksi (6 bulan terakhir)
        $transactionData = $this->getTransactionData();

        // Data untuk grafik kategori
        $categoryData = $this->getCategoryData();

        return view('dashboard', compact(
            'totalBarang',
            'barangMasuk',
            'barangKeluar',
            'stokMenipis',
            'barangTerupdate',
            'barangByKondisi',
            'barangByStatus',
            'transactionData',
            'categoryData'
        ));
    }

    private function getTransactionData(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');

            // Barang masuk (created dalam bulan tersebut)
            $masuk = Barang::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // Barang keluar (penyesuaian dengan selisih negative)
            $keluar = Penyesuaian::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('selisih', '<', 0)
                ->sum('selisih') * -1; // Convert to positive

            $data[] = [
                'month' => $monthName,
                'masuk' => $masuk,
                'keluar' => $keluar
            ];
        }

        return $data;
    }

private function getCategoryData(): array
{
    // Perbaikan:
    // 1. Ganti 'barang' menjadi 'barangs' (nama tabel plural)
    // 2. Ganti 'nama_jenis' menjadi 'jenis_barang' (sesuai migration Anda)
    $categories = Barang::selectRaw('jenis_barangs.jenis_barang as nama_jenis, COUNT(*) as count')
        ->join('jenis_barangs', 'barangs.jenis_barang_id', '=', 'jenis_barangs.id')
        ->groupBy('jenis_barangs.id', 'jenis_barangs.jenis_barang')
        ->orderBy('count', 'desc')
        ->limit(4)
        ->get();

    return $categories->toArray();
}
}
