{{-- resources/views/client/partials/search-results.blade.php --}}

@if($files->count() > 0)

    {{-- Select-all row --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding:0 0.25rem;">
        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
            <input
                type="checkbox"
                id="selectAllClient"
                style="width:15px;height:15px;border-radius:4px;accent-color:var(--accent);cursor:pointer;"
            >
            <span style="font-family:'DM Mono',monospace;font-size:0.625rem;color:var(--text-tertiary);letter-spacing:0.06em;text-transform:uppercase;user-select:none;">
                Pilih Semua
            </span>
        </label>
        <span style="font-family:'DM Mono',monospace;font-size:0.625rem;color:var(--text-tertiary);">
            {{ $files->total() }} dokumen ditemukan
        </span>
    </div>

    {{-- File list (Google Style) --}}
    <div class="google-file-list">
        @foreach($files as $i => $file)
        <div class="google-file-item" style="animation: slideUp 0.3s ease forwards; animation-delay: {{ $i * 0.04 }}s;">
            <div class="flex items-start gap-3">
                {{-- Checkbox --}}
                <div style="margin-top: 1.5rem;">
                    <input
                        type="checkbox"
                        name="files[]"
                        value="{{ $file->id }}"
                        class="file-checkbox-client"
                        style="width:16px;height:16px;border-radius:4px;accent-color:var(--accent);cursor:pointer;flex-shrink:0;"
                    >
                </div>

                <div class="flex-1 min-w-0">
                    <div class="google-file-path">
                        <span>My Files</span>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $file->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    
                    <a href="{{ route('file.view', $file) }}" class="google-file-title" target="_blank">
                        @if(!empty($query) && $query !== '*')
                            {!! preg_replace('/(' . preg_quote(e($query), '/') . ')/iu', '<mark style="background:rgba(79,70,229,0.12);color:var(--accent);border-radius:3px;padding:0 2px;">$1</mark>', e($file->original_name)) !!}
                        @else
                            {{ $file->original_name }}
                        @endif
                    </a>

                    <div class="google-file-snippet">
                        @if(!empty($query) && $query !== '*' && $file->description)
                            {!! preg_replace('/(' . preg_quote(e($query), '/') . ')/iu', '<mark style="background:rgba(79,70,229,0.12);color:var(--accent);border-radius:3px;padding:0 2px;">$1</mark>', e($file->description)) !!}
                        @else
                            {{ $file->description ?: 'No description available for this file. You can download or view the file using the links below.' }}
                        @endif
                    </div>

                    <div class="google-file-meta">
                        <span class="badge badge-indigo" style="font-size:0.6rem; padding: 0.1rem 0.3rem;">{{ strtoupper($file->extension) }}</span>
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
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($files->hasPages())
    <div style="margin-top:2rem;display:flex;justify-content:center;">
        {{ $files->appends(['q' => $query])->links() }}
    </div>
    @endif

@else
    {{-- Empty state --}}
    <div class="empty-state">
        <div class="empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
            </svg>
        </div>
        <h3 class="empty-title">Tidak ada hasil</h3>
        <p class="empty-sub">
            Tidak ada dokumen yang cocok dengan<br>
            <strong style="color:var(--text-primary);">"{{ $query }}"</strong>
        </p>
    </div>
@endif
