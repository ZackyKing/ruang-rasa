<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user this notification belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Create a like notification
     */
    public static function createLikeNotification($post, $liker)
    {
        // Don't notify yourself
        if ($post->user_id === $liker->id)
            return;

        return self::create([
            'user_id' => $post->user_id,
            'type' => 'like',
            'data' => [
                'post_id' => $post->id,
                'liker_id' => $liker->id,
                'liker_name' => $liker->name,
                'post_preview' => \Illuminate\Support\Str::limit($post->content, 50),
            ],
        ]);
    }

    /**
     * Create a comment notification
     */
    public static function createCommentNotification($post, $commenter, $comment)
    {
        if ($post->user_id === $commenter->id)
            return;

        return self::create([
            'user_id' => $post->user_id,
            'type' => 'comment',
            'data' => [
                'post_id' => $post->id,
                'commenter_id' => $commenter->id,
                'commenter_name' => $commenter->name,
                'comment_preview' => \Illuminate\Support\Str::limit($comment->content, 50),
            ],
        ]);
    }

    /**
     * Create a follow notification
     */
    public static function createFollowNotification($followedUser, $follower)
    {
        return self::create([
            'user_id' => $followedUser->id,
            'type' => 'follow',
            'data' => [
                'follower_id' => $follower->id,
                'follower_name' => $follower->name,
            ],
        ]);
    }

    /**
     * Create a reshare notification
     */
    public static function createReshareNotification($post, $resharer)
    {
        if ($post->user_id === $resharer->id)
            return;

        return self::create([
            'user_id' => $post->user_id,
            'type' => 'reshare',
            'data' => [
                'post_id' => $post->id,
                'resharer_id' => $resharer->id,
                'resharer_name' => $resharer->name,
                'post_preview' => \Illuminate\Support\Str::limit($post->content, 50),
            ],
        ]);
    }

    /**
     * Create an answer notification
     */
    public static function createAnswerNotification($question, $answerer, $answer)
    {
        if ($question->user_id === $answerer->id)
            return;

        return self::create([
            'user_id' => $question->user_id,
            'type' => 'answer',
            'data' => [
                'question_id' => $question->id,
                'answerer_id' => $answerer->id,
                'answerer_name' => $answerer->name,
                'question_preview' => \Illuminate\Support\Str::limit($question->content, 50),
            ],
        ]);
    }
}
