<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Pendaftaran Client</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar untuk mendapatkan akses ke sistem Mulia Grup</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="name" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Username -->
        <div class="space-y-1">
            <x-input-label for="username" :value="__('Username')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="username" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="johndoe123" />
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Alamat Email')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="email" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="password" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi')" class="font-bold text-xs uppercase tracking-widest text-gray-500" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-xl !border-gray-200 focus:!border-accent focus:!ring-accent/10"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full py-3.5 bg-accent hover:bg-accent-hover text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-accent/20 transform hover:-translate-y-0.5">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <p class="text-center text-xs text-gray-500 font-medium pt-2">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-accent font-bold hover:underline">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
