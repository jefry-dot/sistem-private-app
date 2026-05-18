<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Client Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Menunggu Persetujuan
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Klien-klien di bawah ini telah mendaftar mandiri dan membutuhkan verifikasi Anda sebelum dapat mengakses sistem.
                    </p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Daftar Client
                </a>
            </div>

            @if(session('success'))
                <div class="alert-success mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Klien</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th class="text-right">Waktu Pendaftaran</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-accent-light flex items-center justify-center text-accent font-bold text-[10px]">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-bold text-accent text-sm">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-secondary text-sm">{{ $user->username }}</td>
                                        <td class="text-secondary text-sm">{{ $user->email }}</td>
                                        <td class="text-right text-[10px] font-mono text-tertiary">{{ $user->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-right">
                                            <div class="row-actions">
                                                {{-- Approve --}}
                                                <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="row-btn" title="Setujui Klien" style="color:var(--success); border-color:rgba(16, 185, 129, 0.2); background:rgba(16, 185, 129, 0.05);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                {{-- Reject/Delete --}}
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak dan hapus pendaftaran ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="row-btn danger" title="Tolak Klien">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-12 text-tertiary italic">Tidak ada pendaftaran yang menunggu persetujuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
