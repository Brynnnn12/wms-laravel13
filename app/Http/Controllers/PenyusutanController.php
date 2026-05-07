<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyusutan\PenyusutanRequest;
use App\Models\Penyusutan;
use App\Services\PenyusutanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;

class PenyusutanController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly PenyusutanService $service
    ) {
    }

    /**
     * Tampilkan laporan penyusutan.
     */
    #[Authorize('viewAny', Penyusutan::class)]
    public function index(Request $request): View
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);
        $perPage = (int) $request->get('per_page', 10);

        $bulan = max(1, min(12, $bulan));
        $tahun = max(2000, $tahun);

        $penyusutans = $this->service->getLaporan($bulan, $tahun, $perPage);
        $summary = $this->service->getSummary($bulan, $tahun);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('dashboard.penyusutans.index', [
            'penyusutans' => $penyusutans,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'months' => $months,
            'totalBarang' => $summary['total_barang'],
            'totalNilaiBuku' => $summary['total_nilai_buku'],
        ]);
    }

    /**
     * Generate penyusutan untuk periode tertentu.
     */
    #[Authorize('generate', Penyusutan::class)]
    public function generate(PenyusutanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->service->processDepreciation($data['bulan'], $data['tahun']);

        return redirect()
            ->route('penyusutans.index', [
                'bulan' => $data['bulan'],
                'tahun' => $data['tahun'],
            ])
            ->with('success', 'Penyusutan berhasil digenerate.');
    }
}
