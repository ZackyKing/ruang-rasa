<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = ['question_id', 'user_id', 'content'];

    /**
     * Get the question this answer belongs to
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the user who answered
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
