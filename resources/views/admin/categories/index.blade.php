<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Kategori Berkas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Kategori Berkas
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Kelompokkan berkas ke dalam kategori untuk memudahkan pencarian oleh klien.
                    </p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kategori
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
                                    <th>Nama Kategori</th>
                                    <th>Slug</th>
                                    <th class="text-center">Jumlah Berkas</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded bg-accent-light flex items-center justify-center text-accent font-bold text-[10px]">
                                                    CT
                                                </div>
                                                <span class="font-bold text-accent text-sm">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-secondary text-sm">{{ $category->slug }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-indigo">
                                                {{ $category->files_count }} Berkas
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-accent hover:underline font-bold text-[11px] uppercase tracking-wider">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini? Berkas di kategori ini akan menjadi tidak berkategori.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger hover:underline font-bold text-[11px] uppercase tracking-wider">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-tertiary italic">Belum ada kategori yang dibuat.</td>
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
