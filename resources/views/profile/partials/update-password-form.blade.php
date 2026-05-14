<section>
    <header>
        <p class="section-label mb-2">Keamanan Akun</p>
        <h2 class="text-lg font-bold text-primary">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-tertiary">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-1">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" class="font-bold text-xs uppercase tracking-widest text-tertiary" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-1">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" class="font-bold text-xs uppercase tracking-widest text-tertiary" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-1">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-bold text-xs uppercase tracking-widest text-tertiary" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn-primary !px-8 !py-2.5 !rounded-xl shadow-lg">
                {{ __('Update Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Berhasil diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>
