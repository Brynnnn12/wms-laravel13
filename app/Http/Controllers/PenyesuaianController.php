<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opname\StorePenyesuaianRequest;
use App\Models\Penyesuaian;
use App\Services\PenyesuaianService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;

class PenyesuaianController extends Controller
{
    use AuthorizesRequests;

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
    public function create(): View
    {
        // Ambil stok opname yang belum memiliki penyesuaian lengkap
        $stokOpnames = $this->service->getStokOpnamesForPenyesuaian();

        return view('dashboard.penyesuaians.create', [
            'stokOpnames' => $stokOpnames,
        ]);
    }

    #[Authorize('create', Penyesuaian::class)]
    public function store(StorePenyesuaianRequest $request): RedirectResponse
    {
        try {
            $penyesuaians = $this->service->store($request->validated());

            toast(count($penyesuaians) . ' penyesuaian berhasil disimpan!', 'success');
            return redirect()
                ->route('penyesuaians.index');
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
                ->route('penyesuaians.show', $penyesuaian);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
