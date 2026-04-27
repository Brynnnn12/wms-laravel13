<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Detail Role</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <a href="{{ route('roles.edit', $role) }}" class="px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-500">Nama Role</span>
                                <span class="block text-lg text-gray-900 font-semibold">{{ $role->name }}</span>
                            </div>

                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-500">Guard</span>
                                <span class="block text-lg text-gray-900">{{ $role->guard_name }}</span>
                            </div>

                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-500">Total User</span>
                                <span class="block text-lg text-gray-900">{{ $role->users_count }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <span class="block text-sm font-medium text-gray-500">Daftar Permission</span>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse ($role->permissions as $permission)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">Belum ada permission.</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-6 border-t border-gray-100 pt-4">
                                <span class="block text-xs text-gray-400">Dibuat pada: {{ $role->created_at?->format('d M Y, H:i') }}</span>
                                <span class="block text-xs text-gray-400">Terakhir diupdate: {{ $role->updated_at?->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
