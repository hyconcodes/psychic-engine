<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'bachs_product_id',
        'price',
        'voice_earn_per_session',
        'word_game_per_word',
        'daily_voice_tasks',
        'daily_word_tasks',
        'referral_commission',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
        'admin_charge_amount',
        'admin_charge_percentage',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'daily_voice_tasks' => 'integer',
        'daily_word_tasks' => 'integer',
        'referral_commission' => 'decimal:2',
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'admin_charge_amount' => 'decimal:2',
        'admin_charge_percentage' => 'decimal:2',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    public function formattedPrice(): string
    {
        return '₦'.number_format((float) $this->price);
    }
}
