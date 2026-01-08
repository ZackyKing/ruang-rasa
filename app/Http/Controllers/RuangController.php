<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    /**
     * Show a specific ruang/category page
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check if user follows this room
        $category->is_followed = $user ? $user->isFollowingRoom($category->id) : false;

        // Get posts for this category
        $posts = Post::with(['user', 'category', 'likes', 'comments', 'reshares'])
            ->where('category_id', $category->id)
            ->where('is_draft', false)
            ->latest()
            ->get();

        return view('ruang', compact('category', 'posts'));
    }

    /**
     * Toggle follow on a room/category
     */
    public function toggleFollow(Category $category)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $isFollowing = $user->isFollowingRoom($category->id);

        if ($isFollowing) {
            $user->followedRooms()->detach($category->id);
            $following = false;
        } else {
            $user->followedRooms()->attach($category->id);
            $following = true;
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'message' => $following
                ? "Kamu sekarang mengikuti {$category->name}"
                : "Berhenti mengikuti {$category->name}",
        ]);
    }

    /**
     * Store a new custom room/category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        // Generate slug from name
        $slug = \Str::slug($request->name);

        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Random emoji for new category
        $emojis = ['🌟', '💫', '✨', '🎯', '🎨', '🔮', '🌈', '💎', '🎭', '🎪'];
        $randomEmoji = $emojis[array_rand($emojis)];

        $category = Category::create([
            'name' => 'Ruang ' . $request->name,
            'slug' => $slug,
            'icon' => $randomEmoji,
        ]);

        // Auto-follow the room creator
        auth()->user()->followedRooms()->attach($category->id);

        return response()->json([
            'success' => true,
            'message' => 'Ruang baru berhasil dibuat!',
            'category' => $category,
            'redirect' => route('ruang.show', $category->slug)
        ]);
    }
}
