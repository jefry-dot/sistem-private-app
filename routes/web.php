<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\BulkDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Apply 'active' middleware to all authenticated routes except those explicitly excluded if needed
Route::middleware(['auth', 'active'])->group(function () {
    
    // Role-based dashboard redirect
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('client.dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/client', [AdminController::class, 'createClient'])->name('client.store');
        
        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/pending', [UserController::class, 'pending'])->name('users.pending');
        Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::post('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Groups
        Route::resource('groups', GroupController::class);

        // Categories
        Route::resource('categories', CategoryController::class);

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

        // File Management (New & Existing)
        Route::get('/files', [FileController::class, 'index'])->name('file.index');
        Route::get('/file/create', [FileController::class, 'create'])->name('file.create');
        Route::post('/file', [FileController::class, 'store'])->name('file.store');
        Route::get('/file/{file}/edit', [FileController::class, 'edit'])->name('file.edit');
        Route::put('/file/{file}', [FileController::class, 'update'])->name('file.update');
        Route::delete('/file/{file}', [FileController::class, 'destroy'])->name('file.destroy');
        Route::delete('/files/bulk', [FileController::class, 'bulkDestroy'])->name('file.bulk-destroy');
        Route::get('/file/{file}/access', [FileController::class, 'manageAccess'])->name('file.access');
        Route::post('/file/{file}/access', [FileController::class, 'updateAccess'])->name('file.access.update');
    });

    // Client Routes
    Route::middleware('client')->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    });

    // User Profile / Details (New)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    });

    // Shared File Download & View Route
    Route::get('/file/{file}/download', [FileController::class, 'download'])->name('file.download');
    Route::get('/file/{file}/view', [FileController::class, 'view'])->name('file.view');
    Route::post('/bulk-download', [BulkDownloadController::class, 'download'])->name('bulk-download');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
