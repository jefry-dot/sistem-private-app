<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Akses File') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Akses File: {{ $file->original_name }}
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Tentukan siapa saja yang berhak melihat dan mengunduh dokumen ini.
                    </p>
                </div>
                <a href="{{ route('admin.file.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="card overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.file.access.update', $file) }}">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                            <!-- Select Clients -->
                            <div>
                                <p class="section-label mb-4">Berikan Akses ke Client</p>
                                <div class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto p-4 bg-elevated rounded-2xl border border-subtle" style="background: var(--bg-elevated); border: 1px solid var(--border-subtle);">
                                    @foreach($clients as $client)
                                        <label class="flex items-center gap-3 p-3 bg-surface rounded-xl border border-subtle cursor-pointer hover:border-accent transition-all">
                                            <input type="checkbox" name="users[]" value="{{ $client->id }}" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent accent-accent"
                                                @if($file->users->contains($client->id)) checked @endif>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-primary" style="color: var(--text-primary);">{{ $client->name }}</span>
                                                <span class="text-[10px] text-tertiary" style="color: var(--text-tertiary);">{{ $client->email }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Select Groups -->
                            <div>
                                <p class="section-label mb-4">Berikan Akses ke Grup</p>
                                <div class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto p-4 bg-elevated rounded-2xl border border-subtle" style="background: var(--bg-elevated); border: 1px solid var(--border-subtle);">
                                    @foreach($groups as $group)
                                        <label class="flex items-center gap-3 p-3 bg-surface rounded-xl border border-subtle cursor-pointer hover:border-accent transition-all">
                                            <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500 accent-purple-600"
                                                @if($file->groups->contains($group->id)) checked @endif>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-primary" style="color: var(--text-primary);">{{ $group->name }}</span>
                                                <span class="text-[10px] text-tertiary" style="color: var(--text-tertiary);">{{ $group->users_count ?? $group->users->count() }} Client Terdaftar</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-subtle flex justify-end">
                            <button type="submit" class="btn-primary !px-10 !py-3 !text-sm !rounded-xl shadow-lg">
                                Perbarui Hak Akses
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
