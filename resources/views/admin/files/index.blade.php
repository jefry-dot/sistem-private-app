<x-app-layout>
<style>
/* ── ANIMATIONS ──────────────────────────────────── */
 @keyframes fadeUp {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}
 @keyframes fadeIn {
    from { opacity:0; } to { opacity:1; }
}

/* ── PAGE ────────────────────────────────────────── */
.file-index-page { animation: fadeUp 0.35s ease both; }

/* ── TOOLBAR ─────────────────────────────────────── */
.toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    margin-bottom: 1.25rem;
}

.toolbar-search {
    position: relative;
    flex: 1;
    min-width: 200px;
    max-width: 360px;
}

.toolbar-search input {
    width: 100%;
    padding: 0.5625rem 0.875rem 0.5625rem 2.25rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    color: var(--text-primary);
    background: var(--bg-surface);
    border: 1.5px solid var(--border-subtle);
    border-radius: 9px;
    outline: none;
    transition: all 0.18s;
}

.toolbar-search input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}

.toolbar-search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-tertiary);
    pointer-events: none;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: auto;
    flex-wrap: wrap;
}

/* Filter pills */
.filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.4375rem 0.875rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-secondary);
    background: var(--bg-surface);
    border: 1.5px solid var(--border-subtle);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
    white-space: nowrap;
}

.filter-pill:hover {
    border-color: var(--accent-muted);
    color: var(--accent);
    background: var(--accent-light);
}

.filter-pill.active {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

.filter-pill .pill-count {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    background: rgba(255,255,255,0.25);
    padding: 0.1rem 0.35rem;
    border-radius: 3px;
}

.filter-pill:not(.active) .pill-count {
    background: var(--bg-elevated);
    color: var(--text-tertiary);
}

/* Sort select */
.sort-select {
    padding: 0.4375rem 2rem 0.4375rem 0.75rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-secondary);
    background: var(--bg-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23aeaeb2' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.625rem center;
    border: 1.5px solid var(--border-subtle);
    border-radius: 8px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    transition: all 0.15s;
}

.sort-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}

/* ── BULK ACTION BAR ─────────────────────────────── */
.bulk-bar {
    display: none;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    background: var(--accent-light);
    border: 1.5px solid var(--accent-muted);
    border-radius: 10px;
    margin-bottom: 0.75rem;
    animation: fadeIn 0.2s ease;
}

.bulk-bar.visible { display: flex; }

.bulk-count {
    font-family: 'DM Mono', monospace;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--accent);
}

.bulk-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.bulk-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    transition: all 0.15s;
}

.bulk-btn-download {
    background: var(--accent);
    color: #fff;
}
.bulk-btn-download:hover {
    background: var(--accent-hover);
    box-shadow: 0 3px 8px rgba(79,70,229,0.3);
}

.bulk-btn-delete {
    background: var(--bg-surface);
    color: var(--danger);
    border: 1px solid var(--danger);
}
.bulk-btn-delete:hover {
    background: var(--danger);
    color: #fff;
}

.bulk-clear {
    margin-left: auto;
    font-size: 0.75rem;
    color: var(--text-tertiary);
    cursor: pointer;
    background: none;
    border: none;
    padding: 0.25rem;
    transition: color 0.15s;
}
.bulk-clear:hover { color: var(--text-primary); }

/* ── TABLE ───────────────────────────────────────── */
.file-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    /* subtle scroll shadow on right when overflowing */
    background:
        linear-gradient(to right, var(--bg-surface) 30%, rgba(255,255,255,0)),
        linear-gradient(to right, rgba(255,255,255,0), var(--bg-surface) 70%) 0 100%,
        radial-gradient(farthest-side at 0 50%, rgba(0,0,0,0.06), transparent),
        radial-gradient(farthest-side at 100% 50%, rgba(0,0,0,0.06), transparent) 0 100%;
    background-repeat: no-repeat;
    background-size: 40px 100%, 40px 100%, 14px 100%, 14px 100%;
    background-attachment: local, local, scroll, scroll;
}

table.file-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.file-table thead th {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    font-weight: 500;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.09em;
    padding: 0.75rem 1rem;
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border-subtle);
    white-space: nowrap;
    user-select: none;
}

.file-table thead th:first-child { border-radius: 0; padding-left: 1.25rem; }
.file-table thead th:last-child  { border-radius: 0; padding-right: 1.25rem; }

.file-table thead th.sortable {
    cursor: pointer;
}
.file-table thead th.sortable:hover { color: var(--accent); }

.file-table tbody tr {
    transition: background 0.12s;
    border-bottom: 1px solid var(--border-subtle);
    animation: fadeUp 0.3s ease both;
}

.file-table tbody tr:last-child { border-bottom: none; }
.file-table tbody tr:hover { background: var(--bg-elevated); }

.file-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    vertical-align: middle;
}

.file-table tbody td:first-child { padding-left: 1.25rem; }
.file-table tbody td:last-child  { padding-right: 1.25rem; }

/* File name cell */
.fn-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.fn-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-family: 'DM Mono', monospace;
    font-size: 0.5rem;
    font-weight: 700;
    letter-spacing: 0.04em;
}

.fn-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.01em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 260px;
    display: block;
    transition: color 0.15s;
}
tr:hover .fn-name { color: var(--accent); }

.fn-meta {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    color: var(--text-tertiary);
    margin-top: 0.125rem;
}

/* ── ROW ACTIONS ─────────────────────────────────── */
.row-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.375rem;
    opacity: 0;
    transition: opacity 0.15s;
}

tr:hover .row-actions { opacity: 1; }

/* Always show on mobile */
@media (max-width: 768px) {
    .row-actions { opacity: 1; }
}

.row-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 7px;
    border: 1px solid var(--border-subtle);
    background: var(--bg-surface);
    color: var(--text-secondary);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    flex-shrink: 0;
}

.row-btn:hover {
    border-color: var(--accent-muted);
    color: var(--accent);
    background: var(--accent-light);
}

.row-btn.danger:hover {
    border-color: var(--danger);
    color: var(--danger);
    background: rgba(239, 68, 68, 0.1);
}

/* ── MOBILE CARDS (< 640px) ──────────────────────── */
.mobile-file-list {
    display: none;
    flex-direction: column;
    gap: 0.5rem;
}

@media (max-width: 639px) {
    .file-table-wrap { display: none; }
    .mobile-file-list { display: flex; }
}

.mobile-file-card {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem 1rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-subtle);
    border-radius: 10px;
    transition: all 0.15s;
    animation: fadeUp 0.3s ease both;
}

.mobile-file-card:active {
    background: var(--bg-elevated);
}

.mobile-file-info { flex: 1; min-width: 0; }

.mobile-file-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0 0 0.25rem;
}

.mobile-file-meta {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    flex-wrap: wrap;
}

.mobile-file-meta span {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    color: var(--text-tertiary);
}

.mobile-dot {
    width: 2px;
    height: 2px;
    border-radius: 50%;
    background: var(--border-strong);
    display: inline-block;
}

/* ── EMPTY STATE ─────────────────────────────────── */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 5rem 2rem;
    text-align: center;
}

.empty-icon-wrap {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: var(--bg-elevated);
    border: 1px dashed var(--border-strong);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}

/* ── STATS ROW ───────────────────────────────────── */
.stats-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

.stat-pill {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: var(--bg-surface);
    border: 1px solid var(--border-subtle);
    border-radius: 8px;
    font-size: 0.8125rem;
}

.stat-pill-value {
    font-family: 'DM Mono', monospace;
    font-weight: 700;
    color: var(--text-primary);
    font-size: 0.875rem;
}

.stat-pill-label {
    color: var(--text-tertiary);
    font-size: 0.75rem;
}
</style>

<div class="file-index-page">

    {{-- ── PAGE HEADER ──────────────────────────────── --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <div>
            <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                Manajemen File
            </h1>
            <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                Kelola semua dokumen yang tersimpan di sistem.
            </p>
        </div>
        <a href="{{ route('admin.file.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Upload File
        </a>
    </div>

    {{-- ── SUCCESS ALERT ─────────────────────────────── --}}
    @if(session('success'))
    <div class="alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── STATS ROW ──────────────────────────────────── --}}
    <div class="stats-row">
        <div class="stat-pill">
            <span class="stat-pill-value">{{ number_format($stats['total_files'] ?? 0) }}</span>
            <span class="stat-pill-label">total file</span>
        </div>
        <div class="stat-pill">
            <span class="stat-pill-value">{{ round(($stats['total_size'] ?? 0) / 1024 / 1024, 1) }} MB</span>
            <span class="stat-pill-label">ukuran total</span>
        </div>
        <div class="stat-pill">
            <span class="stat-pill-value">{{ number_format($stats['total_downloads'] ?? 0) }}</span>
            <span class="stat-pill-label">total download</span>
        </div>
    </div>

    {{-- ── TOOLBAR ────────────────────────────────────── --}}
    <div class="toolbar">
        {{-- Search --}}
        <div class="toolbar-search">
            <span class="toolbar-search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                </svg>
            </span>
            <input
                type="text"
                id="tableSearch"
                placeholder="Cari nama file..."
                value="{{ request('search') }}"
                onkeydown="if(event.key==='Enter') applySearch(this.value)"
            >
        </div>

        {{-- Type filter pills --}}
        <div style="display:flex;gap:0.375rem;flex-wrap:wrap;">
            <a href="{{ request()->fullUrlWithQuery(['type' => null, 'page' => null]) }}"
               class="filter-pill {{ !request('type') ? 'active' : '' }}">
                Semua
            </a>
            @foreach(['pdf','docx','xlsx','pptx','zip','jpg'] as $ext)
            <a href="{{ request()->fullUrlWithQuery(['type' => $ext, 'page' => null]) }}"
               class="filter-pill {{ request('type') === $ext ? 'active' : '' }}">
                {{ strtoupper($ext) }}
            </a>
            @endforeach
        </div>

        {{-- Sort --}}
        <div class="toolbar-right">
            <select class="sort-select" onchange="location.href=this.value">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort','newest')==='newest' ? 'selected' : '' }}>Terbaru</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}" {{ request('sort')==='oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}"   {{ request('sort')==='name' ? 'selected' : '' }}>Nama A–Z</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'size']) }}"   {{ request('sort')==='size' ? 'selected' : '' }}>Ukuran ↓</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'downloads']) }}" {{ request('sort')==='downloads' ? 'selected' : '' }}>Terpopuler</option>
            </select>
        </div>
    </div>

    {{-- ── BULK ACTION BAR ────────────────────────────── --}}
    <form id="bulkForm" action="{{ route('bulk-download') }}" method="POST">
        @csrf
        <div class="bulk-bar" id="bulkBar">
            <span class="bulk-count"><span id="bulkCount">0</span> file dipilih</span>
            <div class="bulk-actions">
                <button type="submit" class="bulk-btn bulk-btn-download">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </button>
                <button type="button" class="bulk-btn bulk-btn-delete" onclick="confirmBulkDelete()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
            <button type="button" class="bulk-clear" onclick="clearSelection()">✕ Batal pilih</button>
        </div>

        {{-- ── MAIN CARD ────────────────────────────────── --}}
        <div class="card" style="overflow:hidden;">

            {{-- ── DESKTOP TABLE ──────────────────────────── --}}
            <div class="file-table-wrap">
                <table class="file-table">
                    <thead>
                        <tr>
                            <th style="width:3rem;">
                                <input type="checkbox" id="selectAll"
                                    style="width:15px;height:15px;border-radius:4px;accent-color:var(--accent);cursor:pointer;">
                            </th>
                            <th class="sortable" onclick="sortBy('name')">
                                Nama File
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-left:3px;vertical-align:middle;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </th>
                            <th>Kategori</th>
                            <th class="sortable" style="text-align:right;" onclick="sortBy('size')">Ukuran</th>
                            <th class="sortable" style="text-align:right;" onclick="sortBy('downloads')">Download</th>
                            <th class="sortable" style="text-align:right;" onclick="sortBy('newest')">Tanggal</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="fileTableBody">
                        @forelse($files as $i => $file)
                        @php
                            $ext = strtolower($file->extension);
                            [$iconBg, $iconColor, $iconText] = match(true) {
                                $ext === 'pdf'                      => ['rgba(239, 68, 68, 0.15)','#f87171','PDF'],
                                in_array($ext,['doc','docx'])       => ['rgba(59, 130, 246, 0.15)','#60a5fa','DOC'],
                                in_array($ext,['xls','xlsx','csv']) => ['rgba(34, 197, 94, 0.15)','#4ade80','XLS'],
                                in_array($ext,['ppt','pptx'])       => ['rgba(249, 115, 22, 0.15)','#fb923c','PPT'],
                                in_array($ext,['zip','rar','7z'])   => ['rgba(168, 85, 247, 0.15)','#c084fc','ZIP'],
                                in_array($ext,['jpg','jpeg','png','webp','gif']) => ['rgba(6, 182, 212, 0.15)','#22d3ee','IMG'],
                                default                             => ['var(--accent-light)','var(--accent)', strtoupper(substr($ext,0,3))],
                            };
                        @endphp
                        <tr style="animation-delay: {{ $i * 0.03 }}s;">
                            <td>
                                <input type="checkbox" name="files[]" value="{{ $file->id }}"
                                    class="file-cb"
                                    style="width:15px;height:15px;border-radius:4px;accent-color:var(--accent);cursor:pointer;">
                            </td>
                            <td>
                                <div class="fn-wrap">
                                    <div class="fn-icon" style="background:{{ $iconBg }};color:{{ $iconColor }};">
                                        {{ $iconText }}
                                    </div>
                                    <div>
                                        <span class="fn-name" title="{{ $file->original_name }}">{{ $file->original_name }}</span>
                                        <p class="fn-meta">{{ $file->uploader->name ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($file->category)
                                    <span class="badge badge-indigo">{{ $file->category->name }}</span>
                                @else
                                    <span style="color:var(--text-tertiary);font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <span style="font-family:'DM Mono',monospace;font-size:0.75rem;color:var(--text-secondary);">
                                    {{ round($file->size/1024/1024,2) }} MB
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="font-family:'DM Mono',monospace;font-size:0.75rem;color:var(--text-secondary);">
                                    {{ number_format($file->download_logs_count ?? 0) }}×
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="font-family:'DM Mono',monospace;font-size:0.7rem;color:var(--text-tertiary);">
                                    {{ $file->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="row-actions">
                                    {{-- Download --}}
                                    <a href="{{ route('file.download', $file) }}" target="_blank" class="row-btn" title="Download">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    {{-- Access --}}
                                    <a href="{{ route('admin.file.access', $file) }}" class="row-btn" title="Manage Access">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.file.destroy', $file) }}" method="POST" onsubmit="return confirm('Hapus file ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="row-btn danger" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding:0;">
                                <div class="empty-state">
                                    <div class="empty-icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--text-tertiary)" stroke-width="1.25">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 style="font-size:0.9375rem;font-weight:700;color:var(--text-primary);margin:0 0 0.375rem;">Tidak ada file</h3>
                                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0 0 1.25rem;">
                                        @if(request('search'))
                                            Tidak ada hasil untuk <strong>"{{ request('search') }}"</strong>
                                        @else
                                            Belum ada file yang diunggah.
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.file.create') }}" class="btn-primary">Upload Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── MOBILE CARDS ──────────────────────────────── --}}
            <div class="mobile-file-list" style="padding:0.75rem;">
                @forelse($files as $i => $file)
                @php
                    $ext = strtolower($file->extension);
                    [$iconBg, $iconColor, $iconText] = match(true) {
                        $ext === 'pdf'                      => ['rgba(239, 68, 68, 0.15)','#f87171','PDF'],
                        in_array($ext,['doc','docx'])       => ['rgba(59, 130, 246, 0.15)','#60a5fa','DOC'],
                        in_array($ext,['xls','xlsx','csv']) => ['rgba(34, 197, 94, 0.15)','#4ade80','XLS'],
                        in_array($ext,['ppt','pptx'])       => ['rgba(249, 115, 22, 0.15)','#fb923c','PPT'],
                        in_array($ext,['zip','rar','7z'])   => ['rgba(168, 85, 247, 0.15)','#c084fc','ZIP'],
                        in_array($ext,['jpg','jpeg','png','webp','gif']) => ['rgba(6, 182, 212, 0.15)','#22d3ee','IMG'],
                        default                             => ['var(--accent-light)','var(--accent)', strtoupper(substr($ext,0,3))],
                    };
                @endphp
                <div class="mobile-file-card" style="animation-delay:{{ $i * 0.04 }}s;">
                    <input type="checkbox" name="files[]" value="{{ $file->id }}"
                        class="file-cb"
                        style="width:16px;height:16px;border-radius:4px;accent-color:var(--accent);cursor:pointer;flex-shrink:0;">
                    <div class="fn-icon" style="background:{{ $iconBg }};color:{{ $iconColor }};width:38px;height:38px;border-radius:9px;font-family:'DM Mono',monospace;font-size:0.5rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        {{ $iconText }}
                    </div>
                    <div class="mobile-file-info">
                        <p class="mobile-file-name">{{ $file->original_name }}</p>
                        <div class="mobile-file-meta">
                            <span>{{ round($file->size/1024/1024,2) }} MB</span>
                            <span class="mobile-dot"></span>
                            <span>{{ $file->created_at->format('d M Y') }}</span>
                            <span class="mobile-dot"></span>
                            <span>{{ $file->download_logs_count ?? 0 }}× dl</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.375rem;flex-shrink:0;">
                        <a href="{{ route('admin.file.access', $file) }}" class="row-btn" title="Manage Access">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.file.destroy', $file) }}" method="POST" onsubmit="return confirm('Hapus?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="row-btn danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="var(--text-tertiary)" stroke-width="1.25">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:0.9375rem;font-weight:700;color:var(--text-primary);margin:0 0 0.375rem;">Belum ada file</h3>
                    <a href="{{ route('admin.file.create') }}" class="btn-primary" style="margin-top:0.75rem;">Upload Sekarang</a>
                </div>
                @endforelse
            </div>

            {{-- ── PAGINATION ─────────────────────────────────── --}}
            @if($files->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--border-subtle);">
                {{ $files->links() }}
            </div>
            @endif

        </div>
    </form>
</div>

<script>
    // ── BULK SELECTION ────────────────────────────────────────
    const selectAll = document.getElementById('selectAll');
    const bulkBar   = document.getElementById('bulkBar');
    const bulkCount = document.getElementById('bulkCount');

    function getChecked() {
        return [...document.querySelectorAll('.file-cb:checked')];
    }

    function syncBulkUI() {
        const checked = getChecked();
        const n = checked.length;
        if (n > 0) {
            bulkBar.classList.add('visible');
            bulkCount.textContent = n;
        } else {
            bulkBar.classList.remove('visible');
        }
        // Sync select-all state
        const all = document.querySelectorAll('.file-cb');
        if (selectAll) {
            selectAll.indeterminate = n > 0 && n < all.length;
            selectAll.checked = n > 0 && n === all.length;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', () => {
            document.querySelectorAll('.file-cb').forEach(cb => cb.checked = selectAll.checked);
            syncBulkUI();
        });
    }

    document.querySelectorAll('.file-cb').forEach(cb => {
        cb.addEventListener('change', syncBulkUI);
    });

    function clearSelection() {
        document.querySelectorAll('.file-cb').forEach(cb => cb.checked = false);
        if (selectAll) { selectAll.checked = false; selectAll.indeterminate = false; }
        syncBulkUI();
    }

    function confirmBulkDelete() {
        const n = getChecked().length;
        if (!n) return;
        if (confirm(`Hapus ${n} file terpilih? Tindakan ini tidak bisa dibatalkan.`)) {
            const form = document.getElementById('bulkForm');
            // Tambahkan input method DELETE secara dinamis
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Ubah action ke route bulk destroy
            form.action = "{{ route('admin.file.bulk-destroy') }}";
            form.submit();
        }
    }

    // ── SEARCH ───────────────────────────────────────────────
    function applySearch(val) {
        const url = new URL(window.location.href);
        if (val.trim()) url.searchParams.set('search', val.trim());
        else url.searchParams.delete('search');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // Debounced live search
    let searchTimer;
    document.getElementById('tableSearch').addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => applySearch(this.value), 600);
    });

    // ── SORT ─────────────────────────────────────────────────
    function sortBy(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
</script>

</x-app-layout>
