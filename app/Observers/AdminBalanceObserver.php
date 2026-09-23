<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class AdminBalanceObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Admin balance created: ₦{$model->amount} ({$model->status})";
        }

        if (isset($new['status'])) {
            return "Admin balance status changed from {$old['status']} to {$new['status']}";
        }

        return 'Admin balance updated';
    }
}
