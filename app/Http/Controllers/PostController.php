<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reshare;
use App\Models\Save;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a new post
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:1',
            'category_id' => 'required|exists:categories,id',
            'is_anonymous' => 'boolean',
            'is_draft' => 'boolean',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_draft' => $request->boolean('is_draft'),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $post->is_draft ? 'Draft berhasil disimpan!' : 'Post berhasil dibuat!',
                'post' => $post->load(['user', 'category']),
            ]);
        }

        return redirect()->back()->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Toggle like on a post
     */
    public function toggleLike(Post $post)
    {
        $user = auth()->user();
        $like = Like::where('post_id', $post->id)->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create(['post_id' => $post->id, 'user_id' => $user->id]);
            $liked = true;

            // Create notification
            Notification::createLikeNotification($post, $user);
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    /**
     * Add comment to a post
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|min:1',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $user = auth()->user();

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        // Create notification
        Notification::createCommentNotification($post, $user, $comment);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan!',
            'comment' => $comment->load('user'),
            'comments_count' => $post->comments()->count(),
        ]);
    }

    /**
     * Reply to a comment
     */
    public function replyComment(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $user = auth()->user();

        $reply = Comment::create([
            'post_id' => $comment->post_id,
            'user_id' => $user->id,
            'content' => $request->content,
            'parent_id' => $comment->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil ditambahkan!',
            'reply' => $reply->load('user'),
        ]);
    }

    /**
     * Get comments for a post (with nested replies)
     */
    public function getComments(Post $post)
    {
        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments,
        ]);
    }

    /**
     * Toggle reshare on a post
     */
    public function toggleReshare(Post $post)
    {
        $user = auth()->user();
        $reshare = Reshare::where('post_id', $post->id)->where('user_id', $user->id)->first();

        if ($reshare) {
            $reshare->delete();
            $reshared = false;
        } else {
            Reshare::create(['post_id' => $post->id, 'user_id' => $user->id]);
            $reshared = true;

            // Create notification
            Notification::createReshareNotification($post, $user);
        }

        return response()->json([
            'success' => true,
            'reshared' => $reshared,
            'reshares_count' => $post->reshares()->count(),
        ]);
    }

    /**
     * Toggle save (bookmark) on a post
     */
    public function toggleSave(Post $post)
    {
        $userId = auth()->id();
        $save = Save::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($save) {
            $save->delete();
            $saved = false;
        } else {
            Save::create(['post_id' => $post->id, 'user_id' => $userId]);
            $saved = true;
        }

        return response()->json([
            'success' => true,
            'saved' => $saved,
        ]);
    }

    /**
     * Get shareable link for a post
     */
    public function getLink(Post $post)
    {
        $link = route('post.show', $post->id);

        return response()->json([
            'success' => true,
            'link' => $link,
        ]);
    }

    /**
     * Show single post
     */
    public function show(Post $post)
    {
        $post->load([
            'user',
            'category',
            'comments' => function ($query) {
                $query->whereNull('parent_id')->with(['user', 'replies.user']);
            }
        ]);

        return view('post.show', compact('post'));
    }

    /**
     * Get user's draft posts
     */
    public function drafts()
    {
        $drafts = Post::with(['category'])
            ->where('user_id', auth()->id())
            ->where('is_draft', true)
            ->latest()
            ->get();

        return view('drafts', compact('drafts'));
    }

    /**
     * Publish a draft post
     */
    public function publishDraft(Post $post)
    {
        // Check ownership
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan',
            ], 403);
        }

        $post->update(['is_draft' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dipublikasikan!',
        ]);
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post)
    {
        // Check ownership
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan',
            ], 403);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus!',
        ]);
    }
}
