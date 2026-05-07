<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Stok Opname Management</p>
                <h1 class="text-3xl font-bold text-white">Buat Stok Opname Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Catat jadwal pengecekan stok barang di ruangan tertentu.
                </p>
            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm">
                <div class="p-6 md:p-8">
                    <form action="{{ route('stok-opnames.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            {{-- Tanggal --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Stok Opname <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_so" value="{{ now()->format('Y-m-d') }}" required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                @error('tanggal_so')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pilih Ruang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Ruang <span class="text-rose-500">*</span>
                                </label>
                                <select name="nama_ruang_id" required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Pilih Ruang --</option>
                                    @foreach ($ruangs as $ruang)
                                        <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                                    @endforeach
                                </select>
                                @error('nama_ruang_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Keterangan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Keterangan Umum
                                </label>
                                <textarea name="keterangan" rows="3" placeholder="Contoh: Audit Semester 1, Pengecekan rutin bulanan, dll."
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                                @error('keterangan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3 pt-8 mt-8 border-t border-slate-200">
                            <a href="{{ route('stok-opnames.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-6 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 text-white px-6 py-3 text-sm font-semibold hover:bg-emerald-700 transition">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Stok Opname
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
