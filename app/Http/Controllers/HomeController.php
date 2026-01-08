<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the homepage/beranda
     */
    public function index()
    {
        $user = Auth::user();
        $followedRoomIds = $user->followedRoomIds();

        // If user follows rooms, filter posts by those rooms
        // Otherwise show all posts (for new users)
        $postsQuery = Post::with(['user', 'category', 'comments', 'likes', 'reshares', 'saves'])
            ->where('is_draft', false);

        if (!empty($followedRoomIds)) {
            $postsQuery->whereIn('category_id', $followedRoomIds);
        }

        $posts = $postsQuery->latest()->get();

        $categories = Category::all();

        // Mark which categories user follows
        $categories = $categories->map(function ($cat) use ($user) {
            $cat->is_followed = $user->isFollowingRoom($cat->id);
            return $cat;
        });

        return view('home', compact('posts', 'categories'));
    }
}
