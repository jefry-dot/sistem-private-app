<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-primary">Berkas Saya</h1>
            <div class="flex items-center gap-4 w-full sm:w-auto">
                {{-- Quick search --}}
                <div class="relative flex-1 sm:flex-none">
                    <input type="text" id="inline-search" class="text-sm border-subtle rounded-lg pl-9 pr-4 py-1.5 focus:border-accent outline-none w-full sm:w-64" placeholder="Cari dokumen...">
                    <svg class="absolute left-3 top-2.5 text-tertiary" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        .portal-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 1024px) {
            .portal-layout {
                grid-template-columns: 240px 1fr;
            }
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.625rem 0.875rem;
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .category-item:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        .category-item.active {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
        }

        .category-count {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        /* ── EMPTY STATE ─────────────────────────────────── */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6rem 2rem;
            text-align: center;
            background: var(--bg-surface);
            border: 1px dashed var(--border-strong);
            border-radius: 20px;
            margin-top: 1rem;
        }

        .empty-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 24px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--accent);
            position: relative;
        }

        .empty-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 32px;
            border: 1px solid var(--border-subtle);
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .empty-sub {
            color: var(--text-tertiary);
            font-size: 0.9375rem;
            max-width: 320px;
            line-height: 1.5;
        }
    </style>

    <div class="portal-layout">
        {{-- Sidebar Categories --}}
        <aside class="flex flex-col gap-6">
            <div class="section-card p-4">
                <p class="section-label mb-4">Kategori</p>
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('client.dashboard') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                        <span>Semua File</span>
                        <span class="category-count">{{ $files->total() }}</span>
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('client.dashboard', ['category' => $category->id]) }}" class="category-item {{ request('category') == $category->id ? 'active' : '' }}">
                        <span>{{ $category->name }}</span>
                        <span class="category-count">{{ $category->files_count }}</span>
                    </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        {{-- Main File List --}}
        <main class="flex flex-col gap-6">
            <div id="file-container">
                @if($files->count() > 0)
                    <div class="google-file-list">
                        @foreach($files as $file)
                            <div class="google-file-item" data-search-item>
                                <div class="google-file-path">
                                    <span>File Saya</span>
                                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>{{ $file->category->name ?? 'Tanpa Kategori' }}</span>
                                </div>
                                
                                <a href="{{ route('file.view', $file) }}" class="google-file-title" target="_blank">
                                    {{ $file->original_name }}
                                </a>

                                <div class="google-file-snippet">
                                    {{ $file->description ?: 'Tidak ada deskripsi tersedia untuk file ini. Anda dapat mengunduh atau melihat file menggunakan tautan di bawah.' }}
                                </div>

                                <div class="google-file-meta">
                                    <span>{{ strtoupper($file->extension) }}</span>
                                    <div class="dot"></div>
                                    <span>{{ round($file->size / 1024 / 1024, 2) }} MB</span>
                                    <div class="dot"></div>
                                    <span>{{ $file->created_at->format('d M Y') }}</span>
                                </div>

                                <div class="google-file-actions">
                                    <a href="{{ route('file.download', $file) }}" class="google-action-link">Unduh File</a>
                                    @if(strtolower($file->extension) === 'pdf' || in_array(strtolower($file->extension), ['jpg', 'jpeg', 'png', 'webp']))
                                        <a href="{{ route('file.view', $file) }}" target="_blank" class="google-action-link">Lihat Cepat</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Add Pagination if it exists --}}
                    @if($files->hasPages())
                        <div class="mt-8">
                            {{ $files->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <div class="empty-icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="empty-title">Belum Ada Berkas</h3>
                        <p class="empty-sub">
                            @if(request('category'))
                                Tidak ada berkas di kategori ini.
                            @else
                                Anda belum memiliki berkas yang dibagikan atau diunggah ke akun Anda.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Simple client-side search
        const searchInput = document.getElementById('inline-search');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                const items = document.querySelectorAll('[data-search-item]');
                
                items.forEach(item => {
                    const title = item.querySelector('.google-file-title').textContent.toLowerCase();
                    const snippet = item.querySelector('.google-file-snippet').textContent.toLowerCase();
                    if (title.includes(term) || snippet.includes(term)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    </script>
    @endpush
</x-app-layout>