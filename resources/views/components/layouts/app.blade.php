<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Inventory') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .main-content::-webkit-scrollbar {
            width: 5px;
        }

        .main-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#f8fafc] text-slate-900 h-full overflow-hidden">

    <div x-data="{ sidebarOpen: false }" class="flex h-full overflow-hidden" x-cloak>

        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm md:hidden"></div>

        <x-dashboard.sidebar :active="$activePage ?? ''" />

        <div class="flex flex-col flex-1 min-w-0 bg-[#f8fafc] relative">

            <x-dashboard.navbar :user="auth()->user()" onMenuClick="sidebarOpen = !sidebarOpen" />

            <main class="main-content flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>


    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    @stack('scripts')

</body>

</html>
