<section>
    <header>
        <p class="section-label mb-2">Informasi Akun</p>
        <h2 class="text-lg font-bold text-primary">
            {{ __('Data Pribadi') }}
        </h2>

        <p class="mt-1 text-sm text-tertiary">
            {{ __("Perbarui nama dan alamat email akun Anda di sini.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-1">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-xs uppercase tracking-widest text-tertiary" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-xs uppercase tracking-widest text-tertiary" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full !rounded-xl !bg-elevated !border-subtle focus:!border-accent" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl mt-4">
                    <p class="text-sm text-amber-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="font-bold underline text-amber-900 hover:text-amber-950 focus:outline-none">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn-primary !px-8 !py-2.5 !rounded-xl shadow-lg">
                {{ __('Simpan Data') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
