<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PAGE HEADER ──────────────────────────────── --}}
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                <div>
                    <h1 style="font-size:1.375rem;font-weight:700;letter-spacing:-0.03em;color:var(--text-primary);margin:0 0 0.25rem;">
                        Log Aktivitas
                    </h1>
                    <p style="font-size:0.8125rem;color:var(--text-tertiary);margin:0;">
                        Pantau semua perubahan dan interaksi penting yang terjadi di dalam sistem.
                    </p>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Aksi</th>
                                    <th>Deskripsi</th>
                                    <th class="text-right">Alamat IP</th>
                                    <th class="text-right">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-accent-light text-accent flex items-center justify-center text-[9px] font-bold">
                                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                                </div>
                                                <span class="font-bold text-primary text-sm">{{ $log->user->name ?? 'Sistem' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-[9px] font-mono border border-gray-200">
                                                {{ strtoupper($log->action) }}
                                            </span>
                                        </td>
                                        <td class="text-secondary text-sm max-w-md overflow-hidden text-ellipsis">{{ $log->description }}</td>
                                        <td class="text-right text-[10px] font-mono text-tertiary">{{ $log->ip_address }}</td>
                                        <td class="text-right text-[10px] font-mono text-tertiary">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-12 text-tertiary italic">Belum ada log aktivitas yang tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
