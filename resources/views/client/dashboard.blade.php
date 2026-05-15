<x-app-layout>
    <style>
        /* ── CLASSIC SEARCH LAYOUT ────────────────────────── */
        .search-container {
            max-width: 800px;
            margin: 1rem auto 2rem;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .search-header {
            margin-bottom: 2.5rem;
        }

        .search-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: -0.05em;
            margin-bottom: 0.5rem;
        }

        .search-header p {
            color: var(--text-tertiary);
            font-size: 1rem;
        }

        .search-box-wrapper {
            position: relative;
            margin-bottom: 3rem;
        }

        .classic-search-input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 3.5rem;
            font-size: 1.125rem;
            border: 1px solid var(--border-strong);
            border-radius: 99px;
            background: var(--bg-surface);
            color: var(--text-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            outline: none;
        }

        .classic-search-input:focus {
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border-color: var(--accent-muted);
        }

        .search-icon-large {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-tertiary);
        }

        /* ── RESULTS ────────────────────────────────────── */
        .results-container {
            max-width: 800px;
            margin: 0 auto 5rem;
        }

        .category-filter-chips {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-chip {
            padding: 0.5rem 1.25rem;
            border-radius: 99px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .filter-chip:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-light);
        }

        .filter-chip.active {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        /* ── EMPTY STATE ─────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-tertiary);
        }
    </style>

    <div class="search-container">
        <div class="search-header">
            <img src="{{ asset('logo-2.png') }}" alt="Mulia Grup" style="width: 80px; height: auto; margin: 0 auto 1.5rem; display: block;">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.04em; margin-bottom: 0.5rem;">Mulia Grup</h1>
            <p>Akses berkas dan dokumen Anda secara aman.</p>
        </div>

        <div class="search-box-wrapper">
            <svg class="search-icon-large" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
            </svg>
            <input type="text" id="classic-search" class="classic-search-input" placeholder="Cari dokumen..." autofocus>
        </div>

        <div class="category-filter-chips">
            <a href="{{ route('client.dashboard') }}" class="filter-chip {{ !request('category') ? 'active' : '' }}">Semua Berkas</a>
            @foreach($categories as $category)
                <a href="{{ route('client.dashboard', ['category' => $category->id]) }}" class="filter-chip {{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="results-container">
        <div id="file-results-list">
            @if($files->count() > 0)
                <div class="google-file-list">
                    @foreach($files as $file)
                        <div class="google-file-item" data-search-item>
                            <div class="google-file-path">
                                <span>Berkas</span>
                                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $file->category->name ?? 'Umum' }}</span>
                            </div>
                            
                            <a href="{{ route('file.view', $file) }}" class="google-file-title" target="_blank">
                                {{ $file->display_name ?: $file->original_name }}
                            </a>

                            <div class="google-file-snippet">
                                {{ $file->description ?: 'Dokumen ini tersedia untuk diunduh dan dilihat secara aman.' }}
                            </div>

                            <div class="google-file-meta">
                                <span>{{ strtoupper($file->extension) }}</span>
                                <div class="dot"></div>
                                <span>{{ round($file->size / 1024 / 1024, 2) }} MB</span>
                                <div class="dot"></div>
                                <span>{{ $file->created_at->format('d M Y') }}</span>
                            </div>

                            <div class="google-file-actions">
                                <a href="{{ route('file.download', $file) }}" class="google-action-link">Download</a>
                                @if(in_array(strtolower($file->extension), ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                                    <a href="{{ route('file.view', $file) }}" target="_blank" class="google-action-link">Pratinjau</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($files->hasPages())
                    <div class="mt-12">
                        {{ $files->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <p>Tidak ada berkas yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        const searchInput = document.getElementById('classic-search');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                const items = document.querySelectorAll('[data-search-item]');
                let found = false;
                
                items.forEach(item => {
                    const title = item.querySelector('.google-file-title').textContent.toLowerCase();
                    const snippet = item.querySelector('.google-file-snippet').textContent.toLowerCase();
                    if (title.includes(term) || snippet.includes(term)) {
                        item.style.display = 'flex';
                        found = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                const emptyState = document.querySelector('.empty-state');
                if (!found && term !== '') {
                    if (!emptyState) {
                        const container = document.getElementById('file-results-list');
                        const div = document.createElement('div');
                        div.className = 'empty-state';
                        div.innerHTML = '<p>Tidak ada berkas yang cocok dengan pencarian Anda.</p>';
                        container.appendChild(div);
                    } else {
                        emptyState.style.display = 'block';
                    }
                } else if (emptyState) {
                    emptyState.style.display = 'none';
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
