<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        /* ── STAT CARDS (Mulia Grup Colorful Style) ───────── */
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
            <span class="label">Berkas</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM13 9V3.5L18.5 9H13z"/></svg>
        </div>

        {{-- Downloads --}}
        <div class="stat-card-ps bg-green-ps">
            <span class="value">{{ number_format($stats['total_downloads']) }}</span>
            <span class="label">Unduhan</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
        </div>

        {{-- Clients --}}
        <div class="stat-card-ps bg-purple-ps">
            <span class="value">{{ number_format($stats['total_users']) }}</span>
            <span class="label">Klien</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>

        {{-- Groups --}}
        <div class="stat-card-ps bg-red-ps">
            <span class="value">{{ number_format($stats['total_groups']) }}</span>
            <span class="label">Grup</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>

        {{-- System Users --}}
        <div class="stat-card-ps bg-cyan-ps">
            <span class="value">{{ number_format($stats['total_staff']) }}</span>
            <span class="label">Staf Sistem</span>
            <svg class="icon-bg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- LEFT: STATISTICS --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-strong rounded-sm p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                    <h3 id="chartTitle" class="text-sm font-bold text-gray-600 uppercase tracking-widest">Tren Unduhan</h3>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="updateChart('downloads')" id="btn-downloads" class="tab-btn active text-[10px] sm:text-xs">Unduhan</button>
                        <button onclick="updateChart('views')" id="btn-views" class="tab-btn text-[10px] sm:text-xs">Lihat Berkas</button>
                    </div>
                </div>

                <div style="height:340px;position:relative;" class="w-full">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                {{-- Mulia Grup news --}}
                <div class="bg-white border border-strong rounded-sm overflow-hidden">
                    <div class="p-4 border-b border-strong font-bold text-sm text-gray-600">Berita Mulia Grup</div>
                    <div class="p-6">
                        <span class="text-[11px] text-gray-400">{{ date('d/m/Y') }}</span>
                        <h4 class="text-ps-purple font-bold text-sm mt-1">Sistem Operasional</h4>
                        <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                            Sistem Manajemen Privat Mulia Grup telah beroperasi sepenuhnya. Anda sekarang dapat mengelola dokumen secara aman dan membagikannya kepada klien di seluruh departemen.
                        </p>
                    </div>
                </div>

                {{-- System information --}}
                <div class="bg-white border border-strong rounded-sm overflow-hidden">
                    <div class="p-4 border-b border-strong font-bold text-sm text-gray-600">Informasi sistem</div>
                    <div class="p-4">
                        <div class="uppercase text-[11px] font-bold text-gray-500 mb-4 tracking-widest">Lingkungan</div>
                        <table class="w-full text-xs text-gray-600">
                            <tr>
                                <td class="py-1 text-right pr-4 w-1/2">Nama Sistem</td>
                                <td class="py-1 font-bold">Mulia Grup Private System</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4">Total Ukuran File</td>
                                <td class="py-1 font-bold">{{ round($stats['total_size'] / 1024 / 1024, 2) }} MB</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4">Total Dilihat</td>
                                <td class="py-1 font-bold">{{ number_format($stats['total_views']) }} kali</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4">Ukuran Upload Maks</td>
                                <td class="py-1 font-bold">50 MB</td>
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
                    <span>Aktivitas terbaru</span>
                </div>
                <div class="p-4 border-b border-strong">
                    <select class="w-full text-sm border-strong rounded-sm py-1.5 focus:border-ps-purple outline-none">
                        <option>Semua Aktivitas</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    @forelse($recentActivities as $activity)
                    <div class="activity-list-item">
                        <span class="activity-date">{{ $activity->created_at->format('d/m/Y') }}</span>
                        <div class="flex flex-col min-w-0">
                            <span class="activity-text font-bold text-ps-purple">{{ $activity->user->name ?? 'System' }}</span>
                            <span class="activity-text truncate">{{ $activity->description }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-gray-400">
                        Tidak ada aktivitas tercatat.
                    </div>
                    @endforelse
                </div>
                <div class="p-4 flex justify-end">
                    <a href="{{ route('admin.activity-logs.index') }}" class="bg-ps-purple text-white text-xs font-bold py-2 px-6 rounded-sm hover:opacity-90 no-underline">Lihat semua</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        let activityChart;
        const chartData = {
            labels: {!! json_encode($chartData['labels']) !!},
            downloads: {!! json_encode($chartData['downloads']) !!},
            views: {!! json_encode($chartData['views']) !!}
        };

        function initChart() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            activityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Unduhan',
                        data: chartData.downloads,
                        borderColor: '#27ae60',
                        backgroundColor: 'rgba(39, 174, 96, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#27ae60'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { size: 11 } },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }

        function updateChart(type) {
            // Update Title
            document.getElementById('chartTitle').innerText = type === 'downloads' ? 'Tren Unduhan' : 'Tren Lihat Berkas';
            
            // Update Buttons
            document.getElementById('btn-downloads').classList.toggle('active', type === 'downloads');
            document.getElementById('btn-views').classList.toggle('active', type === 'views');

            // Update Data
            activityChart.data.datasets[0].label = type === 'downloads' ? 'Unduhan' : 'Lihat Berkas';
            activityChart.data.datasets[0].data = type === 'downloads' ? chartData.downloads : chartData.views;
            activityChart.data.datasets[0].borderColor = type === 'downloads' ? '#27ae60' : '#3498db';
            activityChart.data.datasets[0].backgroundColor = type === 'downloads' ? 'rgba(39, 174, 96, 0.1)' : 'rgba(52, 152, 219, 0.1)';
            activityChart.data.datasets[0].pointBackgroundColor = type === 'downloads' ? '#27ae60' : '#3498db';
            
            activityChart.update();
        }

        document.addEventListener('DOMContentLoaded', initChart);
    </script>
    @endpush
</x-app-layout>