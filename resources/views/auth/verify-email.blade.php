<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Verifikasi Email</h2>
        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            {{ __('Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke email Anda.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-bold text-xs text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-100">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="w-full py-3.5 bg-accent hover:bg-accent-hover text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-accent/20 transform hover:-translate-y-0.5">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                {{ __('Keluar Akun') }}
            </button>
        </form>
    </div>
</x-guest-layout>
