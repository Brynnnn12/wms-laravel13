@props(['isOpen' => true])

@php
    $user = auth()->user();
    $menuGroups = [];

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN & ADMIN
    |--------------------------------------------------------------------------
    */
    if ($user && ($user->hasRole('super-admin') || $user->hasRole('admin'))) {

        $menuGroups = [

            [
                'title' => 'Dashboard',
                'icon'  => 'fa-gauge',
                'items' => [
                    [
                        'icon'   => 'fa-chart-line',
                        'label'  => 'Dashboard',
                        'path'   => route('dashboard'),
                        'active' => request()->routeIs('dashboard'),
                    ],
                ]
            ],

            [
                'title' => 'Master Data',
                'icon'  => 'fa-database',
                'items' => [
                    [
                        'icon'   => 'fa-tags',
                        'label'  => 'Jenis Barang',
                        'path'   => route('jenis-barang.index'),
                        'active' => request()->is('dashboard/jenis-barang*'),
                    ],
                    [
                        'icon'   => 'fa-tag',
                        'label'  => 'Status Barang',
                        'path'   => route('status-barang.index'),
                        'active' => request()->is('dashboard/status-barang*'),
                    ],
                    [
                        'icon'   => 'fa-clipboard-list',
                        'label'  => 'Kondisi Barang',
                        'path'   => route('kondisi-barang.index'),
                        'active' => request()->is('dashboard/kondisi-barang*'),
                    ],
                ]
            ],

            [
                'title' => 'Pengguna & Akses',
                'icon'  => 'fa-shield-halved',
                'items' => [
                    [
                        'icon'   => 'fa-users',
                        'label'  => 'User',
                        'path'   => route('users.index'),
                        'active' => request()->is('dashboard/users*'),
                    ],
                    [
                        'icon'   => 'fa-user-shield',
                        'label'  => 'Role',
                        'path'   => route('roles.index'),
                        'active' => request()->is('dashboard/roles*'),
                    ],
                    [
                        'icon'   => 'fa-key',
                        'label'  => 'Permission',
                        'path'   => route('permissions.index'),
                        'active' => request()->is('dashboard/permissions*'),
                    ],
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
                    [
                        'icon'   => 'fa-chart-line',
                        'label'  => 'Dashboard',
                        'path'   => route('dashboard'),
                        'active' => request()->routeIs('dashboard'),
                    ],
                ]
            ],

            [
                'title' => 'Inventory',
                'icon'  => 'fa-boxes-stacked',
                'items' => [
                    [
                        'icon'   => 'fa-tags',
                        'label'  => 'Jenis Barang',
                        'path'   => route('jenis-barang.index'),
                        'active' => request()->is('dashboard/jenis-barang*'),
                    ],
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
                    [
                        'icon'   => 'fa-chart-line',
                        'label'  => 'Dashboard',
                        'path'   => route('dashboard'),
                        'active' => request()->routeIs('dashboard'),
                    ],
                ]
            ],

            [
                'title' => 'Keuangan',
                'icon'  => 'fa-wallet',
                'items' => [
                    [
                        'icon'   => 'fa-file-invoice-dollar',
                        'label'  => 'Laporan Keuangan',
                        'path'   => '#',
                        'active' => request()->is('dashboard/keuangan*'),
                    ],
                ]
            ],
        ];
    }
@endphp

<div
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 border-r border-emerald-500/10 shadow-2xl transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col"
>
    {{-- HEADER --}}
    <div class="h-20 px-6 flex items-center gap-4 border-b border-white/5">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
            <i class="fas fa-warehouse text-white text-lg"></i>
        </div>

        <div>
            <h1 class="text-white font-bold text-base tracking-wide">
                Inventory System
            </h1>
            <p class="text-slate-400 text-xs">
                Warehouse Dashboard
            </p>
        </div>

        <button
            @click="sidebarOpen = false"
            class="ml-auto md:hidden text-slate-400 hover:text-white"
        >
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 px-4 py-5 overflow-y-auto space-y-4">

        @foreach($menuGroups as $group)
            <div x-data="{ open: true }" class="rounded-2xl bg-white/[0.03] border border-white/5 overflow-hidden">

                <button
                    @click="open = !open"
                    class="w-full px-4 py-3 flex items-center justify-between hover:bg-white/5 transition"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                            <i class="fas {{ $group['icon'] }} text-emerald-400 text-sm"></i>
                        </div>

                        <span class="text-sm font-semibold text-slate-200">
                            {{ $group['title'] }}
                        </span>
                    </div>

                    <i class="fas fa-chevron-down text-xs text-slate-500 transition-transform duration-300"
                       :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-transition class="px-2 pb-2 space-y-1">
                    @foreach($group['items'] as $item)
                        <a
                            href="{{ $item['path'] }}"
                            class="group relative flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                            {{ $item['active']
                                ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                                : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                        >
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                {{ $item['active'] ? 'bg-white/15' : 'bg-white/5 group-hover:bg-white/10' }}">
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
