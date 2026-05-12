<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-2">
                                Inventory Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Manajemen Barang
                            </h1>

                            <p class="text-emerald-100 text-sm mt-2">
                                Kelola data barang pada sistem inventory.
                            </p>
                        </div>

                        <a href="{{ route('barang.create') }}"
                           class="inline-flex items-center px-5 py-3 rounded-2xl bg-white text-emerald-700 font-semibold text-sm shadow-lg hover:scale-[1.02] transition">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Barang
                        </a>
                    </div>
                </div>
            </div>

            {{-- FILTER & SEARCH --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <form action="{{ route('barang.index') }}" method="GET" class="grid gap-4 xl:grid-cols-[1fr_auto] xl:items-end">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari kode atau nama barang..."
                                       class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm pl-11 py-3">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>

                            <select name="jenis_barang_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Semua Jenis</option>
                                @foreach($jenisBarangs as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->jenis_barang }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="status_barang_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Semua Status</option>
                                @foreach($statusBarangs as $status)
                                    <option value="{{ $status->id }}" {{ request('status_barang_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="lokasi_penyimpanan_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Semua Lokasi</option>
                                @foreach($lokasiPenyimpanans as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ request('lokasi_penyimpanan_id') == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="nama_ruang_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Semua Ruang</option>
                                @foreach($namaRuangs as $ruang)
                                    <option value="{{ $ruang->id }}" {{ request('nama_ruang_id') == $ruang->id ? 'selected' : '' }}>
                                        {{ $ruang->nama_ruang }} ({{ $ruang->lokasiPenyimpanan->nama_lokasi ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3">
                            <a href="{{ route('barang.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-4 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                                Reset
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 text-white px-4 py-3 text-sm font-semibold hover:bg-emerald-700 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <form id="bulk-delete-form"
                  data-bulk-delete
                  action="{{ route('barang.bulk-delete') }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                    {{-- TOPBAR --}}
                    <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h2 class="font-bold text-slate-800 text-lg">
                                Data Barang
                            </h2>

                            <p class="text-sm text-slate-500">
                                Daftar seluruh barang yang tersedia.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">

                            <a href="{{ route('barang.export', request()->query()) }}"
                               class="inline-flex items-center px-4 py-2 rounded-2xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-download mr-2"></i>
                                Export Excel
                            </a>

                            <button type="button"
                                    id="bulk-delete-btn"
                                    data-delete-button
                                    data-confirm-message="Apakah Anda yakin ingin menghapus barang yang dipilih?"
                                    class="hidden px-4 py-2 rounded-2xl bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Terpilih
                            </button>

                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-center">
                                        <input type="checkbox"
                                               id="select-all"
                                               data-select-all
                                               class="rounded border-slate-300 text-emerald-600">
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        No
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Kode Barang
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Nama Barang
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Jenis
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Jumlah
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Harga Satuan
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse($barangs as $index => $item)
                                    <tr class="hover:bg-slate-50">

                                        @if(!\App\Models\Penyesuaian::where('barang_id', $item->id)->exists() && !\App\Models\Penyusutan::where('barang_id', $item->id)->exists())
                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox"
                                                   name="ids[]"
                                                   value="{{ $item->id }}"
                                                   data-checkbox
                                                   class="item-checkbox rounded border-slate-300 text-emerald-600">
                                        </td>
                                        @else
                                        <td class="px-6 py-4 text-center">
                                            -
                                        </td>
                                        @endif

                                        <td class="px-6 py-4 text-sm">
                                            {{ $barangs->firstItem() + $index }}
                                        </td>

                                        <td class="px-6 py-4 font-semibold">
                                            {{ $item->kode_barang }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $item->nama_barang }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $item->jenisBarang->jenis_barang ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $item->jml_barang }}
                                        </td>

                                        <td class="px-6 py-4">
                                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $item->statusBarang->nama_status ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('barang.show', $item) }}"
                                                   class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-blue-500 hover:text-white transition">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>

                                                <a href="{{ route('barang.cetak-label', $item) }}"
                                                   target="_blank"
                                                   class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-purple-500 hover:text-white transition">
                                                    <i class="fas fa-print text-sm"></i>
                                                </a>

                                                <a href="{{ route('barang.edit', $item) }}"
                                                   class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-amber-500 hover:text-white transition">
                                                    <i class="fas fa-pen text-sm"></i>
                                                </a>

                                                @if(!\App\Models\Penyesuaian::where('barang_id', $item->id)->exists() && !\App\Models\Penyusutan::where('barang_id', $item->id)->exists())
                                                <button type="button"
                                                        data-confirm-delete
                                                        data-confirm-route="{{ route('barang.destroy', $item) }}"
                                                        class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-rose-600 hover:text-white transition">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-10 text-slate-500">
                                            Belum ada data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="px-6 py-5 border-t border-slate-100">
                        {{ $barangs->links() }}
                    </div>

                </div>
            </form>

        </div>
    </div>


</x-app-layout>
