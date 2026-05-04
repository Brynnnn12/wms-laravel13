@props([
    'user' => null,
    'onMenuClick' => null
])

<header
    class="h-16 bg-white border-b border-slate-200 px-4 md:px-8 flex items-center justify-between sticky top-0 z-40 shadow-sm">

    {{-- LEFT SIDE --}}
    <div class="flex items-center gap-4">

        {{-- MOBILE MENU --}}
        <button
            @click="{{ $onMenuClick ?? 'sidebarOpen = !sidebarOpen' }}"
            class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        {{-- APP TITLE --}}
        <div class="leading-tight">
            <h1 class="text-lg md:text-xl font-bold text-emerald-600">
                {{ config('app.name', 'Sistem Inventory') }}
            </h1>
            <p class="text-xs text-slate-500 hidden md:block">
                Dashboard Management
            </p>
        </div>

    </div>

    {{-- RIGHT SIDE --}}
    <div class="flex items-center gap-3">

        {{-- NOTIFICATION --}}
        <button
            class="hidden sm:flex w-10 h-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 hover:text-emerald-600 transition"
        >
            <i class="far fa-bell text-lg"></i>
        </button>

        <div class="hidden sm:block w-px h-8 bg-slate-200"></div>

        {{-- USER DROPDOWN --}}
        <x-dropdown align="right" width="64">

            {{-- TRIGGER --}}
            <x-slot name="trigger">

                <button
                    class="flex items-center gap-3 p-1 rounded-xl hover:bg-slate-50 transition"
                >

                    {{-- AVATAR --}}
                    <div class="relative">

                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold shadow-sm"
                        >
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>

                        {{-- STATUS ACTIVE / NON ACTIVE --}}
                        @if($user && $user->is_active)
                            <span
                                class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"
                                title="Aktif"
                            ></span>
                        @else
                            <span
                                class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full"
                                title="Nonaktif"
                            ></span>
                        @endif

                    </div>

                    {{-- USER INFO --}}
                    <div class="hidden sm:block text-left leading-tight">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ $user->name ?? 'Guest User' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ $user->email ?? '-' }}
                        </p>

                    </div>

                    <i class="fas fa-chevron-down text-[10px] text-slate-400 hidden sm:block"></i>

                </button>

            </x-slot>

            {{-- CONTENT --}}
            <x-slot name="content">

                {{-- USER INFO MOBILE --}}
                <div class="sm:hidden px-4 py-3 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $user->name ?? 'Guest User' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ $user->email ?? '-' }}
                    </p>
                </div>

                {{-- STATUS --}}
                <div class="px-4 py-2 border-b border-slate-100 text-sm">

                    @if($user && $user->is_active)
                        <span class="text-green-600 font-medium">
                            ● Status: Aktif
                        </span>
                    @else
                        <span class="text-red-600 font-medium">
                            ● Status: Nonaktif
                        </span>
                    @endif

                </div>

                {{-- MENU --}}
                <x-dropdown-link
                    :href="route('dashboard')"
                    class="flex items-center gap-2 py-2.5"
                >
                    <i class="fas fa-home w-4 text-slate-400"></i>
                    <span>Dashboard</span>
                </x-dropdown-link>

                <x-dropdown-link
                    :href="route('profile.edit')"
                    class="flex items-center gap-2 py-2.5"
                >
                    <i class="fas fa-user w-4 text-slate-400"></i>
                    <span>Profil Saya</span>
                </x-dropdown-link>

                <div class="border-t border-slate-100 my-1"></div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-2 py-2.5 text-red-600 hover:bg-red-50"
                    >
                        <i class="fas fa-sign-out-alt w-4"></i>
                        <span>Logout</span>
                    </x-dropdown-link>

                </form>

            </x-slot>

        </x-dropdown>

    </div>

</header>
