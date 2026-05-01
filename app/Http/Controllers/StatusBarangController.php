<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusBarang\StoreStatusBarangRequest;
use App\Http\Requests\StatusBarang\UpdateStatusBarangRequest;
use App\Models\StatusBarang;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\View\View;

class StatusBarangController extends Controller
{
    public function __construct(
        private readonly StatusService $statusService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    #[Authorize('viewAny', StatusBarang::class)]
    public function index(): View
    {
        $statusBarangs = $this->statusService->paginate(10);

        $title = 'Hapus Status Barang!';
        $text = 'Apakah Anda yakin ingin menghapus status barang ini?';

        confirmDelete($title, $text);

        return view('dashboard.status-barang.index', compact('statusBarangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create', StatusBarang::class)]
    public function create(): View
    {
        return view('dashboard.status-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create', StatusBarang::class)]
    public function store(StoreStatusBarangRequest $request): RedirectResponse
    {
        $this->statusService->create($request->validated());

        toast('Status barang berhasil ditambahkan!', 'success');

        return redirect()->route('status-barang.index');
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('view', 'status_barang')]
    public function show(StatusBarang $status_barang): View
    {
        return view('dashboard.status-barang.show', compact('status_barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update', 'status_barang')]
    public function edit(StatusBarang $status_barang): View
    {
        return view('dashboard.status-barang.edit', compact('status_barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'status_barang')]
    public function update(
        UpdateStatusBarangRequest $request,
        StatusBarang $status_barang
    ): RedirectResponse {
        $this->statusService->update($status_barang, $request->validated());

        toast('Status barang berhasil diperbarui!', 'success');

        return redirect()->route('status-barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'status_barang')]
    public function destroy(StatusBarang $status_barang): RedirectResponse
    {
        $this->statusService->delete($status_barang);

        toast('Status barang berhasil dihapus!', 'success');

        return redirect()->route('status-barang.index');
    }

    /**
     * Bulk delete selected data.
     */
    #[Authorize('deleteAny', StatusBarang::class)]
    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:status_barangs,id'],
        ]);

        $deleted = $this->statusService->bulkDelete($validated['ids']);

        toast("{$deleted} status barang berhasil dihapus!", 'success');

        return redirect()->route('status-barang.index');
    }
}
