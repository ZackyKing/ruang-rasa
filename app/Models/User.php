<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'cover_photo',
        'is_profile_hidden',
        'language',
        'website',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get users that this user is following
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Get users that follow this user
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing($userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    /**
     * Check if this user is followed by another user
     */
    public function isFollowedBy($userId): bool
    {
        if (!$userId)
            return false;
        return $this->followers()->where('follower_id', $userId)->exists();
    }

    /**
     * Get followers count
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    /**
     * Get following count
     */
    public function followingCount(): int
    {
        return $this->following()->count();
    }

    /**
     * Get user's posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get user's saved posts
     */
    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'saves', 'user_id', 'post_id')
            ->withTimestamps();
    }

    /**
     * Get user's liked posts
     */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
            ->withTimestamps();
    }

    /**
     * Get user's reshared posts
     */
    public function resharedPosts()
    {
        return $this->belongsToMany(Post::class, 'reshares', 'user_id', 'post_id')
            ->withTimestamps();
    }

    /**
     * Get rooms/categories this user follows
     */
    public function followedRooms()
    {
        return $this->belongsToMany(Category::class, 'room_follows', 'user_id', 'category_id')
            ->withTimestamps();
    }

    /**
     * Check if user follows a room
     */
    public function isFollowingRoom($categoryId): bool
    {
        return $this->followedRooms()->where('category_id', $categoryId)->exists();
    }

    /**
     * Get IDs of followed rooms
     */
    public function followedRoomIds(): array
    {
        return $this->followedRooms()->pluck('categories.id')->toArray();
    }
}
