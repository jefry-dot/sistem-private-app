<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Lupa Kata Sandi?</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            {{ __('Jangan khawatir. Masukkan alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi yang baru.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="email" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 bg-accent hover:bg-accent-hover text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-accent/20 transform hover:-translate-y-0.5">
                {{ __('Kirim Link Reset Sandi') }}
            </button>
        </div>

        <p class="text-center text-xs text-gray-500 font-medium">
            Ingat sandi Anda? 
            <a href="{{ route('login') }}" class="text-accent font-bold hover:underline">Kembali ke Login</a>
        </p>
    </form>
</x-guest-layout>
