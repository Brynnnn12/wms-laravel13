<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div
                class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Barang Management</p>
                <h1 class="text-3xl font-bold text-white">Tambah Barang Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Buat barang baru untuk sistem inventory gudang.
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('barang.store') }}" method="POST">
                    @csrf

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Nama Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Barang
                                </label>

                                <input type="text"
                                    name="nama_barang"
                                    value="{{ old('nama_barang') }}"
                                    required
                                    placeholder="Contoh: Laptop"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('nama_barang')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jenis Barang
                                </label>

                                <select name="jenis_barang_id" id="jenis_barang_id" required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach ($jenisBarangs as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ old('jenis_barang_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis_barang }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jenis_barang_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jumlah Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Jumlah Barang
                                </label>

                                <input type="number"
                                    name="jml_barang"
                                    value="{{ old('jml_barang') }}"
                                    required
                                    min="1"
                                    placeholder="0"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('jml_barang')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Harga Satuan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Harga Satuan
                                </label>

                                <input type="number"
                                    name="harga_satuan"
                                    value="{{ old('harga_satuan') }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    placeholder="0"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('harga_satuan')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Masa Penyusutan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Masa Penyusutan (tahun)
                                </label>

                                <input type="number"
                                    name="masa_penyusutan"
                                    value="{{ old('masa_penyusutan') }}"
                                    min="0"
                                    placeholder="0"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('masa_penyusutan')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nilai Residual --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nilai Residual
                                </label>

                                <input type="number"
                                    name="nilai_residual"
                                    value="{{ old('nilai_residual') }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="0"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('nilai_residual')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Label --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Label
                                </label>

                                <input type="text"
                                    name="label"
                                    value="{{ old('label') }}"
                                    placeholder="Contoh: A1"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('label')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Status Barang
                                </label>

                                <select name="status_barang_id" id="status_barang_id" required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Status Barang</option>
                                    @foreach ($statusBarangs as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('status_barang_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->nama_status }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status_barang_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kondisi Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Kondisi Barang
                                </label>

                                <select name="kondisi_barang_id" id="kondisi_barang_id" required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Kondisi Barang</option>
                                    @foreach ($kondisiBarangs as $kondisi)
                                        <option value="{{ $kondisi->id }}"
                                            {{ old('kondisi_barang_id') == $kondisi->id ? 'selected' : '' }}>
                                            {{ $kondisi->nama_kondisi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kondisi_barang_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Lokasi Penyimpanan
                                </label>

                                <select name="lokasi_penyimpanan_id"
                                    id="lokasi_penyimpanan_id"
                                    required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Lokasi Penyimpanan</option>

                                    @foreach ($lokasiPenyimpanans as $lokasi)
                                        <option value="{{ $lokasi->id }}"
                                            {{ old('lokasi_penyimpanan_id') == $lokasi->id ? 'selected' : '' }}>
                                            {{ $lokasi->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('lokasi_penyimpanan_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Ruangan --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Ruang
                                </label>

                                <select name="nama_ruang_id"
                                    id="nama_ruang_id"
                                    required
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Nama Ruang</option>
                                </select>

                                @error('nama_ruang_id')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tahun Anggaran --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tahun Anggaran
                                </label>

                                <input type="number"
                                    name="tahun_anggaran"
                                    value="{{ old('tahun_anggaran') }}"
                                    min="1900"
                                    max="{{ date('Y') + 1 }}"
                                    placeholder="{{ date('Y') }}"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('tahun_anggaran')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('barang.index') }}"
                                class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow">
                                Simpan Barang
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const ruangData = @json($namaRuangs);

            new TomSelect('#jenis_barang_id', {
                create: false,
                placeholder: 'Pilih Jenis Barang',
                allowEmptyOption: true
            });

            new TomSelect('#status_barang_id', {
                create: false,
                placeholder: 'Pilih Status Barang',
                allowEmptyOption: true
            });

            new TomSelect('#kondisi_barang_id', {
                create: false,
                placeholder: 'Pilih Kondisi Barang',
                allowEmptyOption: true
            });

            const lokasiSelect = new TomSelect('#lokasi_penyimpanan_id', {
                create: false,
                placeholder: 'Pilih Lokasi Penyimpanan',
                allowEmptyOption: true
            });

            const ruangSelect = new TomSelect('#nama_ruang_id', {
                create: false,
                placeholder: 'Pilih Nama Ruang',
                valueField: 'id',
                labelField: 'nama_ruang',
                searchField: 'nama_ruang',
                options: [],
                allowEmptyOption: true
            });

            ruangSelect.disable();

            function loadRuangan(lokasiId, selectedId = null) {
                ruangSelect.clear();
                ruangSelect.clearOptions();

                if (!lokasiId) {
                    ruangSelect.disable();
                    return;
                }

                const filtered = ruangData.filter(item =>
                    item.lokasi_penyimpanan_id == lokasiId
                );

                ruangSelect.enable();
                ruangSelect.addOptions(filtered);
                ruangSelect.refreshOptions(false);

                if (selectedId) {
                    ruangSelect.setValue(selectedId);
                }
            }

            lokasiSelect.on('change', function(value) {
                loadRuangan(value);
            });

            const oldLokasi = "{{ old('lokasi_penyimpanan_id') }}";
            const oldRuang  = "{{ old('nama_ruang_id') }}";

            if (oldLokasi) {
                loadRuangan(oldLokasi, oldRuang);
            }

        });
    </script>
    @endpush
</x-app-layout>
