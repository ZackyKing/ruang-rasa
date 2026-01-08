<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reshare;
use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        echo "🔔 Generating notifications from existing interactions...\n";
        $this->createNotifications();
        echo "✅ Notifications created!\n";
    }

    private function createNotifications()
    {
        // 1. Follow Notifications
        $follows = Follow::with(['follower', 'following'])
            ->get(); // Get ALL follows to be sure we populate enough data

        $count = 0;
        foreach ($follows as $follow) {
            // Check if notification already exists
            $exists = Notification::where('user_id', $follow->following_id)
                ->where('type', 'follow')
                ->where('data->follower_id', $follow->follower_id)
                ->exists();

            if (!$exists && rand(1, 100) <= 80) { // 80% chance
                Notification::create([
                    'user_id' => $follow->following_id,
                    'type' => 'follow',
                    'data' => [
                        'follower_id' => $follow->follower_id,
                        'follower_name' => $follow->follower->name,
                        'avatar' => $follow->follower->avatar, // Added avatar for better UI
                    ],
                    'created_at' => $follow->created_at,
                    'read_at' => rand(0, 1) ? $follow->created_at->addMinutes(rand(10, 1000)) : null,
                ]);
                $count++;
            }
        }
        echo "   + $count follow notifications\n";

        // 2. Like Notifications
        $likes = Like::with(['user', 'post.user'])
            ->whereHas('post')
            ->get();

        $count = 0;
        foreach ($likes as $like) {
            if ($like->post->user_id !== $like->user_id) {
                $exists = Notification::where('user_id', $like->post->user_id)
                    ->where('type', 'like')
                    ->where('data->liker_id', $like->user_id)
                    ->where('data->post_id', $like->post_id)
                    ->exists();

                if (!$exists && rand(1, 100) <= 70) {
                    Notification::create([
                        'user_id' => $like->post->user_id,
                        'type' => 'like',
                        'data' => [
                            'post_id' => $like->post_id,
                            'liker_id' => $like->user_id,
                            'liker_name' => $like->user->name,
                            'avatar' => $like->user->avatar,
                            'post_preview' => Str::limit($like->post->content, 50),
                        ],
                        'created_at' => $like->created_at,
                        'read_at' => rand(0, 1) ? $like->created_at->addMinutes(rand(5, 500)) : null,
                    ]);
                    $count++;
                }
            }
        }
        echo "   + $count like notifications\n";

        // 3. Comment Notifications
        $comments = Comment::with(['user', 'post.user'])->get();

        $count = 0;
        foreach ($comments as $comment) {
            if ($comment->post->user_id !== $comment->user_id) {
                $exists = Notification::where('user_id', $comment->post->user_id)
                    ->where('type', 'comment')
                    ->where('data->commenter_id', $comment->user_id)
                    ->where('data->post_id', $comment->post_id)
                    ->exists();

                if (!$exists) {
                    Notification::create([
                        'user_id' => $comment->post->user_id,
                        'type' => 'comment',
                        'data' => [
                            'post_id' => $comment->post_id,
                            'commenter_id' => $comment->user_id,
                            'commenter_name' => $comment->user->name,
                            'avatar' => $comment->user->avatar,
                            'comment_preview' => Str::limit($comment->content, 50),
                        ],
                        'created_at' => $comment->created_at,
                        'read_at' => rand(0, 1) ? $comment->created_at->addMinutes(rand(5, 500)) : null,
                    ]);
                    $count++;
                }
            }
        }
        echo "   + $count comment notifications\n";

        // 4. Reshare Notifications
        $reshares = Reshare::with(['user', 'post.user'])->get();

        $count = 0;
        foreach ($reshares as $reshare) {
            if ($reshare->post->user_id !== $reshare->user_id) {
                $exists = Notification::where('user_id', $reshare->post->user_id)
                    ->where('type', 'reshare')
                    ->where('data->resharer_id', $reshare->user_id)
                    ->where('data->post_id', $reshare->post_id)
                    ->exists();

                if (!$exists && rand(1, 100) <= 80) {
                    Notification::create([
                        'user_id' => $reshare->post->user_id,
                        'type' => 'reshare',
                        'data' => [
                            'post_id' => $reshare->post_id,
                            'resharer_id' => $reshare->user_id,
                            'resharer_name' => $reshare->user->name,
                            'avatar' => $reshare->user->avatar,
                            'post_preview' => Str::limit($reshare->post->content, 50),
                        ],
                        'created_at' => $reshare->created_at,
                        'read_at' => rand(0, 1) ? $reshare->created_at->addMinutes(rand(5, 500)) : null,
                    ]);
                    $count++;
                }
            }
        }
        echo "   + $count reshare notifications\n";
    }
}
