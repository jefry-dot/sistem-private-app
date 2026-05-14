<section class="space-y-6">
    <header>
        <p class="section-label mb-2 text-danger">Area Berbahaya</p>
        <h2 class="text-lg font-bold text-danger">
            {{ __('Hapus Akun Permanen') }}
        </h2>

        <p class="mt-1 text-sm text-tertiary">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <button
        class="px-6 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all shadow-sm"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun Saya') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-primary">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-2 text-sm text-tertiary leading-relaxed">
                {{ __('Tindakan ini tidak dapat dibatalkan. Harap masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
            </p>

            <div class="mt-8 space-y-1">
                <x-input-label for="password" value="{{ __('Kata Sandi Konfirmasi') }}" class="font-bold text-xs uppercase tracking-widest text-tertiary" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent"
                    placeholder="{{ __('Masukkan sandi Anda...') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl !px-6">
                    {{ __('Batal') }}
                </x-secondary-button>

                <button type="submit" class="px-6 py-2 bg-danger text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg hover:translate-y-[-1px] transition-all">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
