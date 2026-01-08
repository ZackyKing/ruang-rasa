<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'content', 'is_anonymous', 'is_draft'];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_draft' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function reshares(): HasMany
    {
        return $this->hasMany(Reshare::class);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }

    // Check if current user liked
    public function isLikedBy($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Check if current user saved
    public function isSavedBy($userId): bool
    {
        return $this->saves()->where('user_id', $userId)->exists();
    }

    // Check if current user reshared
    public function isResharedBy($userId): bool
    {
        return $this->reshares()->where('user_id', $userId)->exists();
    }

    // Get display author name
    public function getAuthorNameAttribute(): string
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }
}
