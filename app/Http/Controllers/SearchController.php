<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Perform search for posts and users
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return view('search', [
                'query' => $query,
                'posts' => collect(),
                'users' => collect(),
            ]);
        }

        // Search posts
        $posts = Post::with(['user', 'category'])
            ->where('is_draft', false)
            ->where(function ($q) use ($query) {
                $q->where('content', 'like', "%{$query}%")
                    ->orWhere('title', 'like', "%{$query}%");
            })
            ->latest()
            ->take(20)
            ->get();

        // Search users
        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%");
        })
            ->where('is_profile_hidden', false)
            ->take(10)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'posts' => $posts,
                'users' => $users,
            ]);
        }

        return view('search', compact('query', 'posts', 'users'));
    }

    /**
     * Search posts only (API)
     */
    public function searchPosts(Request $request)
    {
        $query = $request->get('q', '');

        $posts = Post::with(['user', 'category'])
            ->where('is_draft', false)
            ->where(function ($q) use ($query) {
                $q->where('content', 'like', "%{$query}%")
                    ->orWhere('title', 'like', "%{$query}%");
            })
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }

    /**
     * Search users only (API)
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%");
        })
            ->where('is_profile_hidden', false)
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
}
