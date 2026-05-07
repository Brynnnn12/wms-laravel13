<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opname\StorePenyesuaianRequest;
use App\Models\Penyesuaian;
use App\Services\PenyesuaianService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PenyesuaianController extends Controller
{

    public function __construct(
        private PenyesuaianService $service,
    ) {}

    #[Authorize('viewAny', Penyesuaian::class)]
    public function index(): View
    {
        $penyesuaians = $this->service->getList(15);

        return view('dashboard.penyesuaians.index', [
            'penyesuaians' => $penyesuaians,
        ]);
    }

    #[Authorize('create', Penyesuaian::class)]
    public function create(Request $request): View
    {
        // Ambil stok opname yang belum memiliki penyesuaian lengkap
        $stokOpnames = $this->service->getStokOpnamesForPenyesuaian();

        // Jika ada parameter stok_opname_id dari URL, cari dan set sebagai selected
        $selectedStokOpname = null;
        if ($request->has('stok_opname_id')) {
            $selectedStokOpname = $stokOpnames->find($request->stok_opname_id);
        }

        return view('dashboard.penyesuaians.create', [
            'stokOpnames' => $stokOpnames,
            'selectedStokOpname' => $selectedStokOpname,
        ]);
    }

    #[Authorize('create', Penyesuaian::class)]
    public function store(StorePenyesuaianRequest $request): RedirectResponse
    {
        try {
            $penyesuaians = $this->service->store($request->validated());

            toast(count($penyesuaians) . ' penyesuaian berhasil disimpan!', 'success');
            return redirect()
                ->route('stok-opnames.show', $request->stok_opname_id);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    #[Authorize('view', 'penyesuaian')]
    public function show(Penyesuaian $penyesuaian): View
    {
        $penyesuaian->load(['stokOpname', 'barang', 'user']);

        return view('dashboard.penyesuaians.show', [
            'penyesuaian' => $penyesuaian,
        ]);
    }

    #[Authorize('update', 'penyesuaian')]
    public function edit(Penyesuaian $penyesuaian): View
    {
        return view('dashboard.penyesuaians.edit', [
            'penyesuaian' => $penyesuaian,
        ]);
    }

    #[Authorize('update', 'penyesuaian')]
    public function update(StorePenyesuaianRequest $request, Penyesuaian $penyesuaian): RedirectResponse
    {
        try {
            $this->service->update($penyesuaian, $request->validated());

            toast('Penyesuaian berhasil diperbarui!', 'success');
            return redirect()
                ->route('stok-opnames.show', $penyesuaian->stokOpname);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
