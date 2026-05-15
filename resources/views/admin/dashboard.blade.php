<x-app-layout>
    <x-slot name="header"></x-slot>

    <style>
        /* ── STAT CARDS (Mulia Grup Colorful Style) ───────── */
        .stat-card-ps {
            border-radius: 12px;
            padding: 1.5rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            min-height: 120px;
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
        }

        .stat-card-ps .value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card-ps .label {
            font-size: 0.875rem;
            font-weight: 700;
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            opacity: 0.9;
        }

        .stat-card-ps .icon-bg {
            position: absolute;
            right: -0.5rem;
            bottom: -0.5rem;
            opacity: 0.15;
            width: 100px;
            height: 100px;
            transform: rotate(-10deg);
        }

        .bg-orange-ps { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .bg-green-ps  { background: linear-gradient(135deg, #27ae60, #2ecc71); }
        .bg-purple-ps { background: linear-gradient(135deg, #8e44ad, #9b59b6); }
        .bg-red-ps    { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .bg-cyan-ps   { background: linear-gradient(135deg, #00c0ef, #3498db); }

        /* ── TABS ─────────────────────────────────────────── */
        .tab-btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 8px;
            background: var(--bg-elevated);
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
            box-shadow: 0 4px 12px rgba(94, 80, 161, 0.25);
        }

        /* ── RECENT ACTIVITIES ────────────────────────────── */
        .activity-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .activity-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            font-weight: 800;
            font-size: 0.875rem;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--bg-elevated);
        }

        .activity-list-item {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            transition: background 0.2s;
        }

        .activity-list-item:hover {
            background: var(--bg-elevated);
        }

        .activity-date {
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-tertiary);
            width: 80px;
            flex-shrink: 0;
            text-align: right;
        }

        .activity-icon {
            color: var(--ps-green);
        }

        .activity-text {
            font-size: 0.8125rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }
    </style>

    {{-- ── STATS ROW ────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
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
        <div class="lg:col-span-2 space-y-8">
            <div class="card p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                    <h3 id="chartTitle" class="section-label !before:hidden !p-0">Tren Unduhan</h3>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="updateChart('downloads')" id="btn-downloads" class="tab-btn active">Unduhan</button>
                        <button onclick="updateChart('views')" id="btn-views" class="tab-btn">Lihat Berkas</button>
                    </div>
                </div>

                <div style="height:340px;position:relative;" class="w-full">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Mulia Grup news --}}
                <div class="card overflow-hidden">
                    <div class="p-4 border-b border-subtle bg-elevated font-bold text-xs uppercase tracking-widest text-secondary" style="color: var(--text-secondary);">Berita Mulia Grup</div>
                    <div class="p-6">
                        <span class="text-[10px] font-mono text-tertiary" style="color: var(--text-tertiary);">{{ date('d/m/Y') }}</span>
                        <h4 class="text-accent font-bold text-sm mt-1" style="color: var(--accent);">Sistem Operasional</h4>
                        <p class="text-xs text-secondary mt-2 leading-relaxed" style="color: var(--text-secondary);">
                            Sistem Manajemen Privat Mulia Grup telah beroperasi sepenuhnya. Anda sekarang dapat mengelola dokumen secara aman dan membagikannya kepada klien di seluruh departemen.
                        </p>
                    </div>
                </div>

                {{-- System information --}}
                <div class="card overflow-hidden">
                    <div class="p-4 border-b border-subtle bg-elevated font-bold text-xs uppercase tracking-widest text-secondary" style="color: var(--text-secondary);">Informasi sistem</div>
                    <div class="p-6">
                        <div class="uppercase text-[10px] font-bold text-tertiary mb-4 tracking-widest" style="color: var(--text-tertiary);">Lingkungan</div>
                        <table class="w-full text-xs text-secondary" style="color: var(--text-secondary);">
                            <tr>
                                <td class="py-1 text-right pr-4 w-1/2 text-tertiary">Nama Sistem</td>
                                <td class="py-1 font-bold text-primary">Mulia Grup Private System</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4 text-tertiary">Total Ukuran File</td>
                                <td class="py-1 font-bold text-primary">{{ round($stats['total_size'] / 1024 / 1024, 2) }} MB</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4 text-tertiary">Total Dilihat</td>
                                <td class="py-1 font-bold text-primary">{{ number_format($stats['total_views']) }} kali</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-right pr-4 text-tertiary">Ukuran Upload Maks</td>
                                <td class="py-1 font-bold text-primary">50 MB</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: RECENT ACTIVITIES --}}
        <div>
            <div class="activity-card">
                <div class="activity-header">
                    Aktivitas terbaru
                </div>
                <div class="p-4 border-b border-subtle bg-elevated">
                    <select class="w-full text-xs bg-surface border-subtle rounded-lg py-2 px-3 focus:border-accent outline-none text-secondary" style="background: var(--bg-surface); color: var(--text-secondary); border: 1px solid var(--border-subtle);">
                        <option>Semua Aktivitas</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    @forelse($recentActivities as $activity)
                    <div class="activity-list-item">
                        <span class="activity-date">{{ $activity->created_at->format('d/m/Y') }}</span>
                        <div class="flex flex-col min-w-0">
                            <span class="activity-text font-bold text-accent" style="color: var(--accent);">{{ $activity->user->name ?? 'System' }}</span>
                            <span class="activity-text truncate text-secondary" style="color: var(--text-secondary);">{{ $activity->description }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-xs text-tertiary italic">
                        Tidak ada aktivitas tercatat.
                    </div>
                    @endforelse
                </div>
                <div class="p-4 bg-elevated border-t border-subtle">
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn-primary !w-full !justify-center !text-[10px] uppercase tracking-widest font-bold py-2.5">Lihat semua</a>
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

        function getChartThemeColors() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                text: isDark ? '#a1a1aa' : '#718096',
                grid: isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)',
            };
        }

        function initChart() {
            const colors = getChartThemeColors();
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
                            ticks: { 
                                stepSize: 1, 
                                font: { size: 11, family: "'DM Mono', monospace" },
                                color: colors.text
                            },
                            grid: { color: colors.grid }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                font: { size: 11, family: "'DM Mono', monospace" },
                                color: colors.text
                            }
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

        // Watch for theme changes
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class' && activityChart) {
                    const colors = getChartThemeColors();
                    activityChart.options.scales.y.ticks.color = colors.text;
                    activityChart.options.scales.y.grid.color = colors.grid;
                    activityChart.options.scales.x.ticks.color = colors.text;
                    activityChart.update();
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });

        document.addEventListener('DOMContentLoaded', initChart);
    </script>
    @endpush
</x-app-layout>