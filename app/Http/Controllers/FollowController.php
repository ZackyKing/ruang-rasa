<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Toggle follow/unfollow a user
     */
    public function toggle(User $user)
    {
        $authUser = auth()->user();

        // Cannot follow yourself
        if ($authUser->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengikuti diri sendiri',
            ], 400);
        }

        $isFollowing = $authUser->isFollowing($user->id);

        if ($isFollowing) {
            // Unfollow
            $authUser->following()->detach($user->id);
            $followed = false;
            $message = 'Berhenti mengikuti ' . $user->name;
        } else {
            // Follow
            $authUser->following()->attach($user->id);
            $followed = true;
            $message = 'Mulai mengikuti ' . $user->name;
        }

        return response()->json([
            'success' => true,
            'followed' => $followed,
            'message' => $message,
            'followers_count' => $user->followersCount(),
            'following_count' => $user->followingCount(),
        ]);
    }
}
