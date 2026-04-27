<x-app-layout>
    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="mt-2 text-gray-600">Semoga hari Anda menyenangkan.</p>
            </div>
        </div>

    </div>
</x-app-layout>
