<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Konfirmasi Sandi</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            {{ __('Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />

            <x-text-input id="password" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 bg-accent hover:bg-accent-hover text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-accent/20 transform hover:-translate-y-0.5">
                {{ __('Konfirmasi Sekarang') }}
            </button>
        </div>
    </form>
</x-guest-layout>
