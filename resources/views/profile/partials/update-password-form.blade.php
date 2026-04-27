<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            Ubah Password
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Gunakan password yang kuat untuk menjaga keamanan akun.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        @if(empty(auth()->user()->google_id))
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Password Saat Ini
            </label>

            <input type="password"
                   name="current_password"
                   class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        @endif

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Password Baru
            </label>

            <input type="password"
                   name="password"
                   class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Konfirmasi Password Baru
            </label>

            <input type="password"
                   name="password_confirmation"
                   class="w-full rounded-2xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
            class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow">
            Update Password
        </button>
    </form>
</section>
