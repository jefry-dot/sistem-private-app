<x-app-layout>
<style>
    /* ── UPLOAD PAGE ──────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse-ring {
        0%   { transform: scale(1);   opacity: 0.6; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    @keyframes bounce-in {
        0%   { transform: scale(0.8); opacity: 0; }
        70%  { transform: scale(1.05); }
        100% { transform: scale(1);   opacity: 1; }
    }

    .upload-page {
        max-width: 800px;
        margin: 0 auto;
        animation: fadeUp 0.4s ease both;
    }

    /* ── DROPZONE ─────────────────────────────────────────────── */
    .dropzone {
        position: relative;
        border: 2px dashed var(--border-strong);
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        background: var(--bg-elevated);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .dropzone::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(30, 27, 75, 0.04), transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .dropzone:hover,
    .dropzone.dragover {
        border-color: var(--accent);
        background: #fff;
        transform: translateY(-2px);
    }

    .dropzone:hover::before,
    .dropzone.dragover::before {
        opacity: 1;
    }

    .dropzone.dragover {
        border-style: solid;
        box-shadow: 0 0 0 4px rgba(30, 27, 75, 0.1);
    }

    .dropzone-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--accent-light);
        border: 1px solid var(--accent-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .dropzone:hover .dropzone-icon,
    .dropzone.dragover .dropzone-icon {
        background: var(--accent);
        transform: scale(1.1) rotate(-5deg);
    }

    .dropzone:hover .dropzone-icon svg,
    .dropzone.dragover .dropzone-icon svg {
        color: #fff;
    }

    .dropzone-icon svg {
        width: 28px;
        height: 28px;
        color: var(--accent);
        transition: color 0.3s ease;
    }

    .dropzone-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.02em;
        margin: 0 0 0.5rem;
    }

    .dropzone-sub {
        font-size: 0.875rem;
        color: var(--text-tertiary);
        margin: 0 0 1.5rem;
    }

    .dropzone-hint {
        margin-top: 1rem;
        font-family: 'DM Mono', monospace;
        font-size: 0.65rem;
        color: var(--text-tertiary);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* ── FILE PREVIEW ─────────────────────────────────────────── */
    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--accent-light);
        border: 1px solid var(--accent-muted);
        border-radius: 12px;
        margin-top: 1rem;
        animation: bounce-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    /* ── FORM ELEMENTS ────────────────────────────────────────── */
    .form-section-card {
        background: #fff;
        border: 1px solid var(--border-subtle);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    .access-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--border-subtle);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .access-option:hover {
        border-color: var(--accent-muted);
        background: var(--bg-base);
    }

    .access-option:has(input:checked) {
        border-color: var(--accent);
        background: var(--accent-light);
        box-shadow: 0 2px 8px rgba(30, 27, 75, 0.05);
    }

    /* ── SUBMIT BAR ──────────────────────────────────────────── */
    .submit-bar {
        position: sticky;
        bottom: 1.5rem;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(12px);
        padding: 1rem 1.5rem;
        border-radius: 100px;
        border: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        z-index: 10;
    }
</style>

<div class="upload-page">

    {{-- ── HEADER ────────────────────────────────────────────── --}}
    <div style="display:flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            <div class="section-label mb-2">Manajemen File</div>
            <h1 style="font-size:1.75rem; font-weight:800; letter-spacing:-0.04em; color:var(--accent);">Upload Dokumen</h1>
            <p style="font-size:0.875rem; color:var(--text-secondary);">Bagikan file secara aman ke klien Mulia Grup.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
    <div style="padding:1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:12px; margin-bottom:1.5rem; animation: fadeUp 0.3s ease;">
        @foreach($errors->all() as $error)
            <div style="color:#b91c1c; font-size:0.8125rem; display:flex; gap:0.5rem; align-items:center;">
                <span style="width:4px; height:4px; border-radius:50%; background:#dc2626;"></span>
                {{ $error }}
            </div>
        @endforeach
    </div>
    @endif

    <form id="uploadForm" action="{{ route('admin.file.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ── DROPZONE SECTION ──────────────────────────────── --}}
        <div class="dropzone" id="dropzone" onclick="document.getElementById('file-input').click();">
            <div class="dropzone-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <h3 class="dropzone-title">Klik atau Seret File ke Sini</h3>
            <p class="dropzone-sub">Ukuran maksimal file adalah <strong>50MB</strong></p>
            <div id="file-preview-list"></div>
            <p class="dropzone-hint">Mendukung PDF, Word, Excel, dan Gambar</p>
        </div>

        <input type="file" id="file-input" name="file" class="hidden" onchange="handleFileSelect(this)">

        {{-- ── ACCESS SECTION ────────────────────────────────── --}}
        <div class="form-section-card">
            <p class="section-label mb-4">Berikan Akses Ke</p>
            
            <div class="space-y-6">
                {{-- Klien Individu --}}
                <div>
                    <p style="font-size:0.75rem; font-weight:700; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem;">Individu</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($clients as $client)
                        <label class="access-option">
                            <input type="checkbox" name="users[]" value="{{ $client->id }}" style="accent-color:var(--accent);">
                            <span class="truncate text-xs font-bold text-gray-700">{{ $client->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Grup --}}
                @if($groups->count() > 0)
                <div>
                    <p style="font-size:0.75rem; font-weight:700; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem;">Grup / Departemen</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($groups as $group)
                        <label class="access-option">
                            <input type="checkbox" name="groups[]" value="{{ $group->id }}" style="accent-color:var(--accent);">
                            <span class="truncate text-xs font-bold text-gray-700">{{ $group->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ── ACTION BAR ────────────────────────────────────── --}}
        <div class="submit-bar">
            <span class="hidden sm:inline text-[11px] font-medium text-gray-400 italic">File akan disimpan di folder privat terenkripsi.</span>
            <button type="submit" class="btn-primary !px-8 !py-3 !rounded-full shadow-lg">
                Upload Sekarang
            </button>
        </div>
    </form>
</div>

{{-- ── OVERLAY PROGRESS ────────────────────────────────── --}}
<div class="progress-overlay" id="progressOverlay">
    <div class="progress-card">
        <div class="progress-icon">
            <svg class="animate-bounce" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        </div>
        <h3 class="font-bold text-gray-900">Sedang Mengupload...</h3>
        <p class="text-xs text-gray-500 mt-1">Harap tidak menutup halaman ini</p>
        <div class="progress-bar-track mt-4">
            <div class="progress-bar-fill" id="progressBar"></div>
        </div>
        <p class="progress-label" id="progressLabel">0%</p>
    </div>
</div>

<script>
    function handleFileSelect(input) {
        const preview = document.getElementById('file-preview-list');
        if (input.files.length > 0) {
            const file = input.files[0];
            preview.innerHTML = `
                <div class="file-preview-item">
                    <div class="file-preview-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="text-left overflow-hidden">
                        <p class="text-sm font-bold text-indigo-950 truncate">${file.name}</p>
                        <p class="text-[10px] text-gray-500 uppercase font-mono">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                </div>
            `;
        }
    }

    // Drag and Drop Logic
    const zone = document.getElementById('dropzone');
    ['dragenter', 'dragover'].forEach(e => {
        zone.addEventListener(e, (ev) => { ev.preventDefault(); zone.classList.add('dragover'); });
    });
    ['dragleave', 'dragend', 'drop'].forEach(e => {
        zone.addEventListener(e, (ev) => { ev.preventDefault(); zone.classList.remove('dragover'); });
    });
    zone.addEventListener('drop', (ev) => {
        const input = document.getElementById('file-input');
        input.files = ev.dataTransfer.files;
        handleFileSelect(input);
    });

    // Form Progress
    document.getElementById('uploadForm').addEventListener('submit', function() {
        document.getElementById('progressOverlay').classList.add('active');
        let val = 0;
        const bar = document.getElementById('progressBar');
        const lbl = document.getElementById('progressLabel');
        const interval = setInterval(() => {
            val += Math.random() * 8;
            if (val > 95) clearInterval(interval);
            bar.style.width = Math.min(val, 95) + '%';
            lbl.innerText = Math.round(Math.min(val, 95)) + '%';
        }, 200);
    });
</script>
</x-app-layout>
