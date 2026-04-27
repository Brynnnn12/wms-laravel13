<x-app-layout>
    <div class="py-8">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 p-6 md:p-8 shadow-xl">
                <p class="text-orange-100 text-sm font-medium mb-2">Role Management</p>
                <h1 class="text-3xl font-bold text-white">Edit Role</h1>
                <p class="text-orange-100 text-sm mt-2">
                    {{ $role->name }}
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $currentPerms = $role->permissions->pluck('id')->toArray();
                    @endphp

                    <div class="p-6 md:p-8 space-y-8">

                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Role
                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $role->name) }}"
                                       required
                                       class="w-full rounded-2xl border-slate-300 focus:border-amber-500 focus:ring-amber-500">

                                @error('name')
                                    <p class="text-sm text-rose-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Guard Name
                                </label>

                                <select name="guard_name"
                                        class="w-full rounded-2xl border-slate-300 focus:border-amber-500 focus:ring-amber-500">

                                    @foreach(['web','api'] as $guard)
                                        <option value="{{ $guard }}"
                                            {{ old('guard_name', $role->guard_name) == $guard ? 'selected' : '' }}>
                                            {{ strtoupper($guard) }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>

                        {{-- PERMISSION --}}
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-4">
                                Sinkronisasi Permission
                            </h3>

                            <div class="space-y-5">

                                @foreach ($permissions as $guardName => $items)

                                    <div class="rounded-2xl border border-slate-200 overflow-hidden">

                                        <div class="px-5 py-3 bg-slate-50 border-b border-slate-200">
                                            <span class="text-xs font-bold uppercase
                                                {{ $role->guard_name == $guardName ? 'text-amber-600' : 'text-slate-600' }}">
                                                Guard : {{ $guardName }}
                                                @if($role->guard_name == $guardName)
                                                    (Aktif)
                                                @endif
                                            </span>
                                        </div>

                                        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                                            @foreach ($items as $permission)
                                                <label class="flex items-center gap-3 rounded-2xl border p-4 cursor-pointer transition
                                                    {{ in_array($permission->id, $currentPerms)
                                                        ? 'border-amber-300 bg-amber-50'
                                                        : 'border-slate-200 hover:border-amber-300 hover:bg-amber-50/50' }}">

                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           class="rounded border-slate-300 text-amber-600"
                                                           {{ in_array($permission->id, old('permissions', $currentPerms)) ? 'checked' : '' }}>

                                                    <span class="text-sm font-medium text-slate-700">
                                                        {{ $permission->name }}
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

                            <a href="{{ route('roles.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-amber-500 text-white font-semibold hover:bg-amber-600 transition shadow">
                                Perbarui Role
                            </button>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
