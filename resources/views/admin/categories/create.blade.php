<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Buat Kategori Baru
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Kategori memudahkan client untuk memfilter file yang mereka butuhkan.
                    </p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Batal
                </a>
            </div>

            <div class="card overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="section-label mb-2">Nama Kategori</label>
                                <input type="text" name="name" required class="block w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.75rem 1rem; border-radius: 12px; outline: none; transition: border-color 0.2s;" placeholder="Misal: Laporan Keuangan, Kontrak Kerja, Dokumentasi Proyek..." autofocus>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-subtle flex justify-end">
                            <button type="submit" class="btn-primary !px-10 !py-3 !text-sm !rounded-xl shadow-lg">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
