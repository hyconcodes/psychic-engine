<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EarningPrompt extends Model
{
    protected $fillable = [
        'type',
        'language',
        'text',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(EarningSubmission::class, 'prompt_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
