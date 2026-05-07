<x-app-layout>
    <div class="py-8" x-data="penyesuaianForm()" x-cloak>
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-2">Penyesuaian Stok Management</p>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">Tambah Penyesuaian Stok</h1>
                            <p class="text-blue-100 text-sm mt-2">Buat penyesuaian stok berdasarkan hasil opname fisik.</p>
                        </div>
                        <a href="{{ route('penyesuaians.index') }}"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-white/10 text-white font-semibold text-sm border border-white/20 hover:bg-white/20 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- SCANNER SECTION --}}
            <template x-if="showScanner">
                <div class="mb-6 overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-sm p-4">
                    <div id="qr-reader" class="w-full"></div>
                    <button @click="toggleScanner()" type="button" class="mt-4 w-full py-2 bg-red-100 text-red-600 rounded-xl font-bold">
                        Tutup Kamera
                    </button>
                </div>
            </template>

            {{-- FORM --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm">
                <form id="form-penyesuaian" action="{{ route('penyesuaians.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    {{-- Pilih Stok Opname --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Opname <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="hidden" name="stok_opname_id" x-model="selectedStokOpname">

                            {{-- Input Search --}}
                            <input type="text" x-model="stokOpnameSearch"
                                @input.debounce.300ms="searchStokOpname()"
                                @keydown.enter.prevent="selectFirstStokOpname()"
                                @keydown.escape="clearSearch()"
                                x-ref="stokOpnameInput"
                                :class="selectedStokOpname ? 'bg-slate-50' : 'bg-white'"
                                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4"
                                placeholder="Ketik untuk mencari sesi opname...">

                            {{-- Clear Button --}}
                            <button type="button" @click="clearStokOpname()"
                                x-show="selectedStokOpname || stokOpnameSearch"
                                class="absolute right-3 top-2.5 text-slate-400 hover:text-red-600 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>

                            {{-- Selected Overlay --}}
                            <div x-show="selectedStokOpname && !stokOpnameSearch"
                                @click="stokOpnameSearch = getSelectedStokOpnameText(); $refs.stokOpnameInput.focus()"
                                class="absolute inset-0 flex items-center px-4 cursor-pointer hover:bg-slate-50 rounded-2xl bg-white">
                                <span class="text-slate-900 font-medium" x-text="getSelectedStokOpnameText()"></span>
                                <i class="fas fa-search ml-auto text-slate-400"></i>
                            </div>

                            {{-- Search Results --}}
                            <div x-show="stokOpnameSearch && filteredStokOpnames().length > 0"
                                x-transition
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-xl max-h-60 overflow-y-auto">
                                <template x-for="so in filteredStokOpnames()" :key="so.id">
                                    <div @click="selectStokOpname(so)"
                                        class="p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors">
                                        <div class="font-bold text-slate-800" x-text="so.nama_ruang + ' (' + so.tanggal_so + ')'"></div>
                                        <div class="text-xs text-slate-500" x-text="'Dibuat: ' + so.created_at + (so.keterangan ? ' - ' + so.keterangan : '')"></div>
                                    </div>
                                </template>
                            </div>

                            {{-- No Results --}}
                            <div x-show="stokOpnameSearch && filteredStokOpnames().length === 0"
                                x-transition
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-xl p-4 text-center text-slate-500 text-sm">
                                Tidak ada stok opname yang cocok dengan "<span class="font-medium" x-text="stokOpnameSearch"></span>"
                            </div>
                        </div>
                    </div>

                    {{-- Input Pencarian / Scan --}}
                    <div x-show="selectedStokOpname" x-transition>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Barang / Scan Barcode</label>
                        <div class="relative">
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="showSearchDropdown = true"
                                @keydown.enter.prevent="selectFirstResult()"
                                class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-3 pl-4 pr-12"
                                placeholder="Masukkan kode atau nama barang...">
                            <button type="button" @click="toggleScanner()" class="absolute right-3 top-2.5 text-slate-400 hover:text-blue-600">
                                <i class="fas fa-camera text-xl"></i>
                            </button>

                            {{-- Search Dropdown --}}
                            <div x-show="showSearchDropdown && searchQuery" @click.away="showSearchDropdown = false"
                                class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-xl max-h-60 overflow-y-auto">
                                <template x-for="b in getSearchResults()" :key="b.id">
                                    <div @click="addItemFromSearch(b)" class="p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-50 last:border-0">
                                        <div class="font-bold text-slate-800" x-text="b.nama_barang"></div>
                                        <div class="text-xs text-slate-500" x-text="b.kode_barang + ' - Stok: ' + b.jml_barang"></div>
                                    </div>
                                </template>
                                <div x-show="getSearchResults().length === 0" class="p-4 text-center text-slate-500 text-sm">
                                    Barang tidak ditemukan di ruangan ini.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Items Penyesuaian --}}
                    <div x-show="selectedStokOpname && items.length > 0" x-transition>
                        <div class="rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                                <h3 class="font-bold text-slate-800">Barang yang Akan Disesuaikan</h3>
                                <p class="text-sm text-slate-500 mt-1" x-text="`Total ${items.length} barang`"></p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Barang</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Qty Sistem</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Qty Fisik</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Selisih</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Keterangan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        <template x-for="(item, index) in items" :key="item.barang_id">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="hidden" :name="`items[${index}][barang_id]`" :value="item.barang_id">
                                                    <div class="text-sm font-medium text-slate-900" x-text="item.nama_barang"></div>
                                                    <div class="text-sm text-slate-500" x-text="item.kode_barang"></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900" x-text="item.jml_barang"></td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" :name="`items[${index}][qty_fisik]`" x-model="item.qty_fisik"
                                                        @input="calculateSelisih(index)" :id="`qty-${item.kode_barang}`"
                                                        class="w-20 rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                                        min="0" required>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span :class="item.selisih < 0 ? 'bg-red-100 text-red-800' : (item.selisih > 0 ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800')"
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                        x-text="item.selisih">
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <textarea :name="`items[${index}][keterangan]`" x-model="item.keterangan" rows="2"
                                                        class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm"
                                                        placeholder="Alasan penyesuaian..."></textarea>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button type="button" @click="removeItem(index)"
                                                        class="text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3 pt-6 border-t border-slate-200">
                        <a href="{{ route('penyesuaians.index') }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-6 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                            Batal
                        </a>
                        <button type="submit" x-show="items.length > 0"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 text-white px-6 py-3 text-sm font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            <i class="fas fa-save mr-2"></i> Simpan Penyesuaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function penyesuaianForm() {
            return {
                // Data stok opnames dari PHP
                stokOpnames: @json($stokOpnames ?? []),

                // Form state
                selectedStokOpname: '',
                selectedStokOpnameData: null,
                stokOpnameSearch: '',

                // Existing properties
                kamusBarang: [],
                items: [],
                searchQuery: '',
                showSearchDropdown: false,
                showScanner: false,
                loading: false,
                isProcessing: false,
                scanner: null,

                init() {
                    // Process stok opnames data
                    this.stokOpnames = this.stokOpnames.map(so => ({
                        id: so.id,
                        nama_ruang: so.nama_ruang?.nama_ruang ?? 'N/A',
                        tanggal_so: new Date(so.tanggal_so).toLocaleDateString('id-ID'),
                        keterangan: so.keterangan,
                        created_at: new Date(so.created_at).toLocaleDateString('id-ID') + ' ' + new Date(so.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})
                    }));

                    this.$watch('selectedStokOpname', (val) => {
                        if (val) this.fetchBarang();
                        else { this.items = []; this.kamusBarang = []; }
                    });
                },

                // Filter stok opnames berdasarkan search
                filteredStokOpnames() {
                    if (!this.stokOpnames || !Array.isArray(this.stokOpnames)) return [];
                    if (!this.stokOpnameSearch || !this.stokOpnameSearch.trim()) return this.stokOpnames.slice(0, 10); // Show first 10 if no search

                    const query = this.stokOpnameSearch.toLowerCase().trim();
                    return this.stokOpnames.filter(so =>
                        so.nama_ruang.toLowerCase().includes(query) ||
                        so.tanggal_so.toLowerCase().includes(query) ||
                        (so.keterangan && so.keterangan.toLowerCase().includes(query))
                    ).slice(0, 10); // Limit 10 hasil
                },

                // Pilih stok opname
                selectStokOpname(so) {
                    this.selectedStokOpname = so.id;
                    this.selectedStokOpnameData = so;
                    this.stokOpnameSearch = '';
                    // fetchBarang akan dipanggil otomatis karena watch selectedStokOpname
                },

                // Pilih stok opname pertama dari hasil pencarian (saat Enter)
                selectFirstStokOpname() {
                    const results = this.filteredStokOpnames();
                    if (results.length > 0) {
                        this.selectStokOpname(results[0]);
                    }
                },

                // Search stok opname (debounced)
                searchStokOpname() {
                    // Method ini dipanggil otomatis oleh @input.debounce
                    // Logika filtering ada di filteredStokOpnames()
                },

                // Clear search
                clearSearch() {
                    this.stokOpnameSearch = '';
                },

                // Clear selected stok opname
                clearStokOpname() {
                    this.selectedStokOpname = '';
                    this.selectedStokOpnameData = null;
                    this.stokOpnameSearch = '';
                    this.items = [];
                    this.kamusBarang = [];
                },

                // Get text untuk selected stok opname
                getSelectedStokOpnameText() {
                    if (!this.selectedStokOpnameData) return '';
                    return this.selectedStokOpnameData.nama_ruang + ' (' + this.selectedStokOpnameData.tanggal_so + ')';
                },

                // Ambil data referensi barang di ruangan tersebut
                async fetchBarang() {
                    this.loading = true;
                    try {
                        const res = await fetch(`{{ route('stok-opnames.barang-by-ruang') }}?stok_opname_id=${this.selectedStokOpname}`);
                        const result = await res.json();
                        if (result.success) {
                            this.kamusBarang = result.data;
                            this.items = []; // Reset tabel penyesuaian agar kosong
                        }
                    } catch (e) {
                        Swal.fire('Error', 'Gagal memuat data referensi barang.', 'error');
                    } finally { this.loading = false; }
                },

                // Pencarian manual via input text
                handleManualSearch() {
                    if (!this.searchQuery.trim()) {
                        Swal.fire('Info', 'Masukkan kode atau nama barang terlebih dahulu', 'info');
                        return;
                    }
                    const query = this.searchQuery.trim();
                    this.processScanResult(query);
                    this.searchQuery = ''; // Reset input setelah enter
                },

                // Ambil hasil pencarian dari kamus barang
                getSearchResults() {
                    if (!this.searchQuery.trim()) return [];

                    const query = this.searchQuery.toLowerCase().trim();
                    return this.kamusBarang.filter(b =>
                        b.kode_barang.toLowerCase().includes(query) ||
                        b.nama_barang.toLowerCase().includes(query)
                    ).slice(0, 8); // Limit 8 hasil
                },

                // Pilih item pertama dari hasil pencarian (saat Enter)
                selectFirstResult() {
                    const results = this.getSearchResults();
                    if (results.length > 0) {
                        this.addItemFromSearch(results[0]);
                        this.showSearchDropdown = false;
                    }
                },

                // Tambah item dari hasil pencarian
                addItemFromSearch(barang) {
                    // Prevent duplicate processing
                    if (this.isProcessing) return;
                    this.isProcessing = true;

                    // Cek apakah sudah ada di items
                    const exists = this.items.find(i => i.barang_id === barang.id);
                    if (exists) {
                        Swal.fire('Sudah Ada', `${barang.nama_barang} sudah ada di daftar penyesuaian`, 'info');
                        this.focusInput(barang.kode_barang);
                        this.isProcessing = false;
                        return;
                    }

                    // Tambahkan ke items
                    this.items.push({
                        barang_id: barang.id,
                        kode_barang: barang.kode_barang,
                        nama_barang: barang.nama_barang,
                        jml_barang: barang.jml_barang,
                        qty_fisik: barang.jml_barang,
                        keterangan: '',
                        selisih: 0
                    });

                    if (navigator.vibrate) navigator.vibrate(50);
                    this.searchQuery = '';
                    this.focusInput(barang.kode_barang);

                    // Reset flag setelah 1 detik
                    setTimeout(() => {
                        this.isProcessing = false;
                    }, 1000);
                },

                // Inti dari logika Scan/Cari
                processScanResult(decodedText) {
                    // Prevent duplicate processing
                    if (this.isProcessing) return;
                    this.isProcessing = true;

                    let input = decodedText.trim();
                    if (!input) {
                        this.isProcessing = false;
                        return;
                    }

                    if (input.includes('/')) input = input.split('/').pop(); // Ambil ID jika URL

                    // 1. Cek apakah barang sudah masuk di tabel items
                    const existingIndex = this.items.findIndex(i =>
                        String(i.barang_id) === String(input) ||
                        i.kode_barang.toLowerCase() === input.toLowerCase()
                    );

                    if (existingIndex !== -1) {
                        // Jika sudah ada, hanya vibrate (tanpa alert)
                        if (navigator.vibrate) navigator.vibrate([50, 100, 50]); // Double vibrate = sudah ada
                        this.focusInput(this.items[existingIndex].kode_barang);
                        this.isProcessing = false;
                        return;
                    }

                    // 2. Jika belum ada, cari di kamus referensi
                    const dataBarang = this.kamusBarang.find(b =>
                        String(b.id) === String(input) ||
                        b.kode_barang.toLowerCase() === input.toLowerCase()
                    );

                    if (dataBarang) {
                        // Tambahkan ke daftar items (tanpa alert)
                        this.items.push({
                            barang_id: dataBarang.id,
                            kode_barang: dataBarang.kode_barang,
                            nama_barang: dataBarang.nama_barang,
                            jml_barang: dataBarang.jml_barang,
                            qty_fisik: dataBarang.jml_barang, // Default set ke sistem
                            keterangan: '',
                            selisih: 0
                        });

                        // Vibrate untuk sukses
                        if (navigator.vibrate) navigator.vibrate(100);

                        // Fokus ke qty input untuk entry manual jika perlu
                        this.$nextTick(() => {
                            this.focusInput(dataBarang.kode_barang);
                        });

                        // Scanner tetap buka untuk scan berikutnya
                        // TIDAK set this.showScanner = false
                    } else {
                        // Item tidak ditemukan - vibrate 3x (error)
                        if (navigator.vibrate) navigator.vibrate([50, 50, 50]);
                    }

                    // Reset flag setelah 800ms (cooldown untuk scan berikutnya)
                    setTimeout(() => {
                        this.isProcessing = false;
                    }, 800);
                },

                focusInput(kodeBarang) {
                    this.$nextTick(() => {
                        const inputEl = document.getElementById('qty-' + kodeBarang);
                        if (inputEl) {
                            inputEl.focus();
                            inputEl.select();
                        }
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                },

                calculateSelisih(index) {
                    const itm = this.items[index];
                    const fisik = parseInt(itm.qty_fisik) || 0;
                    itm.selisih = fisik - itm.jml_barang;
                },

                toggleScanner() {
                    this.showScanner = !this.showScanner;
                    if (this.showScanner) {
                        this.$nextTick(() => this.startScanner());
                    } else {
                        this.stopScanner();
                    }
                },

                startScanner() {
                    const html5QrCode = new Html5Qrcode("qr-reader");
                    html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 15, qrbox: 250 },
                        (text) => this.processScanResult(text)
                    ).catch(() => {
                        this.showScanner = false;
                        Swal.fire('Kamera Error', 'Izin kamera ditolak atau tidak ditemukan.', 'error');
                    });
                    this.scanner = html5QrCode;
                },

                stopScanner() {
                    if (this.scanner) {
                        this.scanner.stop().then(() => { this.scanner = null; });
                    }
                },

                submitForm() {
                    const invalid = this.items.find(i => i.selisih < 0 && !i.keterangan.trim());
                    if (invalid) {
                        Swal.fire('Keterangan Wajib', `Barang "${invalid.nama_barang}" kurang stok, wajib isi alasannya!`, 'error');
                        return;
                    }

                    Swal.fire({
                        title: 'Simpan Penyesuaian?',
                        text: `${this.items.length} barang akan diperbarui stoknya.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        confirmButtonColor: '#10b981'
                    }).then((res) => {
                        if (res.isConfirmed) document.getElementById('form-penyesuaian').submit();
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
