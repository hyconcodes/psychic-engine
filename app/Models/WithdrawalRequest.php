<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WithdrawalRequest extends Model
{
    public const DECLINE_REASONS = [
        'nonsense' => 'Nonsense / rubbish voice transcription',
        'before_threshold' => 'Failed: withdrew before the 2-week threshold',
        'low_quality' => 'Low quality',
        'spamming' => 'Spamming — disabled for 1 week',
    ];

    protected $fillable = [
        'user_id',
        'payout_account_id',
        'amount',
        'status',
        'decline_reason',
        'early_withdrawal',
        'requested_at',
        'reviewed_at',
        'reviewed_by',
        'bachs_payout_id',
        'bachs_reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'early_withdrawal' => 'boolean',
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payoutAccount(): BelongsTo
    {
        return $this->belongsTo(PayoutAccount::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(EarningSubmission::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
