<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    <div class="min-h-screen flex">

        <!-- LEFT IMAGE -->
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center" style="background-image:url('/Logo 1.jpeg')">
        </div>

        <!-- RIGHT CONTENT -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
            <div class="w-full max-w-md">

                <!-- HEADER -->
                    <div class="mb-6 flex flex-col items-center justify-center space-y-2 text-center">
                        <img src="/Logo 2.png" alt="Logo Yayasan Al Biruni" class="h-16 w-auto">
                        <p class="text-sm font-medium text-gray-500 tracking-wide uppercase">Yayasan Al Biruni</p>
                    </div>
                <!-- GOOGLE LOGIN -->
                <a href="{{ route('google.redirect') }}"
                    class="flex items-center justify-center mt-4 text-white rounded-lg shadow-md hover:bg-gray-100 border">
                    <div class="px-4 py-3">
                        <svg class="h-6 w-6" viewBox="0 0 40 40">
                            <path fill="#FFC107"
                                d="M36.3425 16.7358H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 10 20 10C22.5492 10 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" />
                        </svg>
                    </div>
                    <span class="px-4 py-3 w-5/6 text-center text-gray-600 font-bold">
                        Masuk dengan Google
                    </span>
                </a>

                <!-- DIVIDER -->
                <div class="mt-6 flex items-center justify-between">
                    <span class="border-b w-1/5"></span>
                    <span class="text-xs text-gray-500 uppercase">atau</span>
                    <span class="border-b w-1/5"></span>
                </div>

                <!-- SLOT (FORM DINAMIS) -->
                <div class="mt-6 mb-2">
                    {{ $slot }}
                </div>

                <footer class="text-center text-sm text-gray-500 mt-8">
                    &copy; {{ date('Y') }} Sistem Inventory Yayasan Al Biruni. All rights reserved.
                </footer>


            </div>
        </div>
    </div>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

</body>

</html>
