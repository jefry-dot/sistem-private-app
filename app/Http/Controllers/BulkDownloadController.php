<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\DownloadLog;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BulkDownloadController extends Controller
{
    public function download(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'exists:files,id',
        ]);

        $files = File::whereIn('id', $request->files)->get();

        // Check permission: user must have access to all selected files
        foreach ($files as $file) {
            $hasAccess = Auth::user()->role === 'admin' ||
                        $file->users()->where('user_id', Auth::id())->exists() ||
                        $file->groups()->whereHas('users', function($q) {
                            $q->where('users.id', Auth::id());
                        })->exists();

            if (!$hasAccess) {
                return redirect()->back()->with('error', 'You do not have access to some of the selected files.');
            }
        }

        $zip = new ZipArchive;
        $fileName = 'files_download_' . time() . '.zip';
        $tempPath = storage_path('app/temp/' . $fileName);

        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($tempPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filePath = storage_path('app/private/' . $file->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file->original_name);
                }
            }
            $zip->close();
        }

        ActivityLogger::log('bulk_download', 'Downloaded ' . $files->count() . ' files as ZIP');

        foreach ($files as $file) {
            DownloadLog::create([
                'user_id' => Auth::id(),
                'file_id' => $file->id,
                'ip_address' => $request->ip(),
            ]);
        }

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
