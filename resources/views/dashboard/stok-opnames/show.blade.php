<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div
                class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-2">Stok Opname Management</p>
                        <h1 class="text-3xl font-bold text-white">Detail Stok Opname</h1>
                        <p class="text-emerald-100 text-sm mt-2">
                            Hasil pengecekan stok barang di ruang
                            <strong>{{ $stokOpname->namaRuang->nama_ruang ?? '-' }}</strong>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-emerald-100 text-sm">Tanggal Opname</p>
                        <p class="text-2xl font-bold text-white">{{ $stokOpname->tanggal_so->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="space-y-6">

                {{-- INFO CARD --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Created By --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <p class="text-slate-600 text-sm font-medium">Dibuat Oleh</p>
                        <p class="text-xl font-bold text-slate-900 mt-1">{{ $stokOpname->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $stokOpname->created_at->format('d M Y H:i') }}</p>
                    </div>

                    {{-- Tanggal Opname --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <p class="text-slate-600 text-sm font-medium">Tanggal Opname</p>
                        <p class="text-xl font-bold text-slate-900 mt-1">{{ $stokOpname->tanggal_so->format('d M Y') }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $stokOpname->tanggal_so->format('l') }}
                        </p>
                    </div>

                    {{-- Total Barang --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <p class="text-slate-600 text-sm font-medium">Total Barang Dicek</p>
                        <p class="text-xl font-bold text-blue-600 mt-1">{{ $stokOpname->penyesuaian->count() }}</p>
                        <p class="text-xs text-slate-500 mt-1">Item dengan selisih</p>
                    </div>

                    {{-- Total Selisih --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <p class="text-slate-600 text-sm font-medium">Total Selisih</p>
                        <p class="text-xl font-bold text-rose-600 mt-1">
                            {{ abs($stokOpname->penyesuaian->sum('selisih')) }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1">Unit barang</p>
                    </div>

                </div>

                {{-- KETERANGAN --}}
                @if ($stokOpname->keterangan)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Keterangan Umum</h3>
                        <p class="text-slate-700 bg-slate-50 p-4 rounded-xl">{{ $stokOpname->keterangan }}</p>
                    </div>
                @endif

                {{-- DETAIL PENYESUAIAN --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6 md:p-8 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Detail Penyesuaian Stok</h2>
                        <p class="text-slate-600 text-sm mt-1">Daftar barang yang terdapat selisih antara stok sistem dan
                            stok fisik</p>
                    </div>

                    <div class="overflow-x-auto">
                        @if ($stokOpname->penyesuaian->count() > 0)
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <th class="px-6 py-3 text-left font-semibold text-slate-700">#</th>
                                        <th class="px-6 py-3 text-left font-semibold text-slate-700">Nama Barang</th>
                                        <th class="px-6 py-3 text-center font-semibold text-slate-700 w-28">Stok
                                            Sistem</th>
                                        <th class="px-6 py-3 text-center font-semibold text-slate-700 w-28">Stok Fisik
                                        </th>
                                        <th class="px-6 py-3 text-center font-semibold text-slate-700 w-20">Selisih</th>
                                        <th class="px-6 py-3 text-left font-semibold text-slate-700">Keterangan</th>
                                        <th class="px-6 py-3 text-left font-semibold text-slate-700">Dicatat Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stokOpname->penyesuaian as $index => $penyesuaian)
                                        <tr
                                            class="border-b border-slate-100 hover:bg-slate-50 transition {{ $penyesuaian->selisih != 0 ? 'bg-rose-50' : '' }}">
                                            <td class="px-6 py-4 text-slate-700 font-medium">{{ $index + 1 }}</td>

                                            <td class="px-6 py-4">
                                                <p class="font-medium text-slate-900">{{ $penyesuaian->barang->nama_barang }}
                                                </p>
                                                <p class="text-xs text-slate-500">{{ $penyesuaian->barang->kode_barang }}
                                                </p>
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">
                                                    {{ $penyesuaian->qty_sistem }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">
                                                    {{ $penyesuaian->qty_fisik }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-center font-bold">
                                                <span
                                                    class="inline-block px-3 py-1 rounded-full {{ $penyesuaian->selisih > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                    {{ $penyesuaian->selisih > 0 ? '+' : '' }}{{ $penyesuaian->selisih }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-slate-700">
                                                {{ $penyesuaian->keterangan ?? '-' }}
                                            </td>

                                            <td class="px-6 py-4 text-slate-700 text-xs">
                                                <p class="font-medium">{{ $penyesuaian->user->name ?? '-' }}</p>
                                                <p class="text-slate-500">{{ $penyesuaian->created_at->format('d M Y') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <div class="p-6 md:p-8 text-center">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 mx-auto text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-600 font-medium">Tidak ada penyesuaian</p>
                                <p class="text-slate-500 text-sm">Semua stok barang sudah sesuai</p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- RINGKASAN STATISTIK --}}
                @if ($stokOpname->penyesuaian->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Barang Berkurang --}}
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-slate-600 text-sm font-medium">Barang Berkurang</p>
                                    <p class="text-3xl font-bold text-rose-600 mt-2">
                                        {{ abs($stokOpname->penyesuaian->where('selisih', '<', 0)->sum('selisih')) }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $stokOpname->penyesuaian->where('selisih', '<', 0)->count() }} item
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 17H5m12 0v-4m0 4l-4-4m4 4l4-4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Barang Bertambah --}}
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-slate-600 text-sm font-medium">Barang Bertambah</p>
                                    <p class="text-3xl font-bold text-emerald-600 mt-2">
                                        {{ $stokOpname->penyesuaian->where('selisih', '>', 0)->sum('selisih') }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $stokOpname->penyesuaian->where('selisih', '>', 0)->count() }} item
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7H5m12 0v4m0-4l-4 4m4-4l4 4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Net Selisih --}}
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-slate-600 text-sm font-medium">Net Selisih</p>
                                    <p class="text-3xl font-bold text-blue-600 mt-2">
                                        {{ $stokOpname->penyesuaian->sum('selisih') }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">Total penyesuaian stok</p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif

            </div>

            {{-- ACTIONS --}}
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('stok-opnames.index') }}"
                    class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                    ← Kembali
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('stok-opnames.create') }}"
                        class="px-6 py-3 rounded-2xl bg-slate-600 text-white font-semibold hover:bg-slate-700 transition shadow">
                        Buat Stok Opname Baru
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
