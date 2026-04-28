<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-blue-600 via-cyan-600 to-indigo-600 p-6 md:p-8 shadow-xl overflow-hidden relative">

                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-2">
                                Access Permission Control
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Manajemen Permission
                            </h1>

                            <p class="text-blue-100 text-sm mt-2 max-w-2xl">
                                Kelola permission sistem dan hubungkan akses ke setiap role pengguna aplikasi inventory.
                            </p>
                        </div>

                        <a href="{{ route('permissions.create') }}"
                           class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-white text-blue-700 font-semibold text-sm hover:scale-[1.02] transition shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Permission
                        </a>
                    </div>
                </div>
            </div>


            {{-- CONTENT --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">
                            Data Permission Sistem
                        </h2>
                        <p class="text-sm text-slate-500">
                            Daftar seluruh permission yang tersedia.
                        </p>
                    </div>

                    <div class="relative">
                        <input type="text"
                               placeholder="Cari permission..."
                               class="w-full md:w-72 rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm pl-10">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <div class="p-6">

                    @if ($errors->has('permission'))
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first('permission') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Permission</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Guard</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">Dipakai Role</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($permissions as $index => $permission)
                                    <tr class="hover:bg-slate-50 transition">

                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            {{ $permissions->firstItem() + $index }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-slate-800">
                                                {{ $permission->name }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-blue-100 text-blue-700">
                                                {{ strtoupper($permission->guard_name) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            <i class="fas fa-user-shield text-slate-400 mr-2"></i>
                                            {{ $permission->roles_count }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('permissions.show', $permission) }}"
                                                   class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>

                                                <a href="{{ route('permissions.edit', $permission) }}"
                                                   class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-amber-500 hover:text-white transition">
                                                    <i class="fas fa-pen text-sm"></i>
                                                </a>

                                                <form action="{{ route('permissions.destroy', $permission) }}"
                                                      method="POST" data-confirm-delete="true">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-rose-600 hover:text-white transition">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-14 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                    <i class="fas fa-folder-open text-slate-400 text-xl"></i>
                                                </div>

                                                <p class="font-semibold text-slate-700">
                                                    Belum ada data permission
                                                </p>

                                                <p class="text-sm text-slate-500 mt-1">
                                                    Tambahkan permission baru untuk memulai.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $permissions->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
