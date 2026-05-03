<?php

namespace App\Http\Controllers;

use App\Http\Requests\Barang\StoreBarangRequest;
use App\Http\Requests\Barang\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\StatusBarang;
use App\Models\KondisiBarang;
use App\Models\NamaRuang;
use App\Models\LokasiPenyimpanan;
use App\Services\BarangService;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct(
        protected BarangService $service
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'jenis_barang_id',
            'status_barang_id',
            'lokasi_penyimpanan_id',
            'nama_ruang_id',
        ]);

        $barangs = $this->service->paginate(
            $request->get('per_page', 10),
            $request->get('search'),
            $filters
        )->withQueryString();

        confirmDelete(
            'Hapus Barang!',
            'Apakah Anda yakin ingin menghapus barang ini?'
        );

        $data = $this->getMasterData();
        $data['barangs'] = $barangs;

        return view('dashboard.barang.index', $data);
    }

    public function create()
    {
        $data = $this->getMasterData();
        return view('dashboard.barang.create', $data);
    }

    public function store(StoreBarangRequest $request)
    {
        // Logic hitung harga_total dipindah ke Service agar Controller tetap ramping
        $this->service->create($request->validated());

        toast('Barang berhasil ditambahkan!', 'success');

        return redirect()->route('barang.index');
    }

    public function show(Barang $barang)
    {
        // Load relasi agar di view tidak terjadi N+1 Query
        $barang->load(['jenisBarang', 'statusBarang', 'kondisiBarang', 'namaRuang.lokasiPenyimpanan']);
        return view('dashboard.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $data = $this->getMasterData();
        $data['barang'] = $barang;

        return view('dashboard.barang.edit', $data);
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $this->service->update($barang, $request->validated());

        toast('Barang berhasil diupdate!', 'success');

        return redirect()->route('barang.index');
    }

    public function destroy(Barang $barang)
    {
        $this->service->delete($barang);

        toast('Barang berhasil dihapus!', 'success');

        return redirect()->route('barang.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->get('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih data yang akan dihapus.');
        }

        $this->service->bulkDelete($ids);
        toast('Data terpilih berhasil dihapus!', 'success');
        return redirect()->route('barang.index');
    }

    public function cetakLabel(Barang $barang)
    {
        $barang->load(['namaRuang.lokasiPenyimpanan']);
        return view('dashboard.barang.cetak-label', compact('barang'));
    }

    /**
     * Method bantuan untuk mengambil data master agar tidak duplikasi kode
     */
    private function getMasterData(): array
    {
        return [
            // Ambil ID dan Nama saja agar ringan
            'jenisBarangs' => JenisBarang::select('id', 'jenis_barang')->get(),
            'statusBarangs' => StatusBarang::select('id', 'nama_status')->get(),
            'kondisiBarangs' => KondisiBarang::select('id', 'nama_kondisi')->get(),
            'lokasiPenyimpanans' => LokasiPenyimpanan::select('id', 'nama_lokasi')->get(),

            // Gunakan Eager Loading (with) agar tidak terjadi query N+1
            'namaRuangs' => NamaRuang::with('lokasiPenyimpanan')
                ->select('id', 'nama_ruang', 'lokasi_penyimpanan_id')
                ->get(),
        ];
    }
}
