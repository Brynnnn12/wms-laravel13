<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('permissions.update', $permission) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Permission</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('name', $permission->name) }}" required>
                                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard</label>
                                <select name="guard_name" id="guard_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    @foreach (['web', 'api'] as $guard)
                                        <option value="{{ $guard }}" {{ old('guard_name', $permission->guard_name) === $guard ? 'selected' : '' }}>{{ strtoupper($guard) }}</option>
                                    @endforeach
                                </select>
                                @error('guard_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        @php
                            $selectedRoles = old('roles', $permission->roles->pluck('id')->all());
                        @endphp

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role yang memiliki permission ini</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 border border-gray-200 rounded-md p-4 max-h-80 overflow-y-auto">
                                @forelse ($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ in_array($role->id, $selectedRoles, true) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">{{ $role->name }}</span>
                                    </label>
                                @empty
                                    <span class="text-sm text-gray-500">Belum ada role.</span>
                                @endforelse
                            </div>
                            @error('roles') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            @error('roles.*') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 mr-2">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
