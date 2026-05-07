<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-2">
                                Penyesuaian Stok Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Detail Penyesuaian Stok
                            </h1>

                            <p class="text-blue-100 text-sm mt-2">
                                Informasi lengkap penyesuaian stok barang.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            @can('penyesuaian.update')
                            <a href="{{ route('penyesuaians.edit', $penyesuaian) }}"
                                class="inline-flex items-center px-4 py-2 rounded-2xl bg-white/10 text-white font-semibold text-sm border border-white/20 hover:bg-white/20 transition">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            @endcan
                            <a href="{{ route('stok-opnames.show', $penyesuaian->stokOpname) }}"
                                class="inline-flex items-center px-4 py-2 rounded-2xl bg-white/10 text-white font-semibold text-sm border border-white/20 hover:bg-white/20 transition">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Stok Opname
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFO STOK OPNAME --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <h2 class="font-bold text-slate-800 text-lg">
                        Informasi Stok Opname
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Detail sesi opname yang menjadi dasar penyesuaian ini.
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid gap-6 md:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Ruang</label>
                            <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->stokOpname->namaRuang->nama_ruang ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Tanggal Opname</label>
                            <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->stokOpname->tanggal_so->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Keterangan Opname</label>
                            <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->stokOpname->keterangan ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Dibuat Oleh</label>
                            <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->stokOpname->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="space-y-6">

                {{-- INFO CARDS --}}
                <div class="grid gap-6 md:grid-cols-2">
                    {{-- Barang Info --}}
                    <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-2xl bg-blue-100 mr-4">
                                <i class="fas fa-box text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Informasi Barang</h3>
                                <p class="text-sm text-slate-500">Detail barang yang disesuaikan</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Nama Barang:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->barang->nama_barang }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Kode Barang:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->barang->kode_barang }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Kondisi:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->barang->kondisiBarang->nama_kondisi ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Status:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->barang->statusBarang->nama_status ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- User Info --}}
                    <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-2xl bg-green-100 mr-4">
                                <i class="fas fa-user text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Informasi User</h3>
                                <p class="text-sm text-slate-500">Yang membuat penyesuaian</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Nama:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Email:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Dibuat Pada:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-slate-600">Diupdate Pada:</span>
                                <span class="text-sm font-medium text-slate-900">{{ $penyesuaian->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PENYESUAIAN DETAIL --}}
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                        <h2 class="font-bold text-slate-800 text-lg">
                            Detail Penyesuaian
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Perbandingan stok sistem vs fisik
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="grid gap-6 md:grid-cols-3">
                            {{-- Qty Sistem --}}
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-100 mb-3">
                                    <i class="fas fa-database text-slate-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-2xl">{{ $penyesuaian->qty_sistem }}</h3>
                                <p class="text-sm text-slate-500">Qty Sistem</p>
                            </div>

                            {{-- Qty Fisik --}}
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-100 mb-3">
                                    <i class="fas fa-hand-paper text-blue-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-2xl">{{ $penyesuaian->qty_fisik }}</h3>
                                <p class="text-sm text-slate-500">Qty Fisik</p>
                            </div>

                            {{-- Selisih --}}
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl
                                    {{ $penyesuaian->selisih > 0 ? 'bg-green-100' : ($penyesuaian->selisih < 0 ? 'bg-red-100' : 'bg-gray-100') }} mb-3">
                                    <i class="fas fa-balance-scale {{ $penyesuaian->selisih > 0 ? 'text-green-600' : ($penyesuaian->selisih < 0 ? 'text-red-600' : 'text-gray-600') }} text-xl"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-2xl
                                    {{ $penyesuaian->selisih > 0 ? 'text-green-600' : ($penyesuaian->selisih < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                    {{ $penyesuaian->selisih > 0 ? '+' : '' }}{{ $penyesuaian->selisih }}
                                </h3>
                                <p class="text-sm text-slate-500">Selisih</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KETERANGAN --}}
                @if($penyesuaian->keterangan)
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                        <h2 class="font-bold text-slate-800 text-lg">
                            Keterangan
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Alasan perubahan penyesuaian stok
                        </p>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-700">{{ $penyesuaian->keterangan }}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
