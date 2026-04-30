<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisBarang\StoreJenisBarangRequest;
use App\Http\Requests\JenisBarang\UpdateJenisBarangRequest;
use App\Models\JenisBarang;
use App\Services\JenisBarangService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Routing\Attributes\Controllers\Authorize;

class JenisBarangController extends Controller
{
    public function __construct(
        private readonly JenisBarangService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    #[Authorize('viewAny', JenisBarang::class)]
    public function index(): View
    {
        $jenisBarangs = $this->service->paginate(10);

        $title = 'Hapus Jenis Barang!';
        $text = "Apakah Anda yakin ingin menghapus jenis barang ini?";
        confirmDelete($title, $text);


        return view('dashboard.jenis-barang.index', compact('jenisBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create', JenisBarang::class)]
    public function create(): View
    {
        return view('dashboard.jenis-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create', JenisBarang::class)]
    public function store(StoreJenisBarangRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        toast('Jenis barang berhasil ditambahkan!', 'success');

        return redirect()
            ->route('jenis-barang.index');
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('view')]
    public function show(JenisBarang $jenis_barang): View
    {
        return view('dashboard.jenis-barang.show', compact('jenis_barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update')]
    public function edit(JenisBarang $jenis_barang): View
    {
        return view('dashboard.jenis-barang.edit', compact('jenis_barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update')]
    public function update(
        UpdateJenisBarangRequest $request,
        JenisBarang $jenis_barang
    ): RedirectResponse {
        $this->service->update($jenis_barang, $request->validated());

        toast('Jenis barang berhasil diperbarui!', 'success');

        return redirect()
            ->route('jenis-barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete')]
    public function destroy(JenisBarang $jenis_barang): RedirectResponse
    {
        $this->service->delete($jenis_barang);
        toast('Jenis barang berhasil dihapus!', 'success');

        return redirect()
            ->route('jenis-barang.index');
    }

    /**
     * Bulk delete selected data.
     */
    #[Authorize('delete', JenisBarang::class)]
    public function bulkDelete(): RedirectResponse
    {
        request()->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:jenis_barangs,id'],
        ]);

        $deleted = $this->service->bulkDelete(request('ids'));

        toast("{$deleted} jenis barang berhasil dihapus!", 'success');

        return redirect()
            ->route('jenis-barang.index');
    }
}
