<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Group;
use App\Models\Category;
use App\Models\DownloadLog;
use App\Notifications\FileSharedNotification;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::with(['category', 'uploader'])->withCount('downloadLogs');

        // Search
        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        // Type Filter
        if ($request->filled('type')) {
            $query->where('extension', $request->type);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'name'   => $query->orderBy('original_name', 'asc'),
            'size'   => $query->orderBy('size', 'desc'),
            'downloads' => $query->orderBy('download_logs_count', 'desc'),
            default  => $query->latest(),
        };

        $files = $query->paginate(15)->withQueryString();

        $stats = [
            'total_files' => File::count(),
            'total_size' => File::sum('size'),
            'total_downloads' => DownloadLog::count(),
        ];

        return view('admin.files.index', compact('files', 'stats'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->where('status', 'active')->get();
        $groups = Group::all();
        $categories = Category::all();
        
        return view('admin.files.create', compact('clients', 'groups', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:51200', // Max 50MB
                'display_name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'users' => 'nullable|array',
                'users.*' => 'exists:users,id',
                'groups' => 'nullable|array',
                'groups.*' => 'exists:groups,id',
                'expires_at' => 'nullable|date|after:today',
            ]);

            $uploadedFile = $request->file('file');
            
            if (!$uploadedFile->isValid()) {
                return back()->withErrors(['file' => 'File tidak valid atau rusak saat diupload.']);
            }

            $originalName = $uploadedFile->getClientOriginalName();
            $extension = $uploadedFile->getClientOriginalExtension();
            $size = $uploadedFile->getSize();
            
            $path = $uploadedFile->store('files', 'private');

            if (!$path) {
                return back()->withErrors(['file' => 'Gagal menyimpan file ke disk. Periksa izin folder storage.']);
            }

            $file = File::create([
                'original_name' => $originalName,
                'display_name' => $request->display_name ?? $originalName,
                'description' => $request->description,
                'file_path' => $path,
                'extension' => $extension,
                'size' => $size,
                'visibility' => 'private',
                'uploaded_by' => auth()->id(),
                'category_id' => null,
                'expires_at' => $request->expires_at,
            ]);

            if ($request->has('users')) {
                $file->users()->attach($request->users);
            }

            if ($request->has('groups')) {
                $file->groups()->attach($request->groups);
            }

            ActivityLogger::log('upload_file', "Uploaded file: {$originalName}", $file);

            // Notifications logic
            try {
                if ($request->has('users')) {
                    $notifiableUsers = User::whereIn('id', $request->users)->get();
                    Notification::send($notifiableUsers, new FileSharedNotification($file));
                }

                if ($request->has('groups')) {
                    $groupUsers = User::whereHas('groups', function($q) use ($request) {
                        $q->whereIn('groups.id', $request->groups);
                    })->get();
                    Notification::send($groupUsers, new FileSharedNotification($file));
                }
            } catch (\Exception $e) {
                \Log::warning("Gagal mengirim notifikasi: " . $e->getMessage());
                // Jangan batalkan upload jika hanya notifikasi yang gagal
            }

            return back()->with('success', 'File berhasil diupload.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error("Error upload file: " . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function edit(File $file)
    {
        $file->load(['users', 'groups']);
        $categories = Category::all();
        $users = User::where('role', 'client')->where('status', 'active')->get();
        $groups = Group::all();

        return view('admin.files.edit', compact('file', 'categories', 'users', 'groups'));
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $file->update([
            'display_name' => $request->display_name,
            'description' => $request->description,
            'expires_at' => $request->expires_at,
        ]);

        // Sync access
        $file->users()->sync($request->user_ids ?? []);
        $file->groups()->sync($request->group_ids ?? []);

        ActivityLogger::log('update_file', "Updated metadata/access for file: {$file->original_name}", $file);

        return redirect()->route('admin.file.index')->with('success', 'Perubahan file berhasil disimpan.');
    }

    public function download(File $file, Request $request)
    {
        $user = auth()->user();
        
        $hasAccess = $user->role === 'admin' ||
                    $file->users()->where('user_id', $user->id)->exists() ||
                    $file->groups()->whereHas('users', function($q) use ($user) {
                        $q->where('users.id', $user->id);
                    })->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }

        // Log the download
        DownloadLog::create([
            'user_id' => $user->id,
            'file_id' => $file->id,
            'ip_address' => $request->ip(),
        ]);

        ActivityLogger::log('download_file', "Downloaded file: {$file->original_name}", $file);

        if (!Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'File not found on storage.');
        }

        return Storage::disk('private')->download($file->file_path, $file->original_name);
    }

    public function view(File $file)
    {
        $user = auth()->user();
        
        $hasAccess = $user->role === 'admin' ||
                    $file->users()->where('user_id', $user->id)->exists() ||
                    $file->groups()->whereHas('users', function($q) use ($user) {
                        $q->where('users.id', $user->id);
                    })->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        $path = Storage::disk('private')->path($file->file_path);
        $mimeType = Storage::disk('private')->mimeType($file->file_path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"'
        ]);
    }

    public function destroy(File $file)
    {
        ActivityLogger::log('delete_file', "Deleted file: {$file->original_name}", $file);
        
        if (Storage::disk('private')->exists($file->file_path)) {
            Storage::disk('private')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }

    public function manageAccess(File $file)
    {
        $clients = User::where('role', 'client')->where('status', 'active')->get();
        $groups = Group::all();
        $file->load('users', 'groups');
        
        return view('admin.files.access', compact('file', 'clients', 'groups'));
    }

    public function updateAccess(Request $request, File $file)
    {
        $request->validate([
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $file->users()->sync($request->users ?? []);
        $file->groups()->sync($request->groups ?? []);

        ActivityLogger::log('update_file_access', "Updated access for file: {$file->original_name}", $file);

        return redirect()->route('admin.dashboard')->with('success', 'File access updated successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'exists:files,id',
        ]);

        $files = File::whereIn('id', $request->files)->get();

        foreach ($files as $file) {
            if (Storage::disk('private')->exists($file->file_path)) {
                Storage::disk('private')->delete($file->file_path);
            }
            $file->delete();
        }

        ActivityLogger::log('bulk_delete_files', "Deleted " . count($request->files) . " files.");

        return back()->with('success', count($request->files) . ' file berhasil dihapus.');
    }
}
