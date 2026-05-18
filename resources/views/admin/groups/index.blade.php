<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Grup Client') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Grup Client
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Kelola grup untuk memudahkan pembagian akses file ke banyak client sekaligus.
                    </p>
                </div>
                <a href="{{ route('admin.groups.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Grup
                </a>
            </div>

            @if(session('success'))
                <div class="alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Grup</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Klien</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groups as $group)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded bg-accent-light flex items-center justify-center text-accent font-bold text-[10px]">
                                                    GR
                                                </div>
                                                <span class="font-bold text-accent text-sm">{{ $group->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-secondary text-sm max-w-xs overflow-hidden text-ellipsis">{{ $group->description ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-indigo">
                                                {{ $group->users_count }} Client
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="row-actions">
                                                {{-- Edit --}}
                                                <a href="{{ route('admin.groups.edit', $group) }}" class="row-btn" title="Edit Grup">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                                {{-- Delete --}}
                                                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Hapus grup ini?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="row-btn danger" title="Hapus Grup">
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
                                        <td colspan="4" class="text-center py-12 text-tertiary italic">Belum ada grup yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
