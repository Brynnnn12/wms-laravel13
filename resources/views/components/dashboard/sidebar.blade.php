@props(['isOpen' => true])

@php
    $user = auth()->user();

    // Konfigurasi Menu: Ganti path ke '#' untuk sementara
    if ($user && $user->hasRole('karyawan')) {
        $menuItems = [
            ['icon' => 'fa-calendar-check', 'label' => 'Absen', 'path' => '#', 'active' => request()->is('absen*')],
        ];
    } else {
        $menuItems = [
            ['icon' => 'fa-users', 'label' => 'Karyawan', 'path' => '#', 'active' => request()->is('karyawan*')],
        ];

        if ($user && $user->hasRole('super-admin')) {
            $menuItems[] = ['icon' => 'fa-user-shield', 'label' => 'Role', 'path' => route('roles.index'), 'active' => request()->is('dashboard/roles*')];
            $menuItems[] = ['icon' => 'fa-key', 'label' => 'Permission', 'path' => route('permissions.index'), 'active' => request()->is('dashboard/permissions*')];
        }
    }
@endphp

<div
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 shadow-2xl transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col border-r border-white/10"
>
    <div class="h-16 flex items-center px-6 border-b border-white/5 gap-3">
        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20">
            <span class="text-white font-bold text-lg leading-none">D</span>
        </div>
        <span class="font-bold text-lg tracking-tight text-slate-100 uppercase">Dashboard</span>

        <button @click="sidebarOpen = false" class="ml-auto md:hidden p-2 text-slate-400 hover:text-white transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
        @foreach($menuItems as $item)
            <a
                href="{{ $item['path'] }}"
                class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200 relative
                {{ $item['active']
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
                    : 'text-slate-400 hover:bg-white/5 hover:text-slate-100' }}"
            >
                <div class="w-5 flex justify-center items-center">
                    <i class="fas {{ $item['icon'] }} {{ $item['active'] ? 'scale-110' : 'group-hover:scale-110' }} transition-transform"></i>
                </div>
                <span class="text-sm font-medium">{{ $item['label'] }}</span>

                @if($item['active'])
                    <div class="absolute right-2 w-1.5 h-1.5 bg-white rounded-full"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/5 bg-slate-900/50">
        <button class="w-full group flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-white/10 text-slate-300 hover:bg-white/5 hover:text-white transition-all text-sm font-medium">
            <i class="fas fa-layer-group text-blue-500 group-hover:rotate-12 transition-transform"></i>
            Parallel Space
        </button>
    </div>
</div>
