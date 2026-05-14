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
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.groups.edit', $group) }}" class="text-accent hover:underline font-bold text-[11px] uppercase tracking-wider">Edit</a>
                                                <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus grup ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger hover:underline font-bold text-[11px] uppercase tracking-wider">Hapus</button>
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
