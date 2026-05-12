<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Category;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\DownloadLog;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $files = File::with(['category', 'users', 'groups'])->latest()->get();
        
        // Basic Statistics
        $stats = [
            'total_files' => File::count(),
            'total_users' => User::where('role', 'client')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'total_size' => File::sum('size'),
            'total_downloads' => DownloadLog::count(),
        ];

        // Download Trends (Last 7 Days)
        $downloadTrends = DownloadLog::select(
                DB::raw('DATE(downloaded_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('downloaded_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Prepare data for Chart.js
        $dates = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::now()->subDays($i)->format('d M');
            $counts[] = $downloadTrends->where('date', $date)->first()->total ?? 0;
        }

        // Recent Activities (Top 5)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Top 5 Downloaded Files
        $topFiles = File::withCount('downloadLogs')
            ->orderBy('download_logs_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'files' => $files,
            'stats' => $stats,
            'chartData' => [
                'labels' => $dates,
                'data' => $counts
            ],
            'recentActivities' => $recentActivities,
            'topFiles' => $topFiles
        ]);
    }

    public function createClient(Request $request)
    {
        // Logic for creating client
    }
}
