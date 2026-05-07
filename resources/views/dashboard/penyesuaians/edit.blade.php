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
                                Edit Penyesuaian Stok
                            </h1>

                            <p class="text-blue-100 text-sm mt-2">
                                Perbarui data penyesuaian stok barang.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('penyesuaians.show', $penyesuaian) }}"
                                class="inline-flex items-center px-4 py-2 rounded-2xl bg-white/10 text-white font-semibold text-sm border border-white/20 hover:bg-white/20 transition">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </a>
                            <a href="{{ route('penyesuaians.index') }}"
                                class="inline-flex items-center px-4 py-2 rounded-2xl bg-white/10 text-white font-semibold text-sm border border-white/20 hover:bg-white/20 transition">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
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
                    <div class="grid gap-6 md:grid-cols-3">
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
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <h2 class="font-bold text-slate-800 text-lg">
                        Form Edit Penyesuaian Stok
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Perbarui jumlah fisik dan keterangan penyesuaian.
                    </p>
                </div>

                <form action="{{ route('penyesuaians.update', $penyesuaian) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Info Barang (Read-only) --}}
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <h3 class="font-semibold text-slate-800 mb-3">Informasi Barang</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Nama Barang</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->barang->nama_barang }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Kode Barang</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->barang->kode_barang }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Qty Sistem Saat Ini</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->qty_sistem }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600">Qty Fisik Saat Ini</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $penyesuaian->qty_fisik }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Qty Fisik --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Jumlah Fisik Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="qty_fisik" value="{{ $penyesuaian->qty_fisik }}"
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4"
                            placeholder="Masukkan jumlah fisik baru" min="0" required>
                        @error('qty_fisik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-slate-500 mt-1">
                            Selisih baru akan dihitung otomatis: Qty Fisik - Qty Sistem
                        </p>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Keterangan
                        </label>
                        <textarea name="keterangan" rows="4"
                            class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-3"
                            placeholder="Jelaskan alasan perubahan penyesuaian...">{{ $penyesuaian->keterangan }}</textarea>
                        @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3 pt-6 border-t border-slate-200">
                        <a href="{{ route('penyesuaians.show', $penyesuaian) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-6 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 text-white px-6 py-3 text-sm font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            <i class="fas fa-save mr-2"></i>
                            Update Penyesuaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
