<x-app-layout>
    <div class="py-6">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-2">
                            Dashboard Inventory
                        </p>

                        <h1 class="text-3xl md:text-4xl font-bold text-white">
                            Selamat Datang, {{ auth()->user()->name }} 👋
                        </h1>

                        <p class="text-emerald-100 mt-2 text-sm md:text-base">
                            Pantau performa gudang, stok barang, dan aktivitas sistem hari ini.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div class="bg-white/10 backdrop-blur rounded-2xl px-5 py-4 text-white">
                            <p class="text-xs text-emerald-100">Tanggal</p>
                            <p class="font-bold">{{ now()->format('d M Y') }}</p>
                        </div>

                        <div class="bg-white/10 backdrop-blur rounded-2xl px-5 py-4 text-white">
                            <p class="text-xs text-emerald-100">Status</p>
                            <p class="font-bold">Online</p>
                        </div>

                    </div>

                </div>
            </div>

            {{-- CARD STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-500">Total Barang</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalBarang) }}</h3>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-500">Barang Masuk</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($barangMasuk) }}</h3>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-arrow-down text-emerald-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-500">Barang Keluar</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($barangKeluar) }}</h3>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-arrow-up text-amber-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-500">Stok Menipis</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($stokMenipis) }}</h3>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center">
                            <i class="fas fa-triangle-exclamation text-rose-600 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- STATISTIK BERDASARKAN KONDISI & STATUS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- BARANG BERDASARKAN KONDISI --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-800">
                            Barang Berdasarkan Kondisi
                        </h2>
                        <p class="text-sm text-slate-500">
                            Distribusi kondisi barang saat ini
                        </p>
                    </div>

                    <div class="space-y-4">
                        @forelse($barangByKondisi as $kondisi)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-slate-700">{{ $kondisi->nama_kondisi }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-900">{{ number_format($kondisi->barangs_count) }}</span>
                                    <span class="text-xs text-slate-500">barang</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 text-center py-4">Belum ada data kondisi barang</p>
                        @endforelse
                    </div>
                </div>

                {{-- BARANG BERDASARKAN STATUS --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-800">
                            Barang Berdasarkan Status
                        </h2>
                        <p class="text-sm text-slate-500">
                            Status ketersediaan barang
                        </p>
                    </div>

                    <div class="space-y-4">
                        @forelse($barangByStatus as $status)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm font-medium text-slate-700">{{ $status->nama_status }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-900">{{ number_format($status->barangs_count) }}</span>
                                    <span class="text-xs text-slate-500">barang</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 text-center py-4">Belum ada data status barang</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- CHART --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- LINE CHART --}}
                <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-800">
                            Grafik Barang Masuk & Keluar
                        </h2>
                        <p class="text-sm text-slate-500">
                            Statistik 6 bulan terakhir
                        </p>
                    </div>

                    <canvas id="transactionChart" height="110"></canvas>
                </div>

                {{-- DONUT --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-800">
                            Komposisi Kategori
                        </h2>
                        <p class="text-sm text-slate-500">
                            Distribusi stok barang
                        </p>
                    </div>

                    <canvas id="categoryChart" height="260"></canvas>
                </div>

            </div>

            {{-- TABLE BARANG TERUPDATE --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">
                        Barang Terupdate
                    </h2>
                    <p class="text-sm text-slate-500">
                        5 barang yang terakhir diupdate
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-6 py-4 text-left">Kode Barang</th>
                                <th class="px-6 py-4 text-left">Nama Barang</th>
                                <th class="px-6 py-4 text-left">Jenis</th>
                                <th class="px-6 py-4 text-left">Stok</th>
                                <th class="px-6 py-4 text-left">Kondisi</th>
                                <th class="px-6 py-4 text-left">Terakhir Update</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($barangTerupdate as $barang)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ $barang->kode_barang }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $barang->nama_barang }}</div>
                                        <div class="text-xs text-slate-500">{{ $barang->namaRuang?->nama_ruang ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $barang->jenisBarang?->nama_jenis ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $barang->jml_barang <= 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $barang->jml_barang }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $barang->kondisiBarang?->nama_kondisi ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $barang->updated_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        Belum ada data barang
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART JS --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded yet.');
                return;
            }

            const transactionCanvas = document.getElementById('transactionChart');
            const categoryCanvas = document.getElementById('categoryChart');

            if (transactionCanvas) {
                const transactionData = @json($transactionData);

                new Chart(transactionCanvas, {
                    type: 'line',
                    data: {
                        labels: transactionData.map(item => item.month),
                        datasets: [
                            {
                                label: 'Barang Masuk',
                                data: transactionData.map(item => item.masuk),
                                borderColor: 'rgb(34, 197, 94)',
                                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Barang Keluar',
                                data: transactionData.map(item => item.keluar),
                                borderColor: 'rgb(245, 158, 11)',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            if (categoryCanvas) {
                const categoryData = @json($categoryData);

                new Chart(categoryCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: categoryData.map(item => item.nama_jenis),
                        datasets: [{
                            data: categoryData.map(item => item.count),
                            backgroundColor: [
                                'rgb(34, 197, 94)',
                                'rgb(59, 130, 246)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
