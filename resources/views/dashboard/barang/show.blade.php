<x-app-layout>
    <div class="py-8">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 p-6 md:p-8 shadow-xl">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-2">
                            Barang Management
                        </p>

                        <h1 class="text-3xl font-bold text-white">
                            Detail Barang
                        </h1>

                        <p class="text-blue-100 text-sm mt-2">
                            Informasi lengkap barang.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('barang.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <a href="{{ route('barang.edit', $barang) }}"
                           class="px-5 py-3 rounded-2xl bg-white text-indigo-700 font-semibold hover:scale-[1.02] transition shadow">
                            <i class="fas fa-pen mr-2"></i>
                            Edit Barang
                        </a>

                    </div>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Kode Barang</p>
                            <h3 class="text-xl font-bold text-slate-800 mt-1">
                                {{ $barang->kode_barang }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-tag text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Jumlah</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                {{ $barang->jml_barang }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-boxes text-emerald-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Harga Total</p>
                            <h3 class="text-lg font-bold text-slate-800 mt-1">
                                Rp {{ number_format($barang->harga_total, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                            <i class="fas fa-money-bill text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Status</p>
                            <h3 class="text-lg font-bold text-slate-800 mt-1">
                                {{ $barang->statusBarang->nama_status ?? '-' }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- DETAIL --}}
                <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Barang
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail lengkap barang ini.
                        </p>
                    </div>

                    <div class="p-6 space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-slate-500">Nama Barang</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->nama_barang }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Jenis Barang</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->jenisBarang->jenis_barang ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Harga Satuan</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Masa Penyusutan</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->masa_penyusutan ?? '-' }} tahun
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Nilai Residual</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    Rp {{ number_format($barang->nilai_residual ?? 0, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Label</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->label ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Kondisi Barang</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->kondisiBarang->nama_kondisi ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Nama Ruang</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->namaRuang->nama_ruang ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Tahun Anggaran</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $barang->tahun_anggaran ?? '-' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- INFO --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Tambahan
                        </h2>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-sm text-slate-500">ID</p>
                            <p class="font-semibold text-slate-800 mt-1">
                                {{ $barang->id }}
                            </p>
                        </div>

                        <div class="pt-5 border-t border-slate-100">
                            <p class="text-xs text-slate-400 mb-2">
                                Dibuat:
                                {{ $barang->created_at?->format('d M Y, H:i') }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Diupdate:
                                {{ $barang->updated_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
