<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutAccount extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_code',
        'account_number',
        'account_name',
        'bachs_destination_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
