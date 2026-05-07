@props(['isOpen' => true])

@php
    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Helper Menu Item
    |--------------------------------------------------------------------------
    */
    $menu = fn($icon, $label, $route, $active) => [
        'icon'   => $icon,
        'label'  => $label,
        'path'   => $route,
        'active' => $active,
    ];

    $menuGroups = [];

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN / ADMIN
    |--------------------------------------------------------------------------
    */
    if ($user && ($user->hasRole('super-admin') || $user->hasRole('admin'))) {

        $menuGroups = [

            [
                'title' => 'Dashboard',
                'icon'  => 'fa-gauge',
                'items' => [
                    $menu(
                        'fa-chart-line',
                        'Dashboard',
                        route('dashboard'),
                        request()->routeIs('dashboard')
                    ),
                ]
            ],

            [
                'title' => 'Master Data',
                'icon'  => 'fa-database',
                'items' => [
                    $menu('fa-tags', 'Jenis Barang', route('jenis-barang.index'), request()->is('dashboard/jenis-barang*')),
                    $menu('fa-tag', 'Status Barang', route('status-barang.index'), request()->is('dashboard/status-barang*')),
                    $menu('fa-clipboard-list', 'Kondisi Barang', route('kondisi-barang.index'), request()->is('dashboard/kondisi-barang*')),
                    $menu('fa-boxes-stacked', 'Lokasi Penyimpanan', route('lokasi-penyimpanan.index'), request()->is('dashboard/lokasi-penyimpanan*')),
                    $menu('fa-door-open', 'Nama Ruangan', route('nama-ruang.index'), request()->is('dashboard/nama-ruang*')),
                    $menu('fa-box', 'Barang', route('barang.index'), request()->is('dashboard/barang*')),
                    $menu('fa-chart-line', 'Penyusutan Aset', route('penyusutans.index'), request()->is('dashboard/penyusutans*')),
                    $menu('fa-clipboard', 'Stok Opname', route('stok-opnames.index'), request()->is('dashboard/stok-opname*'))
                ]
            ],

            [
                'title' => 'Pengguna & Akses',
                'icon'  => 'fa-users-gear',
                'items' => [
                    $menu('fa-users', 'User', route('users.index'), request()->is('dashboard/users*')),
                    $menu('fa-user-shield', 'Role', route('roles.index'), request()->is('dashboard/roles*')),
                    $menu('fa-key', 'Permission', route('permissions.index'), request()->is('dashboard/permissions*')),
                ]
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | INVENTARIS
    |--------------------------------------------------------------------------
    */
    elseif ($user && $user->hasRole('inventaris')) {

        $menuGroups = [

            [
                'title' => 'Dashboard',
                'icon'  => 'fa-gauge',
                'items' => [
                    $menu(
                        'fa-chart-line',
                        'Dashboard',
                        route('dashboard'),
                        request()->routeIs('dashboard')
                    ),
                ]
            ],

            [
                'title' => 'Inventory',
                'icon'  => 'fa-boxes-stacked',
                'items' => [
                    $menu('fa-box', 'Barang', route('barang.index'), request()->is('dashboard/barang*')),
                    $menu('fa-tags', 'Jenis Barang', route('jenis-barang.index'), request()->is('dashboard/jenis-barang*')),
                    $menu('fa-balance-scale', 'Penyesuaian Stok', route('penyesuaians.index'), request()->is('dashboard/penyesuaian*')),
                ]
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | KEUANGAN
    |--------------------------------------------------------------------------
    */
    elseif ($user && $user->hasRole('keuangan')) {

        $menuGroups = [

            [
                'title' => 'Dashboard',
                'icon'  => 'fa-gauge',
                'items' => [
                    $menu(
                        'fa-chart-line',
                        'Dashboard',
                        route('dashboard'),
                        request()->routeIs('dashboard')
                    ),
                ]
            ],

            [
                'title' => 'Keuangan',
                'icon'  => 'fa-wallet',
                'items' => [
                    $menu('fa-clipboard', 'Stok Opname', route('stok-opnames.index'), request()->is('dashboard/stok-opname*')),
                    $menu('fa-chart-line', 'Penyusutan Aset', route('penyusutans.index'), request()->is('dashboard/penyusutans*')),
                    $menu('fa-file-invoice-dollar', 'Laporan Keuangan', '#', false),
                ]
            ],
        ];
    }

@endphp

<div
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 shadow-xl transition-all duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col"
>

    {{-- HEADER --}}
    <div class="h-20 px-6 flex items-center gap-4 border-b border-slate-200">

        <div class="w-11 h-11 rounded-2xl bg-emerald-500 flex items-center justify-center shadow-md">
            <i class="fas fa-warehouse text-white text-lg"></i>
        </div>

        <div>
            <h1 class="text-slate-800 font-bold text-base">
                Inventory System
            </h1>
            <p class="text-slate-500 text-xs">
                Dashboard Panel
            </p>
        </div>

        <button
            @click="sidebarOpen = false"
            class="ml-auto md:hidden text-slate-500 hover:text-slate-800"
        >
            <i class="fas fa-times text-lg"></i>
        </button>

    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 px-4 py-5 overflow-y-auto space-y-4">

        @foreach($menuGroups as $group)
            <div
                x-data="{ open: true }"
                class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden"
            >

                {{-- Group Header --}}
                <button
                    @click="open = !open"
                    class="w-full px-4 py-3 flex items-center justify-between hover:bg-slate-100 transition"
                >
                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center">
                            <i class="fas {{ $group['icon'] }} text-emerald-600 text-sm"></i>
                        </div>

                        <span class="text-sm font-semibold text-slate-700">
                            {{ $group['title'] }}
                        </span>

                    </div>

                    <i
                        class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300"
                        :class="open ? 'rotate-180' : ''"
                    ></i>
                </button>

                {{-- Group Items --}}
                <div x-show="open" x-transition class="px-2 pb-2 space-y-1">

                    @foreach($group['items'] as $item)
                        <a
                            href="{{ $item['path'] }}"
                            class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                            {{ $item['active']
                                ? 'bg-emerald-500 text-white shadow-md'
                                : 'text-slate-600 hover:bg-white hover:text-emerald-600' }}"
                        >

                            <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                {{ $item['active']
                                    ? 'bg-white/20'
                                    : 'bg-slate-100 group-hover:bg-emerald-100' }}"
                            >
                                <i class="fas {{ $item['icon'] }} text-sm"></i>
                            </div>

                            <span class="text-sm font-medium">
                                {{ $item['label'] }}
                            </span>

                            @if($item['active'])
                                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
                            @endif

                        </a>
                    @endforeach

                </div>

            </div>
        @endforeach

    </nav>

</div>
