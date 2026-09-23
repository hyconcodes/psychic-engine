<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class AdminPayoutObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Admin payout initiated: ₦{$model->amount}";
        }

        if (isset($new['status'])) {
            $desc = "Admin payout status changed from {$old['status']} to {$new['status']}";
            if (isset($new['error_message'])) {
                $desc .= " (Error: {$new['error_message']})";
            }

            return $desc;
        }

        return 'Admin payout updated';
    }
}
