<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * Display the authenticated user's profile
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $activeTab = $request->get('tab', 'kiriman');

        $user = [
            'id' => $authUser->id,
            'name' => $authUser->name,
            'username' => $authUser->username ?? $authUser->id,
            'bio' => $authUser->bio ?? 'Belum ada bio',
            'avatar' => $authUser->avatar,
            'cover_photo' => $authUser->cover_photo,
            'website' => $authUser->website,
            'followers' => $authUser->followers()->count(),
            'following' => $authUser->following()->count(),
            'isOwner' => true,
            'hidden' => $authUser->is_profile_hidden,
        ];

        // Get user's posts
        $posts = Post::with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->where('user_id', $authUser->id)
            ->where('is_draft', false)
            ->latest()
            ->get();

        // Get user's questions
        $questions = Question::where('user_id', $authUser->id)
            ->latest()
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'text' => $question->content,
                    'answers_count' => $question->answers->count(),
                    'is_anonymous' => $question->is_anonymous,
                    'created_at' => $question->created_at->diffForHumans(),
                ];
            });

        // Get user's answers
        $answers = Answer::with(['question', 'question.user'])
            ->where('user_id', $authUser->id)
            ->latest()
            ->get()
            ->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'asker' => $answer->question->is_anonymous ? 'Anonim' : ($answer->question->user->name ?? 'Anonim'),
                    'question' => $answer->question->content,
                    'answer' => $answer->content,
                    'created_at' => $answer->created_at->diffForHumans(),
                ];
            });

        // Get user's reshared posts
        $reposts = $authUser->resharedPosts()
            ->with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->latest()
            ->get();

        // Get draft posts
        $drafts = Post::where('user_id', $authUser->id)
            ->where('is_draft', true)
            ->latest()
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'category' => $post->category ? $post->category->name : 'Tanpa Kategori',
                    'content' => $post->content,
                    'created_at' => $post->created_at->diffForHumans(),
                ];
            });

        // Get saved posts
        $savedPosts = $authUser->savedPosts()
            ->with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->latest()
            ->get();

        // Get liked posts
        $likedPosts = $authUser->likedPosts()
            ->with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->latest()
            ->get();

        return view('profil', compact('user', 'posts', 'questions', 'answers', 'reposts', 'activeTab', 'drafts', 'savedPosts', 'likedPosts'));
    }

    /**
     * Display another user's profile
     */
    public function show($username, Request $request)
    {
        $authUser = Auth::user();
        $activeTab = $request->get('tab', 'kiriman');

        // Find the user
        $profileUser = User::where('username', $username)
            ->orWhere('id', $username)
            ->firstOrFail();

        // Check if profile is hidden
        if ($profileUser->is_profile_hidden && $profileUser->id !== $authUser->id) {
            abort(404, 'Profil ini disembunyikan');
        }

        // Check if current user is following this profile user
        $isFollowing = $authUser->following()->where('following_id', $profileUser->id)->exists();

        $user = [
            'id' => $profileUser->id,
            'name' => $profileUser->name,
            'username' => $profileUser->username ?? $profileUser->id,
            'bio' => $profileUser->bio ?? 'Belum ada bio',
            'avatar' => $profileUser->avatar,
            'cover_photo' => $profileUser->cover_photo,
            'website' => $profileUser->website,
            'followers' => $profileUser->followers()->count(),
            'following' => $profileUser->following()->count(),
            'isOwner' => $profileUser->id === $authUser->id,
            'isFollowing' => $isFollowing,
            'hidden' => $profileUser->is_profile_hidden,
        ];

        // Get user's posts
        $posts = Post::with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->where('user_id', $profileUser->id)
            ->where('is_draft', false)
            ->latest()
            ->get();

        // Get user's questions
        $questions = Question::where('user_id', $profileUser->id)
            ->latest()
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'text' => $question->content,
                    'answers_count' => $question->answers->count(),
                    'is_anonymous' => $question->is_anonymous,
                    'created_at' => $question->created_at->diffForHumans(),
                ];
            });

        // Get user's answers
        $answers = Answer::with(['question', 'question.user'])
            ->where('user_id', $profileUser->id)
            ->latest()
            ->get()
            ->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'asker' => $answer->question->is_anonymous ? 'Anonim' : ($answer->question->user->name ?? 'Anonim'),
                    'question' => $answer->question->content,
                    'answer' => $answer->content,
                    'created_at' => $answer->created_at->diffForHumans(),
                ];
            });

        // Get user's reshared posts
        $reposts = $profileUser->resharedPosts()
            ->with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
            ->latest()
            ->get();

        // Draft, saved, and liked posts - Not visible on other user's profiles
        $drafts = collect();
        $savedPosts = collect();
        $likedPosts = collect();

        return view('profil', compact('user', 'posts', 'questions', 'answers', 'reposts', 'activeTab', 'drafts', 'savedPosts', 'likedPosts'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:50|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'bio' => $request->bio,
            'website' => $request->website,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = '/storage/' . $avatarPath;
        }

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            $coverPath = $request->file('cover_photo')->store('covers', 'public');
            $data['cover_photo'] = '/storage/' . $coverPath;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }

    /**
     * Toggle profile visibility
     */
    public function togglePrivacy(Request $request)
    {
        $user = Auth::user();
        $user->is_profile_hidden = !$user->is_profile_hidden;
        $user->save();

        return response()->json([
            'success' => true,
            'is_hidden' => $user->is_profile_hidden,
            'message' => $user->is_profile_hidden ? 'Profil disembunyikan' : 'Profil ditampilkan'
        ]);
    }

    /**
     * Follow/Unfollow a user
     */
    public function follow($userId)
    {
        $authUser = Auth::user();
        $targetUser = User::findOrFail($userId);

        if ($authUser->id === $targetUser->id) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa mengikuti diri sendiri']);
        }

        $isFollowing = $authUser->following()->where('following_id', $targetUser->id)->exists();

        if ($isFollowing) {
            $authUser->following()->detach($targetUser->id);
            $following = false;
            $message = 'Berhenti mengikuti';
        } else {
            $authUser->following()->attach($targetUser->id);
            $following = true;
            $message = 'Mengikuti';
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'followers_count' => $targetUser->followers()->count(),
            'message' => $message
        ]);
    }
}
