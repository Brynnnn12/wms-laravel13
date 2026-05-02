<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">User Management</p>
                <h1 class="text-3xl font-bold text-white">Tambah User Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Buat user baru untuk sistem inventory gudang.
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama
                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       placeholder="Masukkan nama lengkap"
                                       class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('name')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       placeholder="Masukkan alamat email"
                                       class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('email')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Password
                                </label>

                                <input type="password"
                                       name="password"
                                       required
                                       placeholder="Masukkan password"
                                       class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">

                                @error('password')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Konfirmasi Password
                                </label>

                                <input type="password"
                                       name="password_confirmation"
                                       required
                                       placeholder="Konfirmasi password"
                                       class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Role
                                </label>

                                <select name="roles[]"
                                        class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                                        required>
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('roles')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                                @error('roles.*')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Status User
                                </label>

                                <div class="mt-2 flex items-center gap-3">
                                    <label class="inline-flex items-center">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-slate-700">Aktif</span>
                                    </label>
                                </div>

                                @error('is_active')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">

                            <a href="{{ route('users.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow">
                                Simpan User
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
