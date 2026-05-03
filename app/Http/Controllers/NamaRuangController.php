<?php

namespace App\Http\Controllers;

use App\Models\NamaRuang;
use App\Http\Requests\StoreNamaRuangRequest;
use App\Http\Requests\UpdateNamaRuangRequest;
use App\Models\LokasiPenyimpanan;
use App\Services\RuanganService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;


class NamaRuangController extends Controller
{

    public function __construct(
        private readonly RuanganService $service
    ) {

    }
    /**
     * Display a listing of the resource.
     */
    #[Authorize('viewAny', NamaRuang::class)]
    public function index(): View
    {
        $ruangan = $this->service->paginate();

            confirmDelete(
                'Hapus Ruangan!',
                'Apakah Anda yakin ingin menghapus ruangan ini?'
            );
        return view('dashboard.nama-ruangan.index', compact('ruangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create', NamaRuang::class)]
    public function create(): View
    {
        return view('dashboard.nama-ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create', NamaRuang::class)]
    public function store(StoreNamaRuangRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        toast('Ruangan berhasil ditambahkan!', 'success');

        return redirect()->route('nama-ruang.index');
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('view', 'nama_ruang')]
    public function show(NamaRuang $nama_ruang): View
    {
        return view('dashboard.nama-ruangan.show', compact('nama_ruang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update', 'nama_ruang')]
    public function edit(NamaRuang $nama_ruang): View
    {
        return view('dashboard.nama-ruangan.edit', compact('nama_ruang'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'nama_ruang')]
    public function update(UpdateNamaRuangRequest $request, NamaRuang $nama_ruang)
    {
        $this->service->update($nama_ruang, $request->validated());

        toast('Ruangan berhasil diperbarui!', 'success');

        return redirect()->route('nama-ruang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'nama_ruang')]
    public function destroy(NamaRuang $nama_ruang)
    {
        $this->service->delete($nama_ruang);

        toast('Ruangan berhasil dihapus!', 'success');

        return redirect()->route('nama-ruang.index');
    }

    #[Authorize('delete', 'nama_ruang')]
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        $deletedCount = $this->service->deleteBulk($ids);

        toast("$deletedCount ruangan berhasil dihapus!", 'success');

        return redirect()->route('nama-ruang.index');
    }

    public function getByLokasi(LokasiPenyimpanan $lokasi): \Illuminate\Http\JsonResponse
    {
        $ruangan = NamaRuang::where('lokasi_penyimpanan_id', $lokasi->id)->get(['id', 'nama_ruang']);
        return response()->json($ruangan);
    }
}
