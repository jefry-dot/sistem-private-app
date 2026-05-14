<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Client: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-accent text-white flex items-center justify-center text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 style="font-size:1.5rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                            {{ $user->name }}
                        </h1>
                        <p style="font-size:0.875rem;color:var(--text-tertiary);margin:0;display:flex;align-items:center;gap:0.5rem;">
                            {{ $user->email }}
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            @if($user->status === 'active')
                                <span class="text-green-600 font-bold uppercase text-[10px]">Aktif</span>
                            @else
                                <span class="text-red-600 font-bold uppercase text-[10px]">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Client Info Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="card p-6 flex flex-col justify-between">
                    <div>
                        <p class="section-label mb-4">Informasi Akun</p>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] text-tertiary uppercase tracking-widest font-bold">Terdaftar Pada</p>
                                <p class="text-sm font-bold text-primary">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-tertiary uppercase tracking-widest font-bold">Grup Terkait</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse($user->groups as $group)
                                        <span class="badge badge-indigo">{{ $group->name }}</span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Tidak ada grup</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <p class="section-label">Statistik & Aktivitas</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-accent-light rounded-2xl border border-accent-muted">
                            <p class="text-[10px] text-accent font-bold uppercase tracking-widest">Total Unduhan</p>
                            <p class="text-3xl font-black text-accent mt-1">{{ number_format($user->downloadLogs->count()) }}</p>
                        </div>
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">Berkas Dapat Diakses</p>
                            <p class="text-3xl font-black text-emerald-700 mt-1">{{ number_format($files->count()) }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-[10px] text-tertiary font-bold uppercase tracking-widest mb-3">Aktivitas Terakhir</p>
                        <div class="space-y-2">
                            @forelse($user->downloadLogs()->with('file')->latest()->take(3)->get() as $log)
                                <div class="flex justify-between items-center text-xs p-3 bg-elevated rounded-xl border border-subtle">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span class="text-primary">Mendownload <span class="font-bold">{{ $log->file->original_name ?? 'Berkas Dihapus' }}</span></span>
                                    </div>
                                    <span class="text-tertiary">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div class="text-center py-4 bg-elevated rounded-xl border border-dashed border-subtle">
                                    <p class="text-[10px] text-tertiary italic">Belum ada aktivitas unduhan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accessible Files Table -->
            <div class="card overflow-hidden">
                <div class="p-6 border-b border-subtle bg-elevated">
                    <p class="section-label">Daftar Berkas yang Dapat Diakses</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Berkas</th>
                                <th>Kategori</th>
                                <th>Metode Akses</th>
                                <th class="text-right">Ukuran</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($files as $file)
                                <tr>
                                    <td>
                                        <span class="font-bold text-accent text-sm">{{ $file->original_name }}</span>
                                    </td>
                                    <td>
                                        @if($file->category)
                                            <span class="badge badge-indigo">{{ $file->category->name }}</span>
                                        @else
                                            <span class="text-gray-400 italic text-[10px]">Tanpa Kategori</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $direct = $file->users->contains($user->id);
                                            $viaGroup = $file->groups()->whereHas('users', function($q) use ($user) {
                                                $q->where('users.id', $user->id);
                                            })->exists();
                                        @endphp
                                        <div class="flex gap-1">
                                            @if($direct)
                                                <span class="text-[9px] font-bold uppercase py-0.5 px-2 bg-indigo-50 text-indigo-600 rounded-full border border-indigo-100">Individu</span>
                                            @endif
                                            @if($viaGroup)
                                                <span class="text-[9px] font-bold uppercase py-0.5 px-2 bg-purple-50 text-purple-600 rounded-full border border-purple-100">Grup</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right text-xs font-mono text-tertiary">{{ round($file->size / 1024 / 1024, 2) }} MB</td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('file.view', $file) }}" target="_blank" class="text-accent hover:underline font-bold text-[10px] uppercase tracking-wider">Preview</a>
                                            <a href="{{ route('file.download', $file) }}" class="text-accent hover:underline font-bold text-[10px] uppercase tracking-wider">Unduh</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-tertiary italic">Tidak ada berkas yang dibagikan ke klien ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
