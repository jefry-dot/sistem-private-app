<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Profil Saya
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Perbarui informasi akun dan kata sandi Anda untuk keamanan maksimal.
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 md:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card p-6 md:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card p-6 md:p-8 border-danger-light" style="border-top: 2px solid var(--danger);">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
