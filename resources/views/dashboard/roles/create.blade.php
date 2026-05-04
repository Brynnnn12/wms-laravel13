<x-app-layout>
    <div class="py-8" x-data="roleForm()">
        <div class="w-full max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-6 rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 md:p-8 shadow-xl">
                <p class="text-emerald-100 text-sm font-medium mb-2">Role Management</p>
                <h1 class="text-3xl font-bold text-white">Tambah Role Baru</h1>
                <p class="text-emerald-100 text-sm mt-2">
                    Buat role baru dan tentukan hak akses sesuai kebutuhan sistem inventory.
                </p>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="p-6 md:p-8 space-y-8">
                        {{-- FORM --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Role</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="Contoh: Supervisor"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                @error('name') <p class="text-sm text-rose-600 mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Guard Name</label>
                                <select name="guard_name" x-model="selectedGuard" @change="updatePermissions()"
                                    class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    @foreach(['web','api'] as $guard)
                                        <option value="{{ $guard }}">{{ strtoupper($guard) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- PERMISSION --}}
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-shield-alt text-emerald-600"></i>
                                Pilih Hak Akses
                            </h3>

                            {{-- SEARCH INPUT --}}
                            <div class="mb-6">
                                <div class="relative">
                                    <input type="text" x-model="searchQuery"
                                        @input="showDropdown = searchQuery.trim().length > 0"
                                        @keydown.escape="showDropdown = false"
                                        placeholder="Cari permission..."
                                        class="w-full px-5 py-3 rounded-2xl border-2 border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 text-sm">
                                    <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                                    {{-- Search Dropdown --}}
                                    <div x-show="showDropdown && searchQuery.trim().length > 0"
                                        class="absolute top-full left-0 right-0 mt-2 bg-white border-2 border-emerald-200 rounded-2xl shadow-lg z-20 max-h-96 overflow-y-auto">
                                        <template x-for="perm in getFilteredPermissions()" :key="perm.id">
                                            <button type="button"
                                                @click="addPermission(perm); showDropdown = false; searchQuery = '';"
                                                class="w-full text-left px-4 py-3 hover:bg-emerald-50 border-b border-slate-100 last:border-b-0 transition-colors">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <div class="font-semibold text-slate-900" x-text="perm.name"></div>
                                                        <div class="text-xs text-slate-500" x-text="perm.guard_name"></div>
                                                    </div>
                                                    <i x-show="selectedPermissions.find(p => p.id === perm.id)"
                                                        class="fas fa-check text-emerald-600"></i>
                                                </div>
                                            </button>
                                        </template>
                                        <div x-show="getFilteredPermissions().length === 0" class="px-4 py-6 text-center text-slate-400 text-sm">
                                            Permission tidak ditemukan
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SELECTED PERMISSIONS --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <h4 class="text-sm font-semibold text-slate-700 mb-3">
                                    Permission Terpilih
                                    <span class="text-emerald-600" x-text="`(${selectedPermissions.length})`"></span>
                                </h4>

                                <div x-show="selectedPermissions.length === 0" class="text-sm text-slate-500 text-center py-6">
                                    Belum ada permission yang dipilih
                                </div>

                                <div x-show="selectedPermissions.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                    <template x-for="perm in selectedPermissions" :key="perm.id">
                                        <div class="flex items-center justify-between rounded-2xl border border-emerald-200 bg-white p-4 hover:bg-emerald-50 group">
                                            <div class="flex-1">
                                                <div class="font-medium text-slate-900 text-sm" x-text="perm.name"></div>
                                                <div class="text-xs text-slate-500" x-text="perm.guard_name"></div>
                                            </div>
                                            <button type="button" @click="removePermission(perm.id)"
                                                class="ml-2 text-slate-300 hover:text-rose-500 transition">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" :name="`permissions[]`" :value="perm.id">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
                            <a href="{{ route('roles.index') }}"
                               class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                                Simpan Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function roleForm() {
            return {
                selectedGuard: '{{ old('guard_name', 'web') }}',
                allPermissions: {!! json_encode($permissions->mapWithKeys(function($items, $guard) {
                    return [$guard => $items->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'guard_name' => $guard])->toArray()];
                })) !!},
                selectedPermissions: [],
                searchQuery: '',
                showDropdown: false,

                init() {
                    this.updatePermissions();
                },

                updatePermissions() {
                    this.searchQuery = '';
                    this.showDropdown = false;
                },

                getFilteredPermissions() {
                    if (!this.searchQuery.trim()) return [];
                    const query = this.searchQuery.toLowerCase().trim();
                    const currentGuardPerms = this.allPermissions[this.selectedGuard] || [];

                    return currentGuardPerms.filter(p =>
                        p.name.toLowerCase().includes(query)
                    ).slice(0, 10);
                },

                addPermission(perm) {
                    if (!this.selectedPermissions.find(p => p.id === perm.id)) {
                        this.selectedPermissions.push(perm);
                    }
                },

                removePermission(permId) {
                    this.selectedPermissions = this.selectedPermissions.filter(p => p.id !== permId);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
