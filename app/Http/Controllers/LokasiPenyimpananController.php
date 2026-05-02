<?php

namespace App\Http\Controllers;

use App\Http\Requests\LokasiPenyimpanan\StoreLokasiPenyimpananRequest;
use App\Http\Requests\LokasiPenyimpanan\UpdateLokasiPenyimpananRequest;
use App\Models\LokasiPenyimpanan;
use App\Services\LokasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;

class LokasiPenyimpananController extends Controller
{
    public function __construct(
        private readonly LokasiService $service
    ) {
    }

    #[Authorize('viewAny', LokasiPenyimpanan::class)]
    public function index(): View
    {
        $lokasiPenyimpanans = $this->service->paginate(10);

        confirmDelete(
            'Hapus Lokasi Penyimpanan!',
            'Apakah Anda yakin ingin menghapus lokasi penyimpanan ini?'
        );

        return view(
            'dashboard.lokasi-penyimpanan.index',
            compact('lokasiPenyimpanans')
        );
    }

    #[Authorize('create', LokasiPenyimpanan::class)]
    public function create(): View
    {
        return view('dashboard.lokasi-penyimpanan.create');
    }

    #[Authorize('create', LokasiPenyimpanan::class)]
    public function store(
        StoreLokasiPenyimpananRequest $request
    ): RedirectResponse {
        $this->service->create($request->validated());

        toast('Lokasi penyimpanan berhasil ditambahkan!', 'success');

        return redirect()->route('lokasi-penyimpanan.index');
    }

    #[Authorize('view', 'lokasiPenyimpanan')]
    public function show(
        LokasiPenyimpanan $lokasiPenyimpanan
    ): View {
        return view(
            'dashboard.lokasi-penyimpanan.show',
            compact('lokasiPenyimpanan')
        );
    }

    #[Authorize('update', 'lokasiPenyimpanan')]
    public function edit(
        LokasiPenyimpanan $lokasiPenyimpanan
    ): View {
        return view(
            'dashboard.lokasi-penyimpanan.edit',
            compact('lokasiPenyimpanan')
        );
    }

    #[Authorize('update', 'lokasiPenyimpanan')]
    public function update(
        UpdateLokasiPenyimpananRequest $request,
        LokasiPenyimpanan $lokasiPenyimpanan
    ): RedirectResponse {
        $this->service->update(
            $lokasiPenyimpanan,
            $request->validated()
        );

        toast('Lokasi penyimpanan berhasil diperbarui!', 'success');

        return redirect()->route('lokasi-penyimpanan.index');
    }

    #[Authorize('delete', 'lokasiPenyimpanan')]
    public function destroy(
        LokasiPenyimpanan $lokasiPenyimpanan
    ): RedirectResponse {
        $this->service->delete($lokasiPenyimpanan);

        toast('Lokasi penyimpanan berhasil dihapus!', 'success');

        return redirect()->route('lokasi-penyimpanan.index');
    }

    #[Authorize('delete', LokasiPenyimpanan::class)]
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toast(
                'Tidak ada lokasi penyimpanan yang dipilih.',
                'warning'
            );

            return redirect()->route('lokasi-penyimpanan.index');
        }

        $this->service->bulkDelete($ids);

        toast('Lokasi penyimpanan berhasil dihapus!', 'success');

        return redirect()->route('lokasi-penyimpanan.index');
    }
}
