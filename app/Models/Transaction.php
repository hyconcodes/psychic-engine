<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'reference',
        'bachs_checkout_id',
        'bachs_charge_id',
        'status',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateReference(): string
    {
        return 'VP-'.strtoupper(Str::random(4)).'-'.time();
    }

    public function formattedAmount(): string
    {
        return '₦'.number_format((float) $this->amount, 2);
    }
}
