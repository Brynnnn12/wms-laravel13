@props(['user' => null, 'onMenuClick' => null])

<header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-100 px-4 md:px-8 flex items-center justify-between sticky top-0 z-40">
    <div class="flex items-center gap-4">
        <button
            @click="{{ $onMenuClick ?? 'sidebarOpen = !sidebarOpen' }}"
            class="md:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition-all active:scale-95 focus:outline-none"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <div class="flex flex-col leading-none">
            <span class="text-lg font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent hidden md:block">
                {{ config('app.name', 'Laravel') }}
            </span>

        </div>
    </div>

    <div class="flex items-center gap-3">
        <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors hidden sm:block">
            <i class="far fa-bell text-xl"></i>
        </button>

        <div class="h-8 w-[1px] bg-gray-100 mx-1 hidden sm:block"></div>

        <x-dropdown align="right" width="56">
            <x-slot name="trigger">
                <button class="flex items-center gap-3 p-1 group">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:shadow-blue-300 group-hover:-translate-y-0.5 transition-all duration-300">
                            <span class="text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name ?? 'J', 0, 1)) }}
                            </span>
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>

                    <div class="text-left hidden sm:block">
                        <p class="text-sm font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">
                            {{ $user ? $user->name : 'John Doe' }}
                        </p>
                        <p class="text-[11px] text-gray-500 font-medium">
                            {{ $user ? $user->email : 'john.doe@example.com' }}
                        </p>
                    </div>

                    <i class="fas fa-chevron-down text-[10px] text-gray-400 group-hover:text-gray-600 group-hover:translate-y-0.5 transition-all hidden sm:block"></i>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-2 border-b border-gray-50 sm:hidden">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">User Account</p>
                </div>

                <x-dropdown-link :href="route('dashboard')" class="flex items-center gap-2 py-2.5">
                    <i class="fas fa-th-large w-4 text-gray-400"></i>
                    <span>Dashboard</span>
                </x-dropdown-link>

                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 py-2.5">
                    <i class="fas fa-user-circle w-4 text-gray-400"></i>
                    <span>Profil Saya</span>
                </x-dropdown-link>

                <div class="border-t border-gray-100 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-2 py-2.5 text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-4"></i>
                        <span>Logout</span>
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
