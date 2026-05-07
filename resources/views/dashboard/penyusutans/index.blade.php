<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-2">
                                Keuangan Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Laporan Penyusutan Aset
                            </h1>

                            <p class="text-emerald-100 text-sm mt-2">
                                Rekap penyusutan aset per akhir bulan.
                            </p>
                        </div>

                        @can('generate', App\Models\Penyusutan::class)
                            <form action="{{ route('penyusutans.generate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                                <input type="hidden" name="tahun" value="{{ $tahun }}">
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-3 rounded-2xl bg-white text-emerald-700 font-semibold text-sm shadow-lg hover:scale-[1.02] transition">
                                    <i class="fas fa-rotate mr-2"></i>
                                    Generate Penyusutan
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- FILTER --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <form action="{{ route('penyusutans.index') }}" method="GET"
                        class="grid gap-4 xl:grid-cols-[1fr_auto] xl:items-end">
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            <select name="bulan"
                                class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                @foreach($months as $value => $label)
                                    <option value="{{ $value }}" {{ $bulan == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number"
                                name="tahun"
                                min="2000"
                                value="{{ $tahun }}"
                                class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3">
                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3">
                            <a href="{{ route('penyusutans.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 px-4 py-3 text-sm font-semibold hover:bg-slate-100 transition">
                                Reset
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 text-white px-4 py-3 text-sm font-semibold hover:bg-emerald-700 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                {{-- TOPBAR --}}
                <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">
                            Data Penyusutan
                        </h2>

                        <p class="text-sm text-slate-500">
                            Total aset: <span class="font-semibold text-slate-700">{{ $totalBarang }}</span> barang
                            • Total nilai buku: <span class="font-semibold text-slate-700">{{ rupiah($totalNilaiBuku) }}</span>
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    No
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Nama Barang
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Bulan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Tahun
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Nilai Awal
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Penyusutan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Akumulasi
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Nilai Buku
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Generated At
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($penyusutans as $index => $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm">
                                        {{ $penyusutans->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->barang->nama_barang ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $months[$item->bulan] ?? $item->bulan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->tahun }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ rupiah($item->nilai_awal) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ rupiah($item->nilai_penyusutan) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ rupiah($item->akumulasi_penyusutan) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ rupiah($item->nilai_buku) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->generated_at?->format('d M Y, H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-10 text-slate-500">
                                        Belum ada data penyusutan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-5 border-t border-slate-100">
                    {{ $penyusutans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
