<x-app-layout>
    <div class="py-8">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-gradient-to-r from-blue-600 via-cyan-600 to-indigo-600 p-6 md:p-8 shadow-xl mb-6">
                <p class="text-blue-100 text-sm font-medium mb-2">Access Control</p>
                <h1 class="text-3xl font-bold text-white">Tambah Permission</h1>
                <p class="text-blue-100 text-sm mt-2">
                    Buat permission baru dan hubungkan ke role yang sesuai.
                </p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Permission
                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       placeholder="Contoh: create-product"
                                       class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Guard Name
                                </label>

                                <select name="guard_name"
                                        class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="web">WEB</option>
                                    <option value="api">API</option>
                                </select>
                            </div>

                        </div>

                        {{-- ROLE SECTION --}}
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-4">
                                Hubungkan ke Role
                            </h3>

                            <div class="space-y-5">
                                @foreach ($roles as $guard => $roleGroup)
                                    <div class="rounded-2xl border border-slate-200 overflow-hidden">

                                        <div class="px-5 py-3 bg-slate-50 border-b border-slate-200">
                                            <span class="text-xs font-bold uppercase text-slate-600">
                                                Guard : {{ $guard }}
                                            </span>
                                        </div>

                                        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                                            @foreach ($roleGroup as $role)
                                                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer">

                                                    <input type="checkbox"
                                                           name="roles[]"
                                                           value="{{ $role->id }}"
                                                           class="rounded border-slate-300 text-blue-600">

                                                    <span class="text-sm font-medium text-slate-700">
                                                        {{ $role->name }}
                                                    </span>

                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('permissions.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow">
                                Simpan Permission
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
