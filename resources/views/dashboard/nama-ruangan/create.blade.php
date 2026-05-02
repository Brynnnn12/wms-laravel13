<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Inventory Management</p>
                <h1 class="text-3xl font-bold text-white">Tambah Ruangan Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Buat ruangan baru untuk sistem inventory.
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('nama-ruang.store') }}" method="POST">
                    @csrf

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Ruangan
                                </label>

                                <input type="text"
                                       name="nama_ruang"
                                       value="{{ old('nama_ruang') }}"
                                       required
                                       placeholder="Contoh: Ruang Server"
                                       class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('nama_ruang')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Lokasi Penyimpanan
                                </label>

                                <select name="lokasi_penyimpanan_id"
                                        required
                                        class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Lokasi</option>
                                    @foreach(\App\Models\LokasiPenyimpanan::all() as $lokasi)
                                        <option value="{{ $lokasi->id }}" {{ old('lokasi_penyimpanan_id') == $lokasi->id ? 'selected' : '' }}>
                                            {{ $lokasi->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('lokasi_penyimpanan_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('nama-ruang.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow">
                                Simpan Ruangan
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
