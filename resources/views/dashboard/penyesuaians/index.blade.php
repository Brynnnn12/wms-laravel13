<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-2">
                                Penyesuaian Stok Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Daftar Penyesuaian Stok
                            </h1>

                            <p class="text-blue-100 text-sm mt-2">
                                Kelola penyesuaian stok barang berdasarkan hasil opname.
                            </p>
                        </div>

                        @can('penyesuaian.create')
                        <a href="{{ route('penyesuaians.create') }}"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-white text-blue-700 font-semibold text-sm shadow-lg hover:scale-[1.02] transition">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Penyesuaian
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            {{-- FILTER & SEARCH --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <form action="{{ route('penyesuaians.index') }}" method="GET"
                        class="grid gap-4 xl:grid-cols-[1fr_auto] xl:items-end">

                        <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-4">

                            {{-- Search --}}
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari barang atau ruang..."
                                    class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm pl-11 py-3">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>

                            {{-- Filter Stok Opname --}}
                            <div class="relative z-10">
                                <select name="stok_opname_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Semua Stok Opname</option>
                                    <!-- Add options -->
                                </select>
                            </div>

                            {{-- Filter Barang --}}
                            <div class="relative">
                                <input type="text" name="barang" value="{{ request('barang') }}"
                                    placeholder="Nama barang"
                                    class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-3">
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3">
                            <a href="{{ route('penyesuaians.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-4 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                                Reset
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 text-white px-4 py-3 text-sm font-semibold hover:bg-blue-700 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                {{-- TOPBAR --}}
                <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">
                            Data Penyesuaian Stok
                        </h2>
                        <p class="text-sm text-slate-500">
                            Menampilkan {{ $penyesuaians->total() }} data penyesuaian stok
                        </p>
                    </div>
                </div>

                {{-- TABLE CONTENT --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Barang
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Stok Opname
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Qty Sistem
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Qty Fisik
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Selisih
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($penyesuaians as $penyesuaian)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-slate-900">
                                                {{ $penyesuaian->barang->nama_barang }}
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                {{ $penyesuaian->barang->kode_barang }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">
                                        {{ $penyesuaian->stokOpname->namaRuang->nama_ruang ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-slate-500">
                                        {{ $penyesuaian->stokOpname->tanggal_so->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ $penyesuaian->qty_sistem }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900">
                                    {{ $penyesuaian->qty_fisik }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $penyesuaian->selisih > 0 ? 'bg-green-100 text-green-800' :
                                           ($penyesuaian->selisih < 0 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $penyesuaian->selisih > 0 ? '+' : '' }}{{ $penyesuaian->selisih }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('penyesuaians.show', $penyesuaian) }}"
                                            class="text-blue-600 hover:text-blue-900 transition">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('penyesuaian.create')
                                        <a href="{{ route('penyesuaians.edit', $penyesuaian) }}"
                                            class="text-indigo-600 hover:text-indigo-900 transition">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                                        <h3 class="text-sm font-medium text-slate-900 mb-1">Tidak ada data penyesuaian</h3>
                                        <p class="text-sm text-slate-500">Belum ada penyesuaian stok yang dibuat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($penyesuaians->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $penyesuaians->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
