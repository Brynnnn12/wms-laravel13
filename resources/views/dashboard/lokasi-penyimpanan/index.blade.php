<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-2">
                                Inventory Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Manajemen Lokasi Penyimpanan
                            </h1>

                            <p class="text-emerald-100 text-sm mt-2">
                                Kelola data lokasi penyimpanan pada sistem inventory.
                            </p>
                        </div>

                        <a href="{{ route('lokasi-penyimpanan.create') }}"
                           class="inline-flex items-center px-5 py-3 rounded-2xl bg-white text-emerald-700 font-semibold text-sm shadow-lg hover:scale-[1.02] transition">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Lokasi Penyimpanan
                        </a>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <form id="bulk-delete-form"
                  data-bulk-delete
                  action="{{ route('lokasi-penyimpanan.bulk-delete') }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                    {{-- TOPBAR --}}
                    <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h2 class="font-bold text-slate-800 text-lg">
                                Data Lokasi Penyimpanan
                            </h2>

                            <p class="text-sm text-slate-500">
                                Daftar seluruh lokasi penyimpanan yang tersedia.
                            </p>
                        </div>

                        <div class="flex items-center gap-3">

                            <button type="button"
                                    id="bulk-delete-btn"
                                    data-delete-button
                                    data-confirm-message="Apakah Anda yakin ingin menghapus lokasi penyimpanan yang dipilih?"
                                    class="hidden px-4 py-2 rounded-2xl bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Terpilih
                            </button>

                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-center">
                                        <input type="checkbox"
                                               id="select-all"
                                               data-select-all
                                               class="rounded border-slate-300 text-emerald-600">
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        No
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                        Nama Lokasi
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse($lokasiPenyimpanans as $index => $lokasi)
                                    <tr class="hover:bg-slate-50">

                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox"
                                                   name="ids[]"
                                                   value="{{ $lokasi->id }}"
                                                   data-checkbox
                                                   class="item-checkbox rounded border-slate-300 text-emerald-600">
                                        </td>

                                        <td class="px-6 py-4 text-sm">
                                            {{ $lokasiPenyimpanans->firstItem() + $index }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $lokasi->nama_lokasi }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('lokasi-penyimpanan.show', $lokasi) }}"
                                                   class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-blue-500 hover:text-white transition">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>

                                                <a href="{{ route('lokasi-penyimpanan.edit', $lokasi) }}"
                                                   class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-amber-500 hover:text-white transition">
                                                    <i class="fas fa-pen text-sm"></i>
                                                </a>

                                                <button type="button"
                                                        data-confirm-delete
                                                        data-confirm-route="{{ route('lokasi-penyimpanan.destroy', $lokasi) }}"
                                                        class="w-10 h-10 rounded-xl border flex items-center justify-center hover:bg-rose-600 hover:text-white transition">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-10 text-slate-500">
                                            Belum ada data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="px-6 py-5 border-t border-slate-100">
                        {{ $lokasiPenyimpanans->links() }}
                    </div>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
