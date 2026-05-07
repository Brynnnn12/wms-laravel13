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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

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

                    {{-- Ruang --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <p class="text-slate-600 text-sm font-medium">Ruang</p>
                        <p class="text-xl font-bold text-blue-600 mt-1">{{ $stokOpname->namaRuang->nama_ruang ?? '-' }}</p>
                        <p class="text-xs text-slate-500 mt-1">Lokasi pengecekan</p>
                    </div>

                </div>

                {{-- KETERANGAN --}}
                @if ($stokOpname->keterangan)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Keterangan Umum</h3>
                        <p class="text-slate-700 bg-slate-50 p-4 rounded-xl">{{ $stokOpname->keterangan }}</p>
                    </div>
                @endif

                {{-- PENYESUAIAN SECTION --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Penyesuaian Stok</h2>
                            <p class="text-sm text-slate-600 mt-1">
                                Daftar penyesuaian yang telah dilakukan berdasarkan hasil opname ini
                            </p>
                        </div>
                        <div class="flex gap-3">
                            @can('create', App\Models\Penyesuaian::class)
                                @if($stokOpname->penyesuaian->isEmpty())
                                    <a href="{{ route('penyesuaians.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Penyesuaian
                                    </a>
                                @else
                                    <a href="{{ route('penyesuaians.show', $stokOpname->penyesuaian->first()) }}"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition shadow">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat Penyesuaian
                                    </a>
                                    @can('update', App\Models\Penyesuaian::class)
                                        <a href="{{ route('penyesuaians.edit', $stokOpname->penyesuaian->first()) }}"
                                            class="inline-flex items-center px-4 py-2 bg-amber-600 text-white text-sm font-semibold rounded-xl hover:bg-amber-700 transition shadow">
                                            <i class="fas fa-edit mr-2"></i>
                                            Edit Penyesuaian
                                        </a>
                                    @endcan
                                @endif
                            @endcan
                        </div>
                    </div>

                    @if($stokOpname->penyesuaian->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Barang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Qty Sistem</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Qty Fisik</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Selisih</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Disesuaikan Oleh</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($stokOpname->penyesuaian as $penyesuaian)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-slate-900">{{ $penyesuaian->barang->nama_barang }}</div>
                                                <div class="text-sm text-slate-500">{{ $penyesuaian->barang->kode_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                                {{ number_format($penyesuaian->qty_sistem) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                                {{ number_format($penyesuaian->qty_fisik) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    {{ $penyesuaian->selisih < 0 ? 'bg-red-100 text-red-800' : ($penyesuaian->selisih > 0 ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800') }}">
                                                    {{ $penyesuaian->selisih > 0 ? '+' : '' }}{{ number_format($penyesuaian->selisih) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($penyesuaian->selisih < 0)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        <i class="fas fa-minus-circle mr-1"></i> Kurang
                                                    </span>
                                                @elseif($penyesuaian->selisih > 0)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        <i class="fas fa-plus-circle mr-1"></i> Lebih
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">
                                                        <i class="fas fa-check-circle mr-1"></i> Sesuai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                                {{ $penyesuaian->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                {{ $penyesuaian->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- SUMMARY --}}
                        <div class="mt-6 bg-slate-50 rounded-xl p-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                                <div>
                                    <p class="text-2xl font-bold text-slate-900">{{ $stokOpname->penyesuaian->count() }}</p>
                                    <p class="text-sm text-slate-600">Total Barang</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-green-600">{{ $stokOpname->penyesuaian->where('selisih', '>', 0)->count() }}</p>
                                    <p class="text-sm text-slate-600">Lebih</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-red-600">{{ $stokOpname->penyesuaian->where('selisih', '<', 0)->count() }}</p>
                                    <p class="text-sm text-slate-600">Kurang</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-slate-600">{{ $stokOpname->penyesuaian->where('selisih', '=', 0)->count() }}</p>
                                    <p class="text-sm text-slate-600">Sesuai</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-balance-scale text-3xl text-slate-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-2">Belum Ada Penyesuaian</h3>
                            <p class="text-slate-600 mb-6">
                                Stok opname ini belum memiliki data penyesuaian. Buat penyesuaian untuk menyelaraskan stok sistem dengan kondisi fisik.
                            </p>
                            @can('create', App\Models\Penyesuaian::class)
                                <a href="{{ route('penyesuaians.create') }}"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition shadow">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Penyesuaian Sekarang
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>

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
