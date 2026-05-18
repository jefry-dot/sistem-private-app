<x-app-layout>
<style>
 @keyframes fadeUp {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── EDIT PAGE LAYOUT ────────────────────────────── */
.edit-page {
    max-width: 800px;
    margin: 0 auto;
    animation: fadeUp 0.35s ease both;
}

/* ── TWO-COL FORM GRID ───────────────────────────── */
.edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 600px) {
    .edit-grid { grid-template-columns: 1fr; }
}

.form-group { display: flex; flex-direction: column; gap: 0.375rem; }
.form-group.full { grid-column: 1 / -1; }

.form-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.01em;
}

.form-label .req { color: var(--danger); margin-left: 2px; }

.form-input, .form-select, .form-textarea {
    padding: 0.625rem 0.875rem;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem;
    color: var(--text-primary);
    background: #fff;
    border: 1.5px solid var(--border-subtle);
    border-radius: 9px;
    outline: none;
    transition: all 0.18s;
    width: 100%;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
}

.form-input::placeholder, .form-textarea::placeholder {
    color: var(--text-tertiary);
}

.form-hint {
    font-size: 0.75rem;
    color: var(--text-tertiary);
    margin-top: 0.125rem;
}

.form-textarea { resize: vertical; min-height: 80px; }

.form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23aeaeb2' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    padding-right: 2.25rem;
    -webkit-appearance: none;
    cursor: pointer;
}

/* ── FILE INFO CARD (read-only) ──────────────────── */
.file-info-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    border-radius: 10px;
    margin-bottom: 0.25rem;
}

.file-info-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'DM Mono', monospace;
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    flex-shrink: 0;
}

.file-info-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
    margin: 0 0 0.25rem;
}

.file-info-meta {
    display: flex;
    gap: 0.625rem;
    align-items: center;
    flex-wrap: wrap;
}

.file-info-meta span {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    color: var(--text-tertiary);
}

.info-sep {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: var(--border-strong);
    display: inline-block;
}

/* ── ACCESS CONTROL ──────────────────────────────── */
.access-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px,1fr));
    gap: 0.5rem;
}

@media (max-width: 480px) {
    .access-grid { grid-template-columns: 1fr 1fr; }
}

.access-option {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5625rem 0.875rem;
    border: 1.5px solid var(--border-subtle);
    border-radius: 8px;
    cursor: pointer;
    background: var(--bg-elevated);
    transition: all 0.15s;
    user-select: none;
}

.access-option:has(input:checked) {
    border-color: var(--accent);
    background: var(--accent-light);
}

.access-option input {
    accent-color: var(--accent);
    width: 14px;
    height: 14px;
    flex-shrink: 0;
}

.access-option-label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── DANGER ZONE ─────────────────────────────────── */
.danger-zone {
    border: 1.5px solid #fecaca;
    border-radius: 10px;
    padding: 1.125rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.danger-zone-text h4 {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--danger);
    margin: 0 0 0.25rem;
}

.danger-zone-text p {
    font-size: 0.8rem;
    color: var(--text-tertiary);
    margin: 0;
}

.btn-danger {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: #fff;
    color: var(--danger);
    font-size: 0.8125rem;
    font-weight: 600;
    border: 1.5px solid #fecaca;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-danger:hover {
    background: #fef2f2;
    border-color: var(--danger);
    box-shadow: 0 2px 8px rgba(220,38,38,0.15);
}

/* ── SECTION DIVIDER ─────────────────────────────── */
.section-sep {
    height: 1px;
    background: var(--border-subtle);
    margin: 0 -1.5rem;
}

/* ── SUBMIT BAR ──────────────────────────────────── */
.submit-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 1.125rem 1.5rem;
    border-top: 1px solid var(--border-subtle);
    background: var(--bg-elevated);
    border-radius: 0 0 12px 12px;
    flex-wrap: wrap;
}

/* ── CHANGE INDICATOR ────────────────────────────── */
.change-pill {
    display: none;
    align-items: center;
    gap: 0.375rem;
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    font-weight: 600;
    color: #d97706;
    background: #fffbeb;
    border: 1px solid #fde68a;
    padding: 0.25rem 0.625rem;
    border-radius: 100px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.change-pill.visible { display: flex; }
</style>

<div class="edit-page">

    {{-- ── BREADCRUMB ───────────────────────────────── --}}
    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <a href="{{ route('admin.dashboard') }}"
           style="font-size:0.8rem;color:var(--text-tertiary);text-decoration:none;transition:color 0.15s;"
           onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-tertiary)'">
            Beranda
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--border-strong)" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.file.index') }}"
           style="font-size:0.8rem;color:var(--text-tertiary);text-decoration:none;transition:color 0.15s;"
           onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--text-tertiary)'">
            Daftar Berkas
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--border-strong)" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span style="font-size:0.8rem;font-weight:600;color:var(--text-primary);">Edit Berkas</span>

        {{-- Unsaved changes pill --}}
        <span class="change-pill" id="changePill">
            <span style="width:5px;height:5px;border-radius:50%;background:#d97706;display:inline-block;"></span>
            Perubahan belum disimpan
        </span>
    </div>

    {{-- ── VALIDATION ERRORS ────────────────────────── --}}
    @if($errors->any())
    <div style="display:flex;gap:0.75rem;padding:1rem 1.25rem;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;margin-bottom:1.25rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2" style="flex-shrink:0;margin-top:1px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <ul style="margin:0;padding-left:1rem;">
            @foreach($errors->all() as $error)
                <li style="font-size:0.8rem;color:#b91c1c;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.file.update', $file) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="card" style="overflow:hidden;">

            {{-- ── FILE INFO (read-only) ────────────────── --}}
            <div style="padding:1.5rem;">
                <p class="section-label" style="margin-bottom:1rem;">Berkas</p>

                @php
                    $ext = strtolower($file->extension);
                    [$iconBg, $iconColor, $iconText] = match(true) {
                        $ext === 'pdf'                      => ['#fef2f2','#dc2626','PDF'],
                        in_array($ext,['doc','docx'])       => ['#eff6ff','#2563eb','DOC'],
                        in_array($ext,['xls','xlsx','csv']) => ['#f0fdf4','#16a34a','XLS'],
                        in_array($ext,['ppt','pptx'])       => ['#fff7ed','#ea580c','PPT'],
                        in_array($ext,['zip','rar','7z'])   => ['#faf5ff','#7c3aed','ZIP'],
                        in_array($ext,['jpg','jpeg','png','webp']) => ['#f0f9ff','#0891b2','IMG'],
                        default => ['var(--accent-light)','var(--accent)', strtoupper(substr($ext,0,3))],
                    };
                @endphp

                <div class="file-info-card">
                    <div class="file-info-icon" style="background:{{ $iconBg }};color:{{ $iconColor }};">
                        {{ $iconText }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p class="file-info-name">{{ $file->original_name }}</p>
                        <div class="file-info-meta">
                            <span>{{ round($file->size/1024/1024,2) }} MB</span>
                            <span class="info-sep"></span>
                            <span>Diupload {{ $file->created_at->format('d M Y') }}</span>
                            <span class="info-sep"></span>
                            <span>{{ number_format($file->download_logs_count ?? 0) }}× diunduh</span>
                        </div>
                    </div>
                    <a href="{{ route('file.download', $file) }}" class="btn-secondary" style="padding:0.4rem 0.875rem;font-size:0.75rem;flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Unduh
                    </a>
                </div>

                <p class="form-hint" style="margin-top:0.5rem;">
                    File fisik tidak dapat diganti. Untuk mengganti file, hapus entri ini dan upload ulang.
                </p>
            </div>

            <div class="section-sep"></div>

            {{-- ── METADATA ──────────────────────────────── --}}
            <div style="padding:1.5rem;">
                <p class="section-label" style="margin-bottom:1rem;">Informasi Berkas</p>

                <div class="edit-grid">
                    <div class="form-group full">
                        <label class="form-label" for="display_name">
                            Nama Tampilan <span class="req">*</span>
                        </label>
                        <input
                            type="text"
                            id="display_name"
                            name="display_name"
                            class="form-input trackable"
                            value="{{ old('display_name', $file->display_name ?? $file->original_name) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="category_id">
                            Kategori <span class="req">*</span>
                        </label>
                        <select name="category_id" id="category_id" class="form-select trackable" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $file->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="expires_at">Kadaluarsa</label>
                        <input
                            type="date"
                            id="expires_at"
                            name="expires_at"
                            class="form-input trackable"
                            value="{{ old('expires_at', $file->expires_at ? $file->expires_at->format('Y-m-d') : '') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        >
                        <span class="form-hint">Kosongkan jika tidak ada batas waktu.</span>
                    </div>

                    <div class="form-group full">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-textarea trackable"
                            placeholder="Deskripsi singkat isi berkas..."
                            rows="3"
                        >{{ old('description', $file->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="section-sep"></div>

            {{-- ── ACCESS CONTROL ───────────────────────── --}}
            <div style="padding:1.5rem;">
                <p class="section-label" style="margin-bottom:0.5rem;">Hak Akses</p>
                <p class="form-hint" style="margin-bottom:1rem;">Centang klien atau grup yang boleh mengakses berkas ini.</p>

                {{-- User access --}}
                @if(isset($users) && $users->count())
                <p style="font-size:0.8125rem;font-weight:600;color:var(--text-primary);margin:0 0 0.625rem;">Klien Tertentu</p>
                <div class="access-grid" style="margin-bottom:1.25rem;">
                    @foreach($users as $user)
                    <label class="access-option">
                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="trackable"
                            {{ in_array($user->id, old('user_ids', $file->users->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <span class="access-option-label">{{ $user->name }}</span>
                    </label>
                    @endforeach
                </div>
                @endif

                {{-- Group access --}}
                @if(isset($groups) && $groups->count())
                <p style="font-size:0.8125rem;font-weight:600;color:var(--text-primary);margin:0 0 0.625rem;">Grup</p>
                <div class="access-grid">
                    @foreach($groups as $group)
                    <label class="access-option">
                        <input type="checkbox" name="group_ids[]" value="{{ $group->id }}" class="trackable"
                            {{ in_array($group->id, old('group_ids', $file->groups->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <span class="access-option-label">{{ $group->name }}</span>
                    </label>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── SUBMIT BAR ────────────────────────────── --}}
            <div class="submit-bar">
                <p style="font-size:0.75rem;color:var(--text-tertiary);margin:0;">
                    Terakhir diperbarui {{ $file->updated_at->diffForHumans() }}
                </p>
                <div style="display:flex;gap:0.625rem;">
                    <a href="{{ route('admin.file.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary" id="saveBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </div>
    </form>

    {{-- ── DANGER ZONE ──────────────────────────────── --}}
    <div style="margin-top:1.5rem;">
        <p class="section-label" style="margin-bottom:0.75rem;color:var(--danger);">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--danger);display:inline-block;margin-right:0.5rem;"></span>
            Zona Bahaya
        </p>
        <div class="danger-zone">
            <div class="danger-zone-text">
                <h4>Hapus Berkas Permanen</h4>
                <p>Berkas akan dihapus dari server dan tidak bisa dipulihkan. Semua log unduhan juga akan terhapus.</p>
            </div>
            <form action="{{ route('admin.file.destroy', $file) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus berkas ini secara permanen? Ini tidak bisa dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Berkas
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    // ── UNSAVED CHANGES TRACKER ───────────────────────────────
    const pill = document.getElementById('changePill');
    let isDirty = false;

    document.querySelectorAll('.trackable').forEach(el => {
        el.addEventListener('change', markDirty);
        el.addEventListener('input', markDirty);
    });

    function markDirty() {
        if (!isDirty) {
            isDirty = true;
            pill.classList.add('visible');
        }
    }

    document.getElementById('editForm').addEventListener('submit', () => {
        isDirty = false;
    });

    window.addEventListener('beforeunload', (e) => {
        if (isDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>

</x-app-layout>
