<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EarningSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'prompt_id',
        'type',
        'language',
        'audio_path',
        'audio_duration',
        'amount',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'audio_duration' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(EarningPrompt::class, 'prompt_id');
    }
}
