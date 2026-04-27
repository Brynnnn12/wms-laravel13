<x-app-layout>
    <div class="py-8">
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
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">1,248</h3>
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
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">326</h3>
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
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">214</h3>
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
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">18</h3>
                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center">
                            <i class="fas fa-triangle-exclamation text-rose-600 text-xl"></i>
                        </div>
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

            {{-- TABLE MINI --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">
                        Aktivitas Terbaru
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-6 py-4 text-left">Tanggal</th>
                                <th class="px-6 py-4 text-left">Aktivitas</th>
                                <th class="px-6 py-4 text-left">User</th>
                                <th class="px-6 py-4 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-6 py-4">27 Apr 2026</td>
                                <td class="px-6 py-4">Input Barang Masuk</td>
                                <td class="px-6 py-4">Admin</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                        Sukses
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4">27 Apr 2026</td>
                                <td class="px-6 py-4">Mutasi Gudang</td>
                                <td class="px-6 py-4">Staff</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-xl bg-blue-100 text-blue-700 text-xs font-semibold">
                                        Diproses
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="px-6 py-4">26 Apr 2026</td>
                                <td class="px-6 py-4">Stock Opname</td>
                                <td class="px-6 py-4">Supervisor</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-xl bg-amber-100 text-amber-700 text-xs font-semibold">
                                        Review
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART JS --}}
    @push('scripts')
    <script>
        // LINE CHART
        const ctx = document.getElementById('transactionChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [120, 190, 170, 220, 260, 326],
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Barang Keluar',
                        data: [90, 130, 110, 170, 180, 214],
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
                }
            }
        });

        // DONUT CHART
        const ctx2 = document.getElementById('categoryChart');

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Elektronik', 'ATK', 'Furniture', 'Lainnya'],
                datasets: [{
                    data: [35, 25, 20, 20],
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
    </script>
    @endpush
</x-app-layout>
