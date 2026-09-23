<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'bachs_checkout_id',
        'bachs_charge_id',
        'activated_at',
        'expires_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isLifetime(): bool
    {
        return $this->expires_at === null;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (UserSubscription $subscription) {
            if ($subscription->status === 'active' && $subscription->plan) {
                $subscription->addAdminBalance();
            }
        });

        static::updated(function (UserSubscription $subscription) {
            if ($subscription->status === 'active'
                && $subscription->plan
                && $subscription->wasChanged('status')
                && $subscription->getOriginal('status') !== 'active') {
                $subscription->addAdminBalance();
            }
        });
    }

    public function addAdminBalance(): void
    {
        $plan = $this->plan;
        $adminChargeAmount = $plan->admin_charge_amount;

        if ($adminChargeAmount > 0) {
            AdminBalance::create([
                'user_id' => $this->user_id,
                'amount' => $adminChargeAmount,
                'plan_id' => $this->plan_id,
                'description' => "Admin charge for plan activation: {$plan->name} (User ID: {$this->user_id})",
                'status' => 'pending',
            ]);
        }
    }
}
