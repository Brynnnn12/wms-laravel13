<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-rose-700">
            Hapus Akun
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Setelah akun dihapus, seluruh data akan hilang permanen dan tidak dapat dikembalikan.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700 transition shadow">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-xl font-bold text-slate-800">
                Konfirmasi Hapus Akun
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Masukkan password Anda untuk melanjutkan penghapusan akun.
            </p>

            <div class="mt-5">
                <input type="password"
                       name="password"
                       placeholder="Masukkan password"
                       class="w-full rounded-2xl border-slate-300 focus:border-rose-500 focus:ring-rose-500">

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button"
                    x-on:click="$dispatch('close')"
                    class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50">
                    Batal
                </button>

                <button type="submit"
                    class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-semibold hover:bg-rose-700">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </x-modal>
</section>
