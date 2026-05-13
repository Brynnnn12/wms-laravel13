<x-app-layout>
    <div class="py-8">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">
                    Pengaturan Akun
                </p>

                <h1 class="text-3xl font-bold text-white">
                    Profil Saya
                </h1>

                <p class="text-emerald-100 text-sm mt-2">
                    Kelola informasi akun, keamanan password, dan penghapusan akun.
                </p>
            </div>

            {{-- GRID --}}
            <div x-data="{ tab: 'profile' }" class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- SIDEBAR --}}
                <div class="space-y-6">

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 text-center">
                        <div class="w-20 h-20 rounded-3xl bg-emerald-100 mx-auto flex items-center justify-center mb-4">
                            <i class="fas fa-user text-2xl text-emerald-600"></i>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800">
                            {{ auth()->user()->name }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ auth()->user()->email }}
                        </p>

                        <div class="mt-4 inline-flex px-3 py-1 rounded-2xl bg-emerald-50 text-emerald-700 text-xs font-semibold">
                            Akun Aktif
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                        <h4 class="font-bold text-slate-800 mb-4">
                            Menu Pengaturan
                        </h4>

                        <div class="space-y-3 text-sm">
                            <button type="button"
                                @click="tab = 'profile'"
                                :class="tab === 'profile' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50'"
                                class="w-full text-left rounded-2xl px-4 py-3 flex items-center justify-between gap-3 transition">
                                <span class="flex items-center gap-3">
                                    <i class="fas fa-user-circle text-emerald-600"></i>
                                    Informasi Profil
                                </span>
                            </button>

                            <button type="button"
                                @click="tab = 'password'"
                                :class="tab === 'password' ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50'"
                                class="w-full text-left rounded-2xl px-4 py-3 flex items-center justify-between gap-3 transition">
                                <span class="flex items-center gap-3">
                                    <i class="fas fa-lock text-blue-600"></i>
                                    Ubah Password
                                </span>
                            </button>

                            {{-- <button type="button"
                                @click="tab = 'delete'"
                                :class="tab === 'delete' ? 'bg-rose-50 text-rose-700' : 'text-slate-700 hover:bg-slate-50'"
                                class="w-full text-left rounded-2xl px-4 py-3 flex items-center justify-between gap-3 transition">
                                <span class="flex items-center gap-3">
                                    <i class="fas fa-trash text-rose-600"></i>
                                    Hapus Akun
                                </span>
                            </button> --}}
                        </div>
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="xl:col-span-2 space-y-6">

                    <div x-show="tab === 'profile'" x-cloak class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 md:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div x-show="tab === 'password'" x-cloak class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 md:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- <div x-show="tab === 'delete'" x-cloak class="bg-white rounded-3xl border border-rose-200 shadow-sm p-6 md:p-8">
                        @include('profile.partials.delete-user-form')
                    </div> --}}

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
