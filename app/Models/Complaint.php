<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    protected $fillable = ['user_id', 'subject', 'message', 'status'];

    /**
     * Get the user who submitted the complaint
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
