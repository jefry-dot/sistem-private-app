<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Atur Ulang Sandi</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masukkan kata sandi baru Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="email" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" :value="__('Kata Sandi Baru')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="password" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full py-3.5 bg-accent hover:bg-accent-hover text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-accent/20 transform hover:-translate-y-0.5">
                {{ __('Atur Ulang Sandi') }}
            </button>
        </div>
    </form>
</x-guest-layout>
