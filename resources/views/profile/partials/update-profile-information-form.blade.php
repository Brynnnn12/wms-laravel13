<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            Informasi Profil
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Perbarui nama dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nama Lengkap
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                   required>

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Email
            </label>

            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full rounded-2xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"
                   required>

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-4 rounded-2xl bg-amber-50 border border-amber-200">
                    <p class="text-sm text-amber-700">
                        Email Anda belum terverifikasi.
                    </p>

                    <button form="send-verification"
                        class="mt-2 text-sm font-semibold text-amber-800 hover:underline">
                        Kirim ulang email verifikasi
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-sm text-emerald-600 mt-2">
                            Link verifikasi berhasil dikirim ulang.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit"
                class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
