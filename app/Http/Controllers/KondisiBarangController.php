<?php

namespace App\Http\Controllers;

use App\Models\KondisiBarang;
use App\Http\Requests\KondisiBarang\StoreKondisiBarangRequest;
use App\Http\Requests\KondisiBarang\UpdateKondisiBarangRequest;
use App\Services\KondisiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Attributes\Controllers\Authorize;


class KondisiBarangController extends Controller
{

    public function __construct(
        private readonly KondisiService $service
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    #[Authorize('viewAny', KondisiBarang::class)]
    public function index() : View
    {
        $kondisiBarangs = $this->service->paginate(10);

        $title = 'Hapus Kondisi Barang!';
        $text = 'Apakah Anda yakin ingin menghapus kondisi barang ini?';

        confirmDelete($title, $text);

        return view('dashboard.kondisi-barang.index', compact('kondisiBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create', KondisiBarang::class)]
    public function create()
    {
        return view('dashboard.kondisi-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create', KondisiBarang::class)]
    public function store(StoreKondisiBarangRequest $request)
    {
        $this->service->create($request->validated());

        toast('Kondisi barang berhasil ditambahkan!', 'success');

        return redirect()->route('kondisi-barang.index');
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('view', 'kondisi_barang')]
    public function show(KondisiBarang $kondisiBarang)
    {
        return view('dashboard.kondisi-barang.show', compact('kondisiBarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update', 'kondisi_barang')]
    public function edit(KondisiBarang $kondisi_barang)
    {
        return view('dashboard.kondisi-barang.edit', compact('kondisi_barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'kondisi_barang')]
    public function update(UpdateKondisiBarangRequest $request, KondisiBarang $kondisi_barang)
    {
        $this->service->update($kondisi_barang, $request->validated());

        toast('Kondisi barang berhasil diperbarui!', 'success');

        return redirect()->route('kondisi-barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'kondisi_barang')]
    public function destroy(KondisiBarang $kondisi_barang)
    {
        $this->service->delete($kondisi_barang);

        toast('Kondisi barang berhasil dihapus!', 'success');

        return redirect()->route('kondisi-barang.index');
    }

    #[Authorize('delete', KondisiBarang::class)]
    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toast('Tidak ada kondisi barang yang dipilih untuk dihapus.', 'warning');
            return redirect()->route('kondisi-barang.index');
        }

        $this->service->bulkDelete($ids);

        toast('Kondisi barang berhasil dihapus!', 'success');

        return redirect()->route('kondisi-barang.index');
    }
}
