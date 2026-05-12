<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfigurasi Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center shadow-sm">
                    <svg class="h-5 w-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="card overflow-hidden">
                <div class="flex flex-col md:flex-row min-h-[600px]">
                    
                    {{-- SIDE TABS --}}
                    <div class="w-full md:w-64 bg-elevated p-6 border-r border-subtle" style="background: var(--bg-elevated); border-right: 1px solid var(--border-subtle);">
                        <nav class="space-y-2">
                            <button onclick="switchTab('general')" id="tab-btn-general" class="tab-btn active w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all">
                                Pengaturan Umum
                            </button>
                            <button onclick="switchTab('branding')" id="tab-btn-branding" class="tab-btn w-full text-left px-4 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-surface transition-all">
                                Branding & Logo
                            </button>
                            <button onclick="switchTab('features')" id="tab-btn-features" class="tab-btn w-full text-left px-4 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-surface transition-all">
                                Fitur & Akses
                            </button>
                        </nav>
                        <div class="mt-10 p-4 bg-accent-light rounded-xl border border-accent-muted">
                            <p class="text-[10px] text-accent font-bold uppercase tracking-widest mb-2 text-center leading-tight">System Info</p>
                            <div class="space-y-1 text-center">
                                <p class="text-[10px] text-accent font-medium tracking-tighter">Mulia Grup System</p>
                                <p class="text-[10px] text-accent font-medium tracking-tighter">PHP v{{ PHP_VERSION }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- FORM CONTENT --}}
                    <div class="flex-1 p-8 bg-surface">
                        <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            {{-- TAB: GENERAL --}}
                            <div id="tab-general" class="tab-content space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-1">
                                        <x-input-label for="site_name" value="Nama Aplikasi / Perusahaan" class="font-bold" style="color: var(--text-primary);" />
                                        <x-text-input id="site_name" name="site_name" type="text" class="block w-full" :value="$settings['site_name'] ?? config('app.name')" />
                                        <p class="text-[10px] text-tertiary font-medium tracking-tighter italic">Digunakan di header, login, dan email notifikasi.</p>
                                    </div>
                                    <div class="space-y-1">
                                        <x-input-label for="contact_email" value="Email Dukungan (Support)" class="font-bold" style="color: var(--text-primary);" />
                                        <x-text-input id="contact_email" name="contact_email" type="email" class="block w-full" :value="$settings['contact_email'] ?? ''" />
                                        <p class="text-[10px] text-tertiary font-medium tracking-tighter italic">Ditampilkan untuk bantuan teknis klien.</p>
                                    </div>
                                </div>
                                <div class="space-y-1 pt-4 border-t border-subtle">
                                    <x-input-label for="footer_text" value="Teks Footer (Hak Cipta)" class="font-bold" style="color: var(--text-primary);" />
                                    <x-text-input id="footer_text" name="footer_text" type="text" class="block w-full" :value="$settings['footer_text'] ?? ''" />
                                    <p class="text-[10px] text-tertiary font-medium tracking-tighter italic">Muncul di bagian paling bawah dashboard.</p>
                                </div>
                            </div>

                            {{-- TAB: BRANDING --}}
                            <div id="tab-branding" class="tab-content hidden space-y-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                    <div class="space-y-4">
                                        <x-input-label value="Logo Aplikasi (Header)" class="font-bold text-primary uppercase text-xs tracking-widest" />
                                        <div class="p-6 bg-elevated rounded-2xl border-2 border-dashed border-subtle flex flex-col items-center justify-center space-y-4">
                                            <img src="{{ get_setting('site_logo', '/logo-2.png') }}" alt="Logo Preview" class="max-h-16 w-auto drop-shadow-sm">
                                            <input type="file" name="site_logo" class="text-xs text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-accent-light file:text-accent hover:file:bg-accent-muted">
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <x-input-label value="Favicon (Tab Browser)" class="font-bold text-primary uppercase text-xs tracking-widest" />
                                        <div class="p-6 bg-elevated rounded-2xl border-2 border-dashed border-subtle flex flex-col items-center justify-center space-y-4">
                                            <div class="p-2 bg-surface shadow-sm rounded border border-subtle">
                                                <img src="{{ get_setting('site_favicon', '/favicon.ico') }}" alt="Favicon Preview" class="h-8 w-8">
                                            </div>
                                            <input type="file" name="site_favicon" class="text-xs text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-accent-light file:text-accent hover:file:bg-accent-muted">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB: FEATURES --}}
                            <div id="tab-features" class="tab-content hidden space-y-6">
                                <div class="p-6 bg-elevated rounded-2xl space-y-4">
                                    <h4 class="text-xs font-bold text-tertiary uppercase tracking-widest border-b border-subtle pb-2">Kontrol Akses</h4>
                                    <div class="flex items-center p-3 bg-surface rounded-xl shadow-sm border border-subtle group transition-all hover:border-accent">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-light text-accent flex items-center justify-center mr-4">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-primary">Pendaftaran Publik</p>
                                            <p class="text-[10px] text-tertiary font-medium">Izinkan klien baru melakukan registrasi mandiri.</p>
                                        </div>
                                        <input type="checkbox" name="enable_registration" value="1" class="rounded-lg border-subtle text-accent shadow-sm w-6 h-6" {{ (get_setting('enable_registration') ?? '1') == '1' ? 'checked' : '' }}>
                                    </div>

                                    <div class="flex items-center p-3 bg-surface rounded-xl shadow-sm border border-subtle group transition-all hover:border-accent">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-light text-accent flex items-center justify-center mr-4">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0l-4-4m4 4v12"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-primary">Klien Dapat Upload</p>
                                            <p class="text-[10px] text-tertiary font-medium tracking-tighter">Izinkan klien mengunggah file mereka sendiri ke server.</p>
                                        </div>
                                        <input type="checkbox" name="enable_client_upload" value="1" class="rounded-lg border-subtle text-accent shadow-sm w-6 h-6" {{ (get_setting('enable_client_upload') ?? '0') == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 flex items-center justify-start border-t border-subtle pt-8">
                                <button type="submit" class="px-8 py-3 bg-accent text-white font-bold text-sm rounded-2xl shadow-lg hover:bg-accent-hover hover:translate-y-[-2px] transition-all duration-300">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tab-btn.active {
            background-color: var(--accent) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        function switchTab(tabId) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            // Show selected content
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            // Reset buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('text-secondary', 'hover:bg-surface');
            });
            // Active button
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            activeBtn.classList.add('active');
            activeBtn.classList.remove('text-secondary', 'hover:bg-surface');
        }
    </script>
</x-app-layout>
