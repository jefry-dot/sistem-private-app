<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('users')->get();
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $users = User::where('role', 'client')->get();
        return view('admin.groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $group = Group::create($request->only('name', 'description'));
        if ($request->has('users')) {
            $group->users()->sync($request->users);
        }

        ActivityLogger::log('create_group', "Membuat grup: {$group->name}", $group);

        return redirect()->route('admin.groups.index')->with('success', 'Grup berhasil dibuat.');
    }

    public function edit(Group $group)
    {
        $users = User::where('role', 'client')->get();
        $group->load('users');
        return view('admin.groups.edit', compact('group', 'users'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $group->update($request->only('name', 'description'));
        $group->users()->sync($request->users ?? []);

        ActivityLogger::log('update_group', "Memperbarui grup: {$group->name}", $group);

        return redirect()->route('admin.groups.index')->with('success', 'Grup berhasil diperbarui.');
    }

    public function destroy(Group $group)
    {
        ActivityLogger::log('delete_group', "Menghapus grup: {$group->name}", $group);
        $group->delete();

        return redirect()->route('admin.groups.index')->with('success', 'Grup berhasil dihapus.');
    }
}
