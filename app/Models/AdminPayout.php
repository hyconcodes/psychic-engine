<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPayout extends Model
{
    protected $fillable = [
        'user_id',
        'payout_account_id',
        'amount',
        'status',
        'error_message',
        'bachs_payout_id',
        'bachs_reference',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payoutAccount(): BelongsTo
    {
        return $this->belongsTo(PayoutAccount::class);
    }

    public function formattedAmount(): string
    {
        return '₦'.number_format((float) $this->amount, 2);
    }
}
