<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'client')->latest()->get();
        $groups = \App\Models\Group::all(); // Added for the create form
        return view('admin.users.index', compact('users', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'client',
            'status' => 'active',
        ]);

        if ($request->has('groups')) {
            $user->groups()->attach($request->groups);
        }

        ActivityLogger::log('create_user', "Created new client: {$user->name}", $user);

        return redirect()->back()->with('success', "Client {$user->name} created successfully.");
    }

    public function pending()
    {
        $users = User::where('status', 'pending')->latest()->get();
        return view('admin.users.pending', compact('users'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'active']);
        ActivityLogger::log('approve_user', "Approved user: {$user->name}", $user);
        return redirect()->back()->with('success', "User {$user->name} approved.");
    }

    public function deactivate(User $user)
    {
        $user->update(['status' => 'inactive']);
        ActivityLogger::log('deactivate_user', "Deactivated user: {$user->name}", $user);
        return redirect()->back()->with('success', "User {$user->name} deactivated.");
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        ActivityLogger::log('activate_user', "Activated user: {$user->name}", $user);
        return redirect()->back()->with('success', "User {$user->name} activated.");
    }

    public function show(User $user)
    {
        if ($user->role !== 'client') {
            abort(404);
        }

        $user->load(['groups', 'downloadLogs.file']);
        
        // Get files directly assigned to user OR via their groups
        $files = \App\Models\File::whereHas('users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->orWhereHas('groups', function($q) use ($user) {
            $q->whereIn('groups.id', $user->groups->pluck('id'));
        })->with('category')->latest()->get();

        return view('admin.users.show', compact('user', 'files'));
    }

    public function destroy(User $user)
    {
        ActivityLogger::log('delete_user', "Deleted user: {$user->name}", $user);
        $user->delete();
        return redirect()->back()->with('success', "User deleted.");
    }
}
