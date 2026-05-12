<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <span>{{ __('Dashboard Overview') }}</span>
            <span class="text-[10px] font-mono text-gray-400 bg-gray-100 px-2 py-1 rounded">Update: {{ date('d M Y') }}</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Row 1: Quick Stats (Compact) --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Files</p>
                    <h4 class="text-xl font-extrabold text-indigo-950">1,284</h4>
                </div>
            </div>
            <div class="card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Clients</p>
                    <h4 class="text-xl font-extrabold text-indigo-950">42</h4>
                </div>
            </div>
            <div class="card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Storage</p>
                    <h4 class="text-xl font-extrabold text-indigo-950">84%</h4>
                </div>
            </div>
            <div class="card p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Views</p>
                    <h4 class="text-xl font-extrabold text-indigo-950">2.4k</h4>
                </div>
            </div>
        </div>

        {{-- Row 2: Main Grid (Two Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Left Column: Main Files / Welcome (8 cols) --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Welcome Banner (More Compact) --}}
                <div class="card p-6 bg-indigo-950 text-white border-none relative overflow-hidden flex items-center justify-between">
                    <div class="relative z-10">
                        <h2 class="text-xl font-extrabold tracking-tight">Welcome, {{ Auth::user()->name }}</h2>
                        <p class="text-indigo-200 text-xs mt-1">Anda memiliki <span class="font-bold text-white">5 file baru</span> yang dibagikan hari ini.</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin.file.create') }}" class="btn-primary !bg-white !text-indigo-950 !py-1.5 !px-4 !text-[11px]">Upload File</a>
                            <button class="btn-secondary !border-indigo-400 !text-indigo-100 !py-1.5 !px-4 !text-[11px] hover:!bg-indigo-900">Lihat Laporan</button>
                        </div>
                    </div>
                    <div class="hidden sm:block opacity-20 transform rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>

                {{-- Table with fixed height / scroll --}}
                <div class="card overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <div class="section-label">Daftar File Terbaru</div>
                        <input type="text" placeholder="Cari file..." class="text-[10px] border border-gray-200 rounded-lg px-3 py-1 outline-none focus:border-indigo-500">
                    </div>
                    <div class="max-h-[340px] overflow-y-auto no-scrollbar">
                        <table class="data-table !border-none">
                            <thead class="sticky top-0 z-10">
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th class="hidden sm:table-cell">Kategori</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=1; $i<=10; $i++)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div class="truncate">
                                                <p class="text-sm font-bold text-indigo-950 truncate max-w-[150px] md:max-w-xs">Laporan Tahunan Mulia Group 202{{ $i }}.pdf</p>
                                                <p class="text-[10px] text-gray-400">Uploaded 2 hours ago</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                        <span class="badge badge-indigo">Finance</span>
                                    </td>
                                    <td class="text-right">
                                        <button class="text-indigo-600 hover:text-indigo-900 font-bold text-[11px]">Manage</button>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                        <a href="#" class="text-[10px] font-bold text-gray-400 hover:text-indigo-600 uppercase tracking-widest">Lihat Semua Dokumen</a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Activity / Logs (4 cols) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Recent Activity Feed --}}
                <div class="card overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <div class="section-label">Log Aktivitas</div>
                    </div>
                    <div class="p-4 space-y-4 max-h-[520px] overflow-y-auto no-scrollbar">
                        @for($i=1; $i<=8; $i++)
                        <div class="flex gap-3 relative {{ $i < 8 ? 'after:content-[\'\'] after:absolute after:left-[11px] after:top-7 after:bottom-[-12px] after:w-[1.5px] after:bg-gray-100' : '' }}">
                            <div class="w-6 h-6 rounded-full bg-indigo-100 border-4 border-white flex items-center justify-center shrink-0 z-10">
                                <div class="w-1.5 h-1.5 rounded-full bg-indigo-600"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-indigo-950 leading-tight">Admin uploaded "Surat_Kontrak_{{ $i }}.docx"</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Today, 10:45 AM</p>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="p-4 bg-indigo-50/50 text-center">
                        <button class="btn-secondary !w-full !py-2 !text-[10px] !bg-white">Buka Semua Log</button>
                    </div>
                </div>

                {{-- Quick Actions / Shortcuts --}}
                <div class="card p-5">
                    <div class="section-label mb-4">Akses Cepat</div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="#" class="p-3 rounded-xl border border-dashed border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all text-center group">
                            <div class="text-indigo-600 group-hover:scale-110 transition-transform mb-1 flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <p class="text-[10px] font-bold text-gray-600">Klien Baru</p>
                        </a>
                        <a href="#" class="p-3 rounded-xl border border-dashed border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all text-center group">
                            <div class="text-indigo-600 group-hover:scale-110 transition-transform mb-1 flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-[10px] font-bold text-gray-600">Setting</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
