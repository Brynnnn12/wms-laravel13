<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6">
                <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl overflow-hidden relative">

                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

                    <div class="relative z-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-2">
                                Access Control Management
                            </p>

                            <h1 class="text-2xl md:text-3xl font-bold text-white">
                                Manajemen Role
                            </h1>

                            <p class="text-emerald-100 text-sm mt-2 max-w-2xl">
                                Kelola role pengguna, permission sistem, dan struktur hak akses
                                untuk aplikasi inventory gudang.
                            </p>
                        </div>

                        <a href="{{ route('roles.create') }}"
                           class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-white text-emerald-700 font-semibold text-sm hover:scale-[1.02] transition shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Role
                        </a>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">
                            Data Role Pengguna
                        </h2>
                        <p class="text-sm text-slate-500">
                            Daftar seluruh role yang tersedia dalam sistem.
                        </p>
                    </div>

                    <div class="relative">
                        <input type="text"
                               placeholder="Cari role..."
                               class="w-full md:w-72 rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-sm pl-10">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Role</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Guard</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Permission</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($roles as $index => $role)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $roles->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800">
                                            {{ $role->name }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ strtoupper($role->guard_name) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-700">
                                        <i class="fas fa-users text-slate-400 mr-2"></i>
                                        {{ $role->users_count ?? 0 }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            {{ $role->permissions_count ?? 0 }} Permission
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('roles.show', $role) }}"
                                               class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>

                                            <a href="{{ route('roles.edit', $role) }}"
                                               class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-amber-500 hover:text-white transition">
                                                <i class="fas fa-pen text-sm"></i>
                                            </a>

                                            <button type="button"
                                                    data-confirm-delete
                                                    data-confirm-route="{{ route('roles.destroy', $role) }}"
                                                    class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:bg-rose-600 hover:text-white transition">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-14 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i class="fas fa-folder-open text-slate-400 text-xl"></i>
                                            </div>

                                            <p class="font-semibold text-slate-700">
                                                Belum ada data role
                                            </p>

                                            <p class="text-sm text-slate-500 mt-1">
                                                Tambahkan role baru untuk memulai.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-5 border-t border-slate-100">
                    {{ $roles->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
