<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Stok Opname Management</p>
                <h1 class="text-3xl font-bold text-white">Buat Stok Opname Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Lakukan pengecekan stok barang di ruang terpilih dan catat hasil inventarisasi.
                </p>
            </div>

            <div x-data="stokOpnameForm()" class="space-y-6">
                <form action="{{ route('stok-opnames.store') }}" method="POST" id="form-stok-opname" @submit.prevent="submitForm">
                    @csrf

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 md:p-8 space-y-8">
                            {{-- HEADER FORM --}}
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 mb-6">Informasi Stok Opname</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    {{-- Tanggal --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Stok Opname <span class="text-rose-500">*</span></label>
                                        <input type="date" name="tanggal_so" x-model="tanggal_so" required
                                            class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>

                                    {{-- Pilih Ruang --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Ruang <span class="text-rose-500">*</span></label>
                                        <select name="nama_ruang_id" x-model="selectedRuang" required
                                            class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                            <option value="">-- Pilih Ruang --</option>
                                            @foreach ($ruangs as $ruang)
                                                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Keterangan Header --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan Umum</label>
                                        <input type="text" name="keterangan" placeholder="Contoh: Opname Bulanan"
                                            class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-200"></div>

                            {{-- DETAIL BARANG --}}
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-lg font-semibold text-slate-900">Daftar Item di Ruangan</h2>
                                    <span x-show="items.length > 0" class="text-sm text-slate-500" x-text="`Menampilkan ${items.length} item`"></p>
                                </div>

                                {{-- Loading & Error States --}}
                                <div x-show="loading" class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl animate-pulse">
                                    <p class="text-emerald-700 text-sm flex items-center">
                                        <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Sinkronisasi data barang dengan sistem...
                                    </p>
                                </div>

                                <div x-show="errorMessage" class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm" x-text="errorMessage"></div>

                                {{-- Tabel --}}
                                <div x-show="selectedRuang && items.length > 0" class="overflow-x-auto border border-slate-200 rounded-2xl">
                                    <table class="w-full text-sm">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="px-4 py-4 text-left font-bold text-slate-700">Nama Barang</th>
                                                <th class="px-4 py-4 text-center font-bold text-slate-700 w-24">Sistem</th>
                                                <th class="px-4 py-4 text-center font-bold text-slate-700 w-32">Fisik</th>
                                                <th class="px-4 py-4 text-center font-bold text-slate-700 w-24">Selisih</th>
                                                <th class="px-4 py-4 text-left font-bold text-slate-700">Keterangan Item</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <template x-for="(item, index) in items" :key="index">
                                                <tr :class="item.selisih !== 0 ? 'bg-rose-50/50' : 'hover:bg-slate-50'">
                                                    <td class="px-4 py-4">
                                                        <div class="font-semibold text-slate-900" x-text="item.nama_barang"></div>
                                                        <div class="text-xs text-slate-500" x-text="item.kode_barang"></div>
                                                        <input type="hidden" :name="`items[${index}][barang_id]`" :value="item.barang_id">
                                                        <input type="hidden" :name="`items[${index}][qty_sistem]`" :value="item.jml_barang">
                                                    </td>
                                                    <td class="px-4 py-4 text-center font-bold text-slate-600" x-text="item.jml_barang"></td>
                                                    <td class="px-4 py-4">
                                                        <input type="number" :name="`items[${index}][qty_fisik]`"
                                                            x-model.number="item.qty_fisik"
                                                            @input="calculateSelisih(index)"
                                                            class="w-full px-2 py-2 text-center rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500">
                                                    </td>
                                                    <td class="px-4 py-4 text-center">
                                                        <span :class="item.selisih < 0 ? 'text-rose-600' : (item.selisih > 0 ? 'text-blue-600' : 'text-emerald-600')"
                                                            class="font-bold text-base"
                                                            x-text="item.selisih > 0 ? `+${item.selisih}` : item.selisih">
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <input type="text" :name="`items[${index}][keterangan]`"
                                                            x-model="item.keterangan"
                                                            :placeholder="item.selisih < 0 ? 'Wajib isi alasan kurang...' : 'Opsional...'"
                                                            :class="item.selisih < 0 && !item.keterangan ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-300'"
                                                            class="w-full px-3 py-2 rounded-xl text-sm transition-all">
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Empty State --}}
                                <div x-show="!loading && items.length === 0" class="text-center py-12 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 text-slate-500">
                                    <p x-text="selectedRuang ? 'Tidak ada barang di ruang ini.' : 'Silakan pilih ruang terlebih dahulu.'"></p>
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div x-show="items.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <div class="text-xs font-bold text-slate-500 uppercase">Total Item</div>
                                    <div class="text-2xl font-bold text-slate-900" x-text="items.length"></div>
                                </div>
                                <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100">
                                    <div class="text-xs font-bold text-rose-500 uppercase">Item Selisih</div>
                                    <div class="text-2xl font-bold text-rose-700" x-text="itemsWithSelisih()"></div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="bg-slate-50 p-6 flex flex-col md:flex-row justify-end gap-4 border-t border-slate-200">
                            <a href="{{ route('stok-opnames.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-300 text-slate-700 font-bold text-center hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit"
                                :disabled="loading || (items.length === 0)"
                                :class="(loading || items.length === 0) ? 'opacity-50 cursor-not-allowed' : 'hover:scale-[1.02] active:scale-95 shadow-lg shadow-emerald-200'"
                                class="px-10 py-3 rounded-2xl bg-emerald-600 text-white font-bold transition-all">
                                <span x-show="!loading">Simpan Stok Opname</span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function stokOpnameForm() {
                return {
                    selectedRuang: '',
                    tanggal_so: '{{ now()->format('Y-m-d') }}',
                    items: [],
                    loading: false,
                    errorMessage: '',

                    init() {
                        this.$watch('selectedRuang', (value) => {
                            if (value) this.fetchBarang();
                            else this.items = [];
                        });
                    },

                    async fetchBarang() {
                        this.loading = true;
                        this.items = [];
                        this.errorMessage = '';

                        try {
                            const res = await fetch(`{{ route('stok-opnames.barang-by-ruang') }}?ruang_id=${this.selectedRuang}`);
                            const result = await res.json();

                            if (result.success && result.data.length > 0) {
                                this.items = result.data.map(b => ({
                                    barang_id: b.id,
                                    kode_barang: b.kode_barang,
                                    nama_barang: b.nama_barang,
                                    jml_barang: b.jml_barang,
                                    qty_fisik: b.jml_barang,
                                    keterangan: '',
                                    selisih: 0
                                }));
                            } else {
                                this.errorMessage = 'Tidak ada barang di ruangan ini.';
                            }
                        } catch (e) {
                            this.errorMessage = 'Gagal mengambil data barang. Periksa koneksi atau route.';
                        } finally {
                            this.loading = false;
                        }
                    },

                    calculateSelisih(index) {
                        const item = this.items[index];
                        if (item.qty_fisik === null || item.qty_fisik === '') item.qty_fisik = 0;
                        item.selisih = item.qty_fisik - item.jml_barang;
                    },

                    itemsWithSelisih() {
                        return this.items.filter(i => i.selisih !== 0).length;
                    },

                    submitForm() {
                        // Cek apakah ada item
                        if (this.items.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Pilih ruang dan pastikan ada barang untuk di-opname!',
                                confirmButtonColor: '#16a34a'
                            });
                            return;
                        }

                        // Cek apakah ada selisih NEGATIF yang belum diberi keterangan
                        const invalidItem = this.items.find(i => i.selisih < 0 && !i.keterangan.trim());
                        if (invalidItem) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Keterangan Diperlukan',
                                text: `Barang "${invalidItem.nama_barang}" kurang stok, wajib mengisi keterangan!`,
                                confirmButtonColor: '#16a34a'
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'question',
                            title: 'Konfirmasi',
                            text: 'Simpan hasil stok opname? Data stok barang akan otomatis diperbarui.',
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#16a34a',
                            cancelButtonColor: '#64748b'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('form-stok-opname').submit();
                            }
                        });
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
