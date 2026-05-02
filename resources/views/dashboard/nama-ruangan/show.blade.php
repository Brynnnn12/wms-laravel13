<x-app-layout>
    <div class="py-8">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 p-6 md:p-8 shadow-xl">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-2">
                            Inventory Management
                        </p>

                        <h1 class="text-3xl font-bold text-white">
                            Detail Ruangan
                        </h1>

                        <p class="text-blue-100 text-sm mt-2">
                            Informasi lengkap ruangan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('nama-ruang.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <a href="{{ route('nama-ruang.edit', $nama_ruang) }}"
                           class="px-5 py-3 rounded-2xl bg-white text-indigo-700 font-semibold hover:scale-[1.02] transition shadow">
                            <i class="fas fa-pen mr-2"></i>
                            Edit Ruangan
                        </a>

                    </div>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Nama Ruangan</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                {{ $nama_ruang->nama_ruang }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-door-open text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Lokasi Penyimpanan</p>
                            <h3 class="text-xl font-bold text-slate-800 mt-1">
                                {{ $nama_ruang->lokasiPenyimpanan->nama_lokasi ?? 'N/A' }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-emerald-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Dibuat Pada</p>
                            <h3 class="text-lg font-bold text-slate-800 mt-1">
                                {{ $nama_ruang->created_at->format('d M Y') }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- DETAIL --}}
                <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Ruangan
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail lengkap ruangan ini.
                        </p>
                    </div>

                    <div class="p-6 space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-slate-500">Nama Ruangan</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $nama_ruang->nama_ruang }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Lokasi Penyimpanan</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $nama_ruang->lokasiPenyimpanan->nama_lokasi ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- INFO --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Tambahan
                        </h2>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-sm text-slate-500">ID Ruangan</p>
                            <p class="font-semibold text-slate-800 mt-1">
                                {{ $nama_ruang->id }}
                            </p>
                        </div>

                        <div class="pt-5 border-t border-slate-100">
                            <p class="text-xs text-slate-400 mb-2">
                                Dibuat:
                                {{ $nama_ruang->created_at?->format('d M Y, H:i') }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Update:
                                {{ $nama_ruang->updated_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
