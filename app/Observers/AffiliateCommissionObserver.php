<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class AffiliateCommissionObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Affiliate commission created: ₦{$model->amount} ({$model->status})";
        }

        if (isset($new['status'])) {
            return "Affiliate commission status changed from {$old['status']} to {$new['status']}";
        }

        return 'Affiliate commission updated';
    }
}
