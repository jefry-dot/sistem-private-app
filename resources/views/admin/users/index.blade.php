<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Manajemen Client') }}
        </h2>
    </x-slot>

    <div class="py-6" 
         x-data="{ addUserModal: {{ request('action') === 'add' ? 'true' : 'false' }} }" 
         x-on:open-user-modal.window="addUserModal = true">
        
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
                <button @click="addUserModal = true" class="btn-primary">
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
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-accent hover:underline font-bold text-[11px] uppercase tracking-wider">Detail</a>
                                        
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-danger hover:underline font-bold text-[11px] uppercase tracking-wider">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400 italic">Belum ada klien terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── MODAL TAMBAH CLIENT ──────────────────────────────────── --}}
        <div x-show="addUserModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 bg-slate-900/60 backdrop-filter blur-sm"></div>

            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-surface w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-subtle"
                     style="background: var(--bg-surface); border: 1px solid var(--border-subtle);"
                     @click.away="addUserModal = false">
                    
                    <div class="p-6 border-b border-subtle flex justify-between items-center bg-elevated"
                         style="background: var(--bg-elevated); border-bottom: 1px solid var(--border-subtle);">
                        <div>
                            <h3 class="font-bold text-primary" style="color: var(--text-primary);">Tambah Client Baru</h3>
                            <p class="text-[10px] text-tertiary uppercase tracking-widest mt-0.5" style="color: var(--text-tertiary);">Admin Control</p>
                        </div>
                        <button @click="addUserModal = false" class="text-tertiary hover:text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="section-label mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="Nama klien...">
                        </div>
                        <div>
                            <label class="section-label mb-2">Username</label>
                            <input type="text" name="username" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="username123...">
                        </div>
                        <div>
                            <label class="section-label mb-2">Email Perusahaan</label>
                            <input type="email" name="email" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="email@perusahaan.com">
                        </div>
                        <div>
                            <label class="section-label mb-2">Password</label>
                            <input type="password" name="password" required class="form-input w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.5rem 0.75rem; border-radius: 8px;" placeholder="Password akses...">
                        </div>
                        <div>
                            <label class="section-label mb-2">Grup</label>
                            <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto no-scrollbar border border-subtle p-2 rounded-xl bg-elevated"
                                 style="background: var(--bg-elevated); border: 1px solid var(--border-subtle);">
                                @foreach($groups as $group)
                                <label class="flex items-center gap-2 p-1 cursor-pointer">
                                    <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="w-3.5 h-3.5 rounded accent-accent">
                                    <span class="text-[11px] font-medium text-secondary" style="color: var(--text-secondary);">{{ $group->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="addUserModal = false" class="btn-secondary flex-1 !py-2.5 !text-[11px]">Batal</button>
                            <button type="submit" class="btn-primary flex-1 !py-2.5 !text-[11px]">Simpan Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
