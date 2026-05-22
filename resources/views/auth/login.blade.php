<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Mulia Grup Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if(session('error'))
        <div class="mb-6 font-bold text-xs text-red-600 bg-red-50 p-4 rounded-xl border border-red-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Username -->
        <div class="space-y-1">
            <x-input-label for="username" :value="__('Username')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="username" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Masukkan username Anda" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-accent uppercase tracking-wider hover:underline" href="{{ route('password.request') }}">
                        {{ __('Lupa Sandi?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-accent shadow-sm focus:ring-accent/20 w-4 h-4" name="remember">
                <span class="ms-2 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-3.5 bg-[#15803d] hover:bg-[#166534] text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-green-900/20 transform hover:-translate-y-0.5">
                {{ __('Login - Masuk Sekarang') }}
            </button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-500 font-medium">
                Belum punya akses? 
                <a href="{{ route('register') }}" class="text-accent font-bold hover:underline">Minta Akses</a>
            </p>
        @endif
    </form>
</x-guest-layout>
