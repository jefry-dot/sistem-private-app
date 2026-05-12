<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        /* ── STAT CARDS (ProjectSend Colorful Style) ───────── */
        .stat-card-ps {
            border-radius: 4px;
            padding: 1.5rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            min-height: 120px;
        }

        .stat-card-ps .value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card-ps .label {
            font-size: 1.125rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .stat-card-ps .icon-bg {
            position: absolute;
            right: 0.5rem;
            bottom: 0.5rem;
            opacity: 0.2;
            width: 80px;
            height: 80px;
        }

        .bg-orange-ps { background-color: var(--ps-orange); }
        .bg-green-ps  { background-color: var(--ps-green); }
        .bg-purple-ps { background-color: var(--ps-purple); }
        .bg-red-ps    { background-color: var(--ps-red); }
        .bg-cyan-ps   { background-color: var(--ps-cyan); }

        /* ── TABS ─────────────────────────────────────────── */
        .tab-btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 4px;
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            cursor: pointer;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #fff;
        }

        /* ── RECENT ACTIVITIES ────────────────────────────── */
        .activity-card {
            background: #fff;
            border: 1px solid var(--border-strong);
            border-radius: 4px;
        }

        .activity-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-strong);
            font-weight: 700;
            font-size: 0.875rem;
            color: #4a5568;
        }

        .activity-list-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .activity-date {
            font-size: 0.75rem;
            font-weight: 700;
            color: #4a5568;
            width: 80px;
            flex-shrink: 0;
        }

        .activity-icon {
            color: var(--ps-green);
        }

        .activity-text {
            font-size: 0.8125rem;
            color: #4a5568;
        }
    </style>

    {{-- ── STATS ROW ────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
        {{-- Files --}}
        <div class="stat-card-ps bg-orange-ps">
            <span class="value">{{ number_format($stats['total_files']) }}</span>
            <span class="label">Files</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM13 9V3.5L18.5 9H13z"/></svg>
        </div>

        {{-- Downloads --}}
        <div class="stat-card-ps bg-green-ps">
            <span class="value">{{ number_format($stats['total_downloads']) }}</span>
            <span class="label">Downloads</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
        </div>

        {{-- Clients --}}
        <div class="stat-card-ps bg-purple-ps">
            <span class="value">{{ number_format($stats['total_users']) }}</span>
            <span class="label">Clients</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>

        {{-- Groups --}}
        <div class="stat-card-ps bg-red-ps">
            <span class="value">2</span>
            <span class="label">Groups</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>

        {{-- System Users --}}
        <div class="stat-card-ps bg-cyan-ps">
            <span class="value">1</span>
            <span class="label">System Users</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- LEFT: STATISTICS --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-strong rounded-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-widest">Statistics</h3>
                    <div class="flex gap-2">
                        <button class="tab-btn active">15 days</button>
                        <button class="tab-btn">30 days</button>
                        <button class="tab-btn">60 days</button>
                    </div>
                </div>

                <div style="height:340px;position:relative;">
                    <canvas id="downloadChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                {{-- ProjectSend news --}}
                <div class="bg-white border border-strong rounded-sm overflow-hidden">
                    <div class="p-4 border-b border-strong font-bold text-sm text-gray-600">ProjectSend news</div>
                    <div class="p-6">
                        <span class="text-[11px] text-gray-400">27/10/2022</span>
                        <h4 class="text-ps-purple font-bold text-sm mt-1">New release: r1605</h4>
                        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                            Hi everyone! A new release is out. r1605 fixes bugs introduced in the previous version while also adding a few small tweaks. Please update when...
                        </p>
                    </div>
                </div>

                {{-- System information --}}
                <div class="bg-white border border-strong rounded-sm overflow-hidden">
                    <div class="p-4 border-b border-strong font-bold text-sm text-gray-600">System information</div>
                    <div class="p-4">
                        <div class="uppercase text-[11px] font-bold text-gray-500 mb-4 tracking-widest">Software</div>
                        <table class="w-full text-xs text-gray-600">
                            <tr>
                                <td class="py-1 text-right pr-4 w-1/2">Version</td>
                                <td class="py-1 font-bold">r1605</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4">Default upload max. size</td>
                                <td class="py-1 font-bold">2048 mb.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: RECENT ACTIVITIES --}}
        <div>
            <div class="activity-card">
                <div class="activity-header flex items-center justify-between">
                    <span>Recent activities</span>
                </div>
                <div class="p-4 border-b border-strong">
                    <select class="w-full text-sm border-strong rounded-sm py-1.5 focus:border-ps-purple outline-none">
                        <option>ProjectSend was updated</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    @forelse($recentActivities as $activity)
                    <div class="activity-list-item">
                        <span class="activity-date">{{ $activity->created_at->format('d/m/Y') }}</span>
                        <svg class="activity-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="activity-text">{{ $activity->description }}</span>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-gray-400">
                        No activities recorded.
                    </div>
                    @endforelse
                </div>
                <div class="p-4 flex justify-end">
                    <button class="bg-ps-purple text-white text-xs font-bold py-2 px-6 rounded-sm hover:opacity-90">View all</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('downloadChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [
                        {
                            label: 'Uploads by users',
                            data: {!! json_encode($chartData['data']) !!},
                            borderColor: '#0288d1',
                            borderWidth: 2,
                            fill: false,
                            tension: 0,
                            pointRadius: 3
                        },
                        {
                            label: 'Uploads by clients',
                            data: [0,0,0,0,0,0,0,0,1,7,0],
                            borderColor: '#7cb342',
                            borderWidth: 2,
                            fill: false,
                            tension: 0,
                            pointRadius: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'top',
                            align: 'start',
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                font: { size: 10 }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: true }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>