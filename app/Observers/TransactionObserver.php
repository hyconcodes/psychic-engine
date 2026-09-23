<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class TransactionObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Transaction created: {$model->type} of ₦{$model->amount} ({$model->status})";
        }

        if (isset($new['status'])) {
            return "Transaction status changed from {$old['status']} to {$new['status']}";
        }

        return 'Transaction updated';
    }
}
