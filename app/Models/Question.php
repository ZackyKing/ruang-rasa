<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = ['user_id', 'content', 'is_anonymous'];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * Get the user who asked the question
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get answers for this question
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->latest();
    }

    /**
     * Get author name (respecting anonymity)
     */
    public function getAuthorNameAttribute(): string
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }

    /**
     * Check if question has answers
     */
    public function hasAnswers(): bool
    {
        return $this->answers()->count() > 0;
    }
}
