<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-primary">My Files</h1>
            <div class="flex items-center gap-4 w-full sm:w-auto">
                {{-- Quick search --}}
                <div class="relative flex-1 sm:flex-none">
                    <input type="text" id="inline-search" class="text-sm border-subtle rounded-lg pl-9 pr-4 py-1.5 focus:border-accent outline-none w-full sm:w-64" placeholder="Search files...">
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
    </style>

    <div class="portal-layout">
        {{-- Sidebar Categories --}}
        <aside class="flex flex-col gap-6">
            <div class="section-card p-4">
                <p class="section-label mb-4">Categories</p>
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('client.dashboard') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                        <span>All Files</span>
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
                                    <span>My Files</span>
                                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>{{ $file->category->name ?? 'Uncategorized' }}</span>
                                </div>
                                
                                <a href="{{ route('file.view', $file) }}" class="google-file-title" target="_blank">
                                    {{ $file->original_name }}
                                </a>

                                <div class="google-file-snippet">
                                    {{ $file->description ?: 'No description available for this file. You can download or view the file using the links below.' }}
                                </div>

                                <div class="google-file-meta">
                                    <span>{{ strtoupper($file->extension) }}</span>
                                    <div class="dot"></div>
                                    <span>{{ round($file->size / 1024 / 1024, 2) }} MB</span>
                                    <div class="dot"></div>
                                    <span>{{ $file->created_at->format('d M Y') }}</span>
                                </div>

                                <div class="google-file-actions">
                                    <a href="{{ route('file.download', $file) }}" class="google-action-link">Download File</a>
                                    @if(strtolower($file->extension) === 'pdf')
                                        <a href="{{ route('file.view', $file) }}" target="_blank" class="google-action-link">Quick View</a>
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
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="empty-title">No files found</h3>
                        <p class="empty-sub">We couldn't find any files matching your criteria.</p>
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