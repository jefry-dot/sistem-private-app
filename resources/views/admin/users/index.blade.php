<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Manajemen Client') }}
        </h2>
    </x-slot>

    <div class="py-6">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Manajemen Client
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Kelola data client dan berikan akses ke grup yang sesuai.
                    </p>
                </div>
                <button type="button" class="btn-primary js-open-user-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Client
                </button>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Summary --}}
            @if($errors->any())
                <div class="p-4 mb-6 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs font-medium">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Terdapat kesalahan saat menyimpan data:
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table Card --}}
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Klien</th>
                                <th class="hidden md:table-cell">Username</th>
                                <th class="hidden md:table-cell">Email</th>
                                <th class="hidden sm:table-cell">Grup</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-accent-light flex items-center justify-center text-accent font-bold text-[10px]">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-accent text-sm">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell">
                                    <span class="text-xs text-gray-500">{{ $user->username }}</span>
                                </td>
                                <td class="hidden md:table-cell">
                                    <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                </td>
                                <td class="hidden sm:table-cell">
                                    @forelse($user->groups as $group)
                                        <span class="badge badge-indigo !text-[9px]">{{ $group->name }}</span>
                                    @empty
                                        <span class="text-gray-400 italic text-[10px]">Tanpa Grup</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge badge-green">Aktif</span>
                                    @else
                                        <span class="badge badge-red">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="row-actions">
                                        {{-- Detail --}}
                                        <a href="{{ route('admin.users.show', $user) }}" class="row-btn" title="Detail Klien">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        {{-- Delete --}}
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="row-btn danger" title="Hapus Klien">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding:0;">
                                    <div class="empty-state">
                                        <div class="empty-icon-wrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--text-tertiary)" stroke-width="1.25">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                        </div>
                                        <h3 style="font-size:0.9375rem;font-weight:700;color:var(--text-primary);margin:0 0 0.375rem;">Belum ada klien</h3>
                                        <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0 0 1.25rem;">
                                            Daftarkan klien baru untuk memberikan akses ke file.
                                        </p>
                                        <button type="button" class="btn-primary js-open-user-modal">Tambah Client</button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── MODAL TAMBAH CLIENT ──────────────────────────────────── --}}
        <div id="addUserModal" 
             class="admin-user-modal fixed inset-0 z-[100] overflow-y-auto {{ $errors->any() || request('action') === 'add' ? 'is-open' : '' }}">
            
            <div class="fixed inset-0 bg-slate-900/60 backdrop-filter blur-sm"></div>

            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="admin-user-modal-panel relative bg-surface w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-subtle"
                     style="background: var(--bg-surface); border: 1px solid var(--border-subtle);">
                    
                    <div class="p-6 border-b border-subtle flex justify-between items-center bg-elevated"
                         style="background: var(--bg-elevated); border-bottom: 1px solid var(--border-subtle);">
                        <div>
                            <h3 class="font-bold text-primary" style="color: var(--text-primary);">Tambah Client Baru</h3>
                            <p class="text-[10px] text-tertiary uppercase tracking-widest mt-0.5" style="color: var(--text-tertiary);">Admin Control</p>
                        </div>
                        <button type="button" class="js-close-user-modal text-tertiary hover:text-primary" aria-label="Tutup modal tambah client">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="section-label mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="Nama klien...">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div>
                            <label class="section-label mb-2">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="username123...">
                            <x-input-error :messages="$errors->get('username')" class="mt-1" />
                        </div>
                        <div>
                            <label class="section-label mb-2">Email Perusahaan <span class="text-[10px] opacity-50 font-normal">(Opsional)</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="email@perusahaan.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                        <div>
                            <label class="section-label mb-2">Password</label>
                            <input type="password" name="password" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="Password akses...">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label class="section-label mb-2">Grup</label>
                            <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto no-scrollbar border border-subtle p-2 rounded-xl bg-elevated"
                                 style="background: var(--bg-elevated); border: 1px solid var(--border-subtle);">
                                @foreach($groups as $group)
                                <label class="flex items-center gap-2 p-1 cursor-pointer">
                                    <input type="checkbox" name="groups[]" value="{{ $group->id }}" {{ is_array(old('groups')) && in_array($group->id, old('groups')) ? 'checked' : '' }} class="w-3.5 h-3.5 rounded accent-accent">
                                    <span class="text-[11px] font-medium text-secondary" style="color: var(--text-secondary);">{{ $group->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('groups')" class="mt-1" />
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" class="js-close-user-modal btn-secondary flex-1 !py-2.5 !text-[11px]">Batal</button>
                            <button type="submit" class="btn-primary flex-1 !py-2.5 !text-[11px]">Simpan Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('addUserModal');
                if (!modal) return;

                const openModal = () => modal.classList.add('is-open');
                const closeModal = () => modal.classList.remove('is-open');

                document.querySelectorAll('.js-open-user-modal').forEach((button) => {
                    button.addEventListener('click', openModal);
                });

                document.querySelectorAll('.js-close-user-modal').forEach((button) => {
                    button.addEventListener('click', closeModal);
                });

                modal.addEventListener('click', (event) => {
                    if (!event.target.closest('.admin-user-modal-panel')) closeModal();
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') closeModal();
                });

                window.addEventListener('open-user-modal', openModal);
            });
        </script>
    @endpush
</x-app-layout>
