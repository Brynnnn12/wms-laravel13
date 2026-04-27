<x-app-layout>
    <div class="py-8">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 p-6 md:p-8 shadow-xl">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-2">
                            Role Management
                        </p>

                        <h1 class="text-3xl font-bold text-white">
                            Detail Role
                        </h1>

                        <p class="text-blue-100 text-sm mt-2">
                            Informasi lengkap role dan permission yang terhubung.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('roles.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/15 text-white font-semibold hover:bg-white/20 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <a href="{{ route('roles.edit', $role) }}"
                           class="px-5 py-3 rounded-2xl bg-white text-indigo-700 font-semibold hover:scale-[1.02] transition shadow">
                            <i class="fas fa-pen mr-2"></i>
                            Edit Role
                        </a>

                    </div>
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Nama Role</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                {{ $role->name }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user-shield text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Guard</p>
                            <h3 class="text-xl font-bold text-slate-800 mt-1 uppercase">
                                {{ $role->guard_name }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-shield-halved text-emerald-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Total User</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                {{ $role->users_count }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- PERMISSION --}}
                <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Daftar Permission
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Permission yang dimiliki role ini.
                        </p>
                    </div>

                    <div class="p-6">

                        @forelse ($role->permissions as $permission)
                            <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-blue-50 text-blue-700 border border-blue-100 mr-2 mb-2">
                                <i class="fas fa-key text-xs mr-2"></i>
                                {{ $permission->name }}
                            </span>
                        @empty
                            <div class="text-center py-10">
                                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-folder-open text-slate-400 text-xl"></i>
                                </div>

                                <p class="font-semibold text-slate-700">
                                    Belum ada permission
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Role ini belum memiliki hak akses.
                                </p>
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- INFO --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Role
                        </h2>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-sm text-slate-500">Nama Role</p>
                            <p class="font-semibold text-slate-800 mt-1">
                                {{ $role->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Guard Name</p>
                            <p class="font-semibold text-slate-800 mt-1 uppercase">
                                {{ $role->guard_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Total Permission</p>
                            <p class="font-semibold text-slate-800 mt-1">
                                {{ $role->permissions->count() }}
                            </p>
                        </div>

                        <div class="pt-5 border-t border-slate-100">
                            <p class="text-xs text-slate-400 mb-2">
                                Dibuat:
                                {{ $role->created_at?->format('d M Y, H:i') }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Update:
                                {{ $role->updated_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
