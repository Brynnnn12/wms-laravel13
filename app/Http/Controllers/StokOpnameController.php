<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opname\StoreStokOpnameRequest;
use App\Models\NamaRuang;
use App\Models\StokOpname;
use App\Services\StokOpnameService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;

class StokOpnameController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private StokOpnameService $service,
    ) {}

    #[Authorize('viewAny', StokOpname::class)]
    public function index(): View
    {
        $stokOpnames = $this->service->getList(15);
        $ruangs = NamaRuang::whereHas('barangs')->select('id', 'nama_ruang')->get();

        return view('dashboard.stok-opnames.index', [
            'stokOpnames' => $stokOpnames,
            'ruangs' => $ruangs,
        ]);
    }

    #[Authorize('create', StokOpname::class)]
    public function create(): View
    {
        $ruangs = NamaRuang::whereHas('barangs')->select('id', 'nama_ruang')->get();

        return view('dashboard.stok-opnames.create', [
            'ruangs' => $ruangs,
        ]);
    }

    #[Authorize('create', StokOpname::class)]
    public function store(StoreStokOpnameRequest $request): RedirectResponse
    {
        try {
            $stokOpname = $this->service->store($request->validated());

            toast('Stok opname berhasil disimpan!', 'success');
            return redirect()
                ->route('stok-opnames.show', $stokOpname);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    #[Authorize('view', 'stok-opname')]
    public function show(StokOpname $stokOpname): View
    {

        $stokOpname->load(['user', 'namaRuang', 'penyesuaian.barang']);

        return view('dashboard.stok-opnames.show', [
            'stokOpname' => $stokOpname,
        ]);
    }

public function getBarangByRuang(Request $request): JsonResponse
{
    // Pastikan authorize tidak memblokir petugas
    $this->authorize('create', StokOpname::class);

    $ruangId = $request->query('ruang_id');

    if (!$ruangId) {
        return response()->json([
            'success' => false,
            'error' => 'Ruang ID diperlukan'
        ], 422);
    }

    $barangs = $this->service->getBarangByRuang($ruangId);

    return response()->json([
        'success' => true, // INI YANG WAJIB ADA agar dibaca Alpine.js
        'data' => $barangs,
    ]);
}
}
