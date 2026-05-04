<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Stok Opname Management</p>
                <h1 class="text-3xl font-bold text-white">Buat Stok Opname Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Pilih ruangan, lalu <b>Scan QR</b> atau cari barang untuk memasukkannya ke daftar pengecekan.
                </p>
            </div>

            <div x-data="stokOpnameForm()" class="space-y-6">
                <form action="{{ route('stok-opnames.store') }}" method="POST" id="form-stok-opname" @submit.prevent="submitForm">
                    @csrf

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 md:p-8 space-y-8">
                            {{-- HEADER FORM --}}
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 mb-6">Informasi Utama</h2>
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
                                        <input type="text" name="keterangan" placeholder="Contoh: Audit Semester 1"
                                            class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-200" x-show="selectedRuang"></div>

                            {{-- ACTIONS & SCANNER --}}
                            <div x-show="selectedRuang">
                                <div class="flex flex-col md:flex-row gap-4 mb-6">
                                    <div class="flex-1 relative">
                                        <input type="text" x-model="searchQuery"
                                            @input="showSearchDropdown = searchQuery.trim().length > 0"
                                            @keydown.enter.prevent="selectFirstResult()"
                                            @keydown.escape="showSearchDropdown = false"
                                            placeholder="Cari Kode/Nama Barang..."
                                            class="w-full px-5 py-3 rounded-2xl border-2 border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 text-sm">
                                        <button type="button" @click="selectFirstResult()"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-emerald-600 transition">
                                            <i class="fas fa-search text-lg"></i>
                                        </button>

                                        {{-- Search Preview Dropdown --}}
                                        <div x-show="showSearchDropdown && searchQuery.trim().length > 0"
                                            class="absolute top-full left-0 right-0 mt-2 bg-white border-2 border-emerald-200 rounded-2xl shadow-lg z-20 max-h-96 overflow-y-auto">
                                            <template x-for="barang in getSearchResults()" :key="barang.id">
                                                <button type="button"
                                                    @click="addItemFromSearch(barang); showSearchDropdown = false;"
                                                    class="w-full text-left px-4 py-3 hover:bg-emerald-50 border-b border-slate-100 last:border-b-0 transition-colors">
                                                    <div class="font-semibold text-slate-900" x-text="barang.nama_barang"></div>
                                                    <div class="flex justify-between items-center text-xs text-slate-500 mt-1">
                                                        <span class="font-mono text-emerald-600" x-text="barang.kode_barang"></span>
                                                        <span x-text="`Stok: ${barang.jml_barang}`"></span>
                                                    </div>
                                                </button>
                                            </template>
                                            <div x-show="getSearchResults().length === 0" class="px-4 py-6 text-center text-slate-400 text-sm">
                                                Barang tidak ditemukan
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="toggleScanner()"
                                        class="px-8 py-3 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-100">
                                        <i class="fas fa-qrcode text-lg"></i>
                                        Scan Barang
                                    </button>
                                </div>

                                {{-- Scanner Modal --}}
                                <div x-show="showScanner" class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center p-4" x-cloak>
                                    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-bold text-slate-900">Scan QR Code Barang</h3>
                                            <button type="button" @click="toggleScanner()" class="text-slate-400 hover:text-slate-600">
                                                <i class="fas fa-times text-xl"></i>
                                            </button>
                                        </div>
                                        <div id="qr-reader" class="rounded-2xl overflow-hidden mb-4 bg-slate-50 border border-slate-200"></div>
                                        <button type="button" @click="toggleScanner()" class="w-full py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition">Batal</button>
                                    </div>
                                </div>

                                {{-- TABLE ITEM TERPILIH --}}
                                <div class="overflow-hidden border border-slate-200 rounded-3xl">
                                    <table class="w-full text-sm">
                                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                                            <tr>
                                                <th class="px-6 py-4 text-left font-bold">Barang</th>
                                                <th class="px-6 py-4 text-center font-bold w-24">Sistem</th>
                                                <th class="px-6 py-4 text-center font-bold w-32">Fisik</th>
                                                <th class="px-6 py-4 text-center font-bold w-24">Selisih</th>
                                                <th class="px-6 py-4 text-left font-bold">Keterangan Item</th>
                                                <th class="px-4 py-4 text-center w-16"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 bg-white">
                                            <template x-for="(item, index) in items" :key="item.barang_id">
                                                <tr class="hover:bg-slate-50 transition-colors duration-200">
                                                    <td class="px-6 py-4">
                                                        <div class="font-bold text-slate-900" x-text="item.nama_barang"></div>
                                                        <div class="text-xs text-slate-500 font-mono" x-text="item.kode_barang"></div>
                                                        <input type="hidden" :name="`items[${index}][barang_id]`" :value="item.barang_id">
                                                        <input type="hidden" :name="`items[${index}][qty_sistem]`" :value="item.jml_barang">
                                                    </td>
                                                    <td class="px-6 py-4 text-center font-semibold text-slate-500" x-text="item.jml_barang"></td>
                                                    <td class="px-6 py-4">
                                                        <input type="number" :name="`items[${index}][qty_fisik]`"
                                                            x-model.number="item.qty_fisik"
                                                            @input="calculateSelisih(index)"
                                                            :id="'qty-' + item.kode_barang"
                                                            class="qty-input-field w-full px-2 py-2 text-center rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500 font-bold text-lg bg-emerald-50/30">
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span :class="item.selisih < 0 ? 'text-rose-600' : (item.selisih > 0 ? 'text-blue-600' : 'text-emerald-600')"
                                                            class="font-black text-base"
                                                            x-text="item.selisih > 0 ? `+${item.selisih}` : item.selisih">
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <input type="text" :name="`items[${index}][keterangan]`"
                                                            x-model="item.keterangan"
                                                            :placeholder="item.selisih < 0 ? 'Wajib isi alasan...' : 'Catatan...'"
                                                            :class="item.selisih < 0 && !item.keterangan.trim() ? 'border-rose-500 ring-rose-500 bg-rose-50' : 'border-slate-200'"
                                                            class="w-full px-3 py-2 rounded-xl text-xs transition-all">
                                                    </td>
                                                    <td class="px-4 py-4 text-center">
                                                        <button type="button" @click="removeItem(index)" class="text-slate-300 hover:text-rose-500 transition">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>

                                            {{-- Empty State dalam Tabel --}}
                                            <template x-if="items.length === 0">
                                                <tr>
                                                    <td colspan="6" class="py-20 text-center">
                                                        <div class="flex flex-col items-center opacity-40">
                                                            <i class="fas fa-barcode-read text-6xl mb-4 text-slate-300"></i>
                                                            <p class="text-slate-500 font-medium">Belum ada barang yang di-scan.</p>
                                                            <p class="text-xs text-slate-400 mt-1">Gunakan tombol Scan atau Cari untuk memulai.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="bg-slate-50 p-6 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-slate-200" x-show="selectedRuang">
                            <div class="text-sm text-slate-500">
                                <span class="font-bold text-slate-800" x-text="items.length"></span> barang terpilih untuk diproses.
                            </div>
                            <div class="flex gap-3 w-full md:w-auto">
                                <a href="{{ route('stok-opnames.index') }}" class="flex-1 md:flex-none px-6 py-3 rounded-2xl bg-white border border-slate-300 text-slate-700 font-bold text-center hover:bg-slate-50 transition">Batal</a>
                                <button type="submit" :disabled="loading || items.length === 0"
                                    :class="(loading || items.length === 0) ? 'opacity-50 cursor-not-allowed' : 'hover:scale-[1.02] active:scale-95 shadow-lg shadow-emerald-200'"
                                    class="flex-1 md:flex-none px-10 py-3 rounded-2xl bg-emerald-600 text-white font-bold transition-all">
                                    Simpan Stok Opname
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function stokOpnameForm() {
            return {
                selectedRuang: '',
                tanggal_so: '{{ now()->format("Y-m-d") }}',
                kamusBarang: [], // Tempat menyimpan data referensi ruangan
                items: [],       // Daftar barang yang benar-benar di-opname
                searchQuery: '',
                showSearchDropdown: false,
                showScanner: false,
                loading: false,
                isProcessing: false,
                scanner: null,

                init() {
                    this.$watch('selectedRuang', (val) => {
                        if (val) this.fetchKamusBarang();
                        else { this.items = []; this.kamusBarang = []; }
                    });
                },

                // Ambil data referensi barang di ruangan tersebut
                async fetchKamusBarang() {
                    this.loading = true;
                    try {
                        const res = await fetch(`{{ route('stok-opnames.barang-by-ruang') }}?ruang_id=${this.selectedRuang}`);
                        const result = await res.json();
                        if (result.success) {
                            this.kamusBarang = result.data;
                            this.items = []; // Reset tabel opname agar kosong (realistis)
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
                        Swal.fire('Sudah Ada', `${barang.nama_barang} sudah ada di daftar`, 'info');
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

                itemsWithSelisih() {
                    return this.items.filter(i => i.selisih !== 0).length;
                },

                submitForm() {
                    const invalid = this.items.find(i => i.selisih < 0 && !i.keterangan.trim());
                    if (invalid) {
                        Swal.fire('Keterangan Wajib', `Barang "${invalid.nama_barang}" kurang stok, wajib isi alasannya!`, 'error');
                        return;
                    }

                    Swal.fire({
                        title: 'Simpan Data?',
                        text: `${this.items.length} barang akan diperbarui stoknya.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        confirmButtonColor: '#10b981'
                    }).then((res) => {
                        if (res.isConfirmed) document.getElementById('form-stok-opname').submit();
                    });
                }
            }
        }
    </script>
    @endpush

    <style>
        [x-cloak] { display: none !important; }
        .qty-input-field:focus {
            transform: scale(1.05);
            transition: all 0.2s;
        }
    </style>
</x-app-layout>
