<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 p-6 md:p-8 shadow-xl">
                <p class="text-orange-100 text-sm font-medium mb-2">Jenis Barang Management</p>
                <h1 class="text-3xl font-bold text-white">Edit Jenis Barang</h1>
                <p class="text-orange-100 text-sm mt-2">
                    {{ $jenisBarang->jenis_barang }}
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('jenis-barang.update', $jenisBarang) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Kode Jenis
                                </label>

                                <input type="text"
                                       value="{{ $jenisBarang->kode_jenis }}"
                                       readonly
                                       class="w-full rounded-2xl border-slate-300 bg-slate-50 text-slate-500 cursor-not-allowed">

                                <p class="text-xs text-slate-500 mt-1">Kode jenis tidak dapat diubah</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jenis Barang
                                </label>

                                <input type="text"
                                       name="jenis_barang"
                                       value="{{ old('jenis_barang', $jenisBarang->jenis_barang) }}"
                                       required
                                       class="w-full rounded-2xl border-slate-300 focus:border-amber-500 focus:ring-amber-500">

                                @error('jenis_barang')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('jenis-barang.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-amber-500 text-white font-semibold hover:bg-amber-600 transition shadow">
                                Perbarui Jenis Barang
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
