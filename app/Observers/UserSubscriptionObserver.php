<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class UserSubscriptionObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Subscription created for plan {$model->plan->name} ({$model->status})";
        }

        if (isset($new['status'])) {
            return "Subscription status changed from {$old['status']} to {$new['status']}";
        }

        return 'Subscription updated';
    }
}
