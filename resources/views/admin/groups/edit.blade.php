<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Grup: ') }} {{ $group->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Edit Grup: {{ $group->name }}
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Perbarui informasi grup atau ubah daftar anggota yang tergabung.
                    </p>
                </div>
                <a href="{{ route('admin.groups.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Batal
                </a>
            </div>

            <div class="card overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.groups.update', $group) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label class="section-label mb-2">Nama Grup</label>
                                <input type="text" name="name" value="{{ $group->name }}" required class="block w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.75rem 1rem; border-radius: 12px; outline: none; transition: border-color 0.2s;" placeholder="Misal: Departemen Keuangan, Client VIP..." autofocus>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label class="section-label mb-2">Deskripsi (Opsional)</label>
                                <textarea name="description" class="block w-full" style="background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border-subtle); padding: 0.75rem 1rem; border-radius: 12px; outline: none; min-height: 100px;" placeholder="Penjelasan singkat mengenai grup ini...">{{ $group->description }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <label class="section-label mb-4">Daftar Anggota Grup</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-64 overflow-y-auto p-4 bg-elevated rounded-2xl border border-subtle" style="background: var(--bg-elevated); border: 1px solid var(--border-subtle);">
                                    @foreach($users as $user)
                                        <label class="flex items-center gap-3 p-3 bg-surface rounded-xl border border-subtle cursor-pointer hover:border-accent transition-all">
                                            <input type="checkbox" name="users[]" value="{{ $user->id }}" class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent accent-accent"
                                                @if($group->users->contains($user->id)) checked @endif>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-primary" style="color: var(--text-primary);">{{ $user->name }}</span>
                                                <span class="text-[10px] text-tertiary" style="color: var(--text-tertiary);">{{ $user->email }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('users')" />
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-subtle flex justify-end">
                            <button type="submit" class="btn-primary !px-10 !py-3 !text-sm !rounded-xl shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
