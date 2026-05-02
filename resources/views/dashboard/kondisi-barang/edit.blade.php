<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 p-6 md:p-8 shadow-xl">
                <p class="text-orange-100 text-sm font-medium mb-2">Kondisi Barang Management</p>
                <h1 class="text-3xl font-bold text-white">Edit Kondisi Barang</h1>
                <p class="text-orange-100 text-sm mt-2">
                    {{ $kondisi_barang->nama_kondisi }}
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('kondisi-barang.update', $kondisi_barang) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Kondisi
                                </label>

                                <input type="text"
                                       name="nama_kondisi"
                                       value="{{ old('nama_kondisi', $kondisi_barang->nama_kondisi) }}"
                                       required
                                       class="w-full rounded-2xl border-slate-300 focus:border-amber-500 focus:ring-amber-500">

                                @error('nama_kondisi')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('kondisi-barang.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-amber-500 text-white font-semibold hover:bg-amber-600 transition shadow">
                                Perbarui Kondisi Barang
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
