<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-2">
                                Stok Opname Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Daftar Stok Opname
                            </h1>

                            <p class="text-emerald-100 text-sm mt-2">
                                Kelola pengecekan stok barang di seluruh ruang.
                            </p>
                        </div>

                        <a href="{{ route('stok-opnames.create') }}"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-white text-emerald-700 font-semibold text-sm shadow-lg hover:scale-[1.02] transition">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Stok Opname
                        </a>
                    </div>
                </div>
            </div>

            {{-- FILTER & SEARCH --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                    <form action="{{ route('stok-opnames.index') }}" method="GET"
                        class="grid gap-4 xl:grid-cols-[1fr_auto] xl:items-end">

                        <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-4">

                            {{-- Search --}}
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari ruang atau dibuat oleh..."
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm pl-11 py-3">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            </div>

                            {{-- Filter Ruang --}}
                            <div class="relative z-10">
                                <select name="ruang_id"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Semua Ruang</option>
                                @foreach ($ruangs as $ruang)
                                    <option value="{{ $ruang->id }}" {{ request('ruang_id') == $ruang->id ? 'selected' : '' }}>
                                        {{ $ruang->nama_ruang }}
                                    </option>
                                @endforeach
                                </select>
                            </div>

                            {{-- Filter Tanggal Mulai --}}
                            <div>
                                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                                    placeholder="Dari tanggal"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3">
                            </div>

                            {{-- Filter Tanggal Sampai --}}
                            <div>
                                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                                    placeholder="Sampai tanggal"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-3">
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-3">
                            <a href="{{ route('stok-opnames.index') }}"
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
                            Data Stok Opname
                        </h2>
                        <p class="text-sm text-slate-500">
                            Total: <span class="font-semibold text-slate-700">{{ $stokOpnames->total() }}</span> opname
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
                                    Tanggal Opname
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Ruang
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Dibuat Oleh
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($stokOpnames as $index => $opname)
                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                        {{ $stokOpnames->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">
                                                {{ $opname->tanggal_so->format('d M Y') }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $opname->tanggal_so->format('l') }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                                            {{ $opname->namaRuang->nama_ruang ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        <div>
                                            <p class="font-medium text-slate-900">
                                                {{ $opname->user->name ?? '-' }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $opname->created_at->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('stok-opnames.show', $opname) }}"
                                                class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-blue-500 hover:text-white transition"
                                                title="Lihat detail">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>

                                            <a href="{{ route('penyesuaians.create', ['stok_opname_id' => $opname->id]) }}"
                                                class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-emerald-500 hover:text-white transition"
                                                title="Buat Penyesuaian">
                                                <i class="fas fa-plus text-sm"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="font-medium">Belum ada data stok opname</p>
                                            <p class="text-sm mt-1">Mulai dengan membuat stok opname baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="px-6 py-5 border-t border-slate-100">
                    {{ $stokOpnames->links() }}
                </div>

            </div>



        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // TomSelect untuk dropdown ruang
                if (document.querySelector('select[name="ruang_id"]')) {
                    new TomSelect('select[name="ruang_id"]', {
                        create: false,
                        placeholder: 'Semua Ruang',
                        allowEmptyOption: true
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
