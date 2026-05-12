<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('q');
        $categoryId = $request->input('category');
        
        $groupIds = $user->groups->pluck('id');
        
        // Base Query
        $filesQuery = File::query();

        // If NOT admin, restrict access to shared files only
        if ($user->role !== 'admin') {
            $filesQuery->where(function($q) use ($user, $groupIds) {
                $q->whereHas('users', function($uq) use ($user) {
                    $uq->where('users.id', $user->id);
                })->orWhereHas('groups', function($gq) use ($groupIds) {
                    $gq->whereIn('groups.id', $groupIds);
                });
            });
        }

        // Apply Search Filter (Ignore if query is '*' which means 'all')
        if ($query && $query !== '*') {
            $filesQuery->where(function($q) use ($query) {
                $q->where('original_name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('extension', 'like', "%{$query}%");
            });
        }

        // Apply Category Filter
        if ($categoryId) {
            $filesQuery->where('category_id', $categoryId);
        }

        $files = $filesQuery->with(['category'])
                            ->latest()
                            ->paginate(10);

        // Fetch categories that have files accessible to this user
        $categories = Category::whereHas('files', function($q) use ($user, $groupIds) {
            $q->whereHas('users', function($uq) use ($user) {
                $uq->where('users.id', $user->id);
            })->orWhereHas('groups', function($gq) use ($groupIds) {
                $gq->whereIn('groups.id', $groupIds);
            });
        })->withCount(['files' => function($q) use ($user, $groupIds) {
             $q->whereHas('users', function($uq) use ($user) {
                $uq->where('users.id', $user->id);
            })->orWhereHas('groups', function($gq) use ($groupIds) {
                $gq->whereIn('groups.id', $groupIds);
            });
        }])->get();

        if ($request->ajax()) {
            return view('client.partials.search-results', compact('files', 'query'))->render();
        }

        return view('client.dashboard', compact('files', 'categories', 'query'));
    }
}
