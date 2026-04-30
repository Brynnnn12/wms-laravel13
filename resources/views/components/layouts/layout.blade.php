{{-- resources/views/components/errors/layout.blade.php --}}
@props([
    'code',
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $code }}
        @if($title) - {{ $title }} @endif
        | {{ config('app.name', 'Sistem Inventory') }}
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-900">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="text-center max-w-xl">

            <h1 class="text-6xl md:text-7xl font-bold text-emerald-600">
                {{ $code }}
            </h1>

            <p class="text-xl font-medium text-slate-700 mt-4">
                {{ $slot }}
            </p>

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">

                <a href="{{ url()->previous() }}"
                   class="inline-block px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>

                <a href="{{ url('/') }}"
                   class="inline-block px-6 py-3 rounded-2xl bg-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-300 transition">
                    <i class="fas fa-house mr-2"></i>
                    Dashboard
                </a>

            </div>

        </div>

    </div>

</body>
</html>
