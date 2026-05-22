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
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::with(['category', 'uploader'])->withCount('downloadLogs');

        // Search
        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%')
                  ->orWhere('display_name', 'like', '%' . $request->search . '%');
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
                'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,webp,zip,rar,txt', // Max 50MB
                'display_name' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'groups' => 'nullable|array',
                'groups.*' => 'exists:groups,id',
                'expires_at' => 'nullable|date|after:today',
            ], [
                'file.mimes' => 'Jenis file ini dilarang karena alasan keamanan.',
                'file.max' => 'Ukuran file tidak boleh lebih dari 50MB.',
                'category_id.required' => 'Pilih kategori file.',
            ]);

            $uploadedFile = $request->file('file');
            
            if (!$uploadedFile->isValid()) {
                return back()->withErrors(['file' => 'File tidak valid atau rusak saat diupload.']);
            }

            $originalName = $uploadedFile->getClientOriginalName();
            $displayName = $request->display_name ?? $originalName;

            // Global uniqueness check (across all categories)
            $duplicate = File::where('original_name', $originalName)
                ->orWhere('display_name', $displayName)
                ->first();

            if ($duplicate) {
                $errorMessage = "Gagal: Berkas dengan nama '" . ($duplicate->original_name === $originalName ? $originalName : $displayName) . "' sudah ada di sistem (Kategori: " . $duplicate->category->name . ").";
                session()->flash('error', $errorMessage);
                throw \Illuminate\Validation\ValidationException::withMessages(['file' => $errorMessage]);
            }

            $extension = $uploadedFile->getClientOriginalExtension();
            $size = $uploadedFile->getSize();
            
            $path = $uploadedFile->store('files', 'private');

            if (!$path) {
                return back()->withErrors(['file' => 'Gagal menyimpan file ke disk.']);
            }

            $file = File::create([
                'original_name' => $originalName,
                'display_name' => $displayName,
                'description' => $request->description,
                'file_path' => $path,
                'extension' => $extension,
                'size' => $size,
                'visibility' => 'private',
                'uploaded_by' => auth()->id(),
                'category_id' => $request->category_id,
                'expires_at' => $request->expires_at,
            ]);

            if ($request->has('groups')) {
                $file->groups()->attach($request->groups);
            }

            ActivityLogger::log('upload_file', "Mengupload berkas: {$originalName} (Kategori: {$file->category->name})", $file);

            // Notifications logic
            try {
                if ($request->has('groups')) {
                    $groupUsers = User::whereHas('groups', function($q) use ($request) {
                        $q->whereIn('groups.id', $request->groups);
                    })->get();
                    Notification::send($groupUsers, new FileSharedNotification($file));
                }
            } catch (\Exception $e) {
                \Log::warning("Gagal mengirim notifikasi: " . $e->getMessage());
            }

            if ($request->expectsJson()) {
                session()->flash('success', 'Berkas berhasil diupload.');
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Berkas berhasil diupload.');

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
            'display_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('files', 'display_name')->ignore($file->id),
                Rule::unique('files', 'original_name')->ignore($file->id),
            ],
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
        ], [
            'display_name.unique' => 'Nama tampilan sudah digunakan oleh berkas lain.',
            'category_id.required' => 'Pilih kategori file.',
        ]);

        $file->update([
            'display_name' => $request->display_name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'expires_at' => $request->expires_at,
        ]);

        // Sync access
        $file->users()->sync($request->user_ids ?? []);
        $file->groups()->sync($request->group_ids ?? []);

        ActivityLogger::log('update_file', "Memperbarui metadata/akses berkas: {$file->original_name}", $file);

        return redirect()->route('admin.file.index')->with('success', 'Perubahan berkas berhasil disimpan.');
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
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Log the download
        DownloadLog::create([
            'user_id' => $user->id,
            'file_id' => $file->id,
            'ip_address' => $request->ip(),
        ]);

        ActivityLogger::log('download_file', "Mengunduh berkas: {$file->original_name}", $file);

        if (!Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'Berkas tidak ditemukan di penyimpanan.');
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
            abort(403, 'Aksi tidak diizinkan.');
        }

        if (!Storage::disk('private')->exists($file->file_path)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        ActivityLogger::log('view_file', "Melihat berkas: {$file->original_name}", $file);

        $path = Storage::disk('private')->path($file->file_path);
        $mimeType = Storage::disk('private')->mimeType($file->file_path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"'
        ]);
    }

    public function destroy(File $file)
    {
        ActivityLogger::log('delete_file', "Menghapus berkas: {$file->original_name}", $file);
        
        if (Storage::disk('private')->exists($file->file_path)) {
            Storage::disk('private')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'Berkas berhasil dihapus.');
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

        ActivityLogger::log('update_file_access', "Memperbarui akses berkas: {$file->original_name}", $file);

        return redirect()->route('admin.dashboard')->with('success', 'Akses berkas berhasil diperbarui.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'exists:files,id',
        ]);

        $files = File::whereIn('id', $request->input('files'))->get();

        foreach ($files as $file) {
            if (Storage::disk('private')->exists($file->file_path)) {
                Storage::disk('private')->delete($file->file_path);
            }
            $file->delete();
        }

        ActivityLogger::log('bulk_delete_files', "Menghapus " . count($request->input('files')) . " berkas sekaligus.");

        return back()->with('success', count($request->input('files')) . ' berkas berhasil dihapus.');
    }
}
