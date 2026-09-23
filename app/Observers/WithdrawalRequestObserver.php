<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class WithdrawalRequestObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if ($event === 'created') {
            return "Withdrawal request created: ₦{$model->amount}";
        }

        if (isset($new['status'])) {
            $desc = "Withdrawal request status changed from {$old['status']} to {$new['status']}";
            if (isset($new['deduct_amount'])) {
                $desc .= " with deduction of ₦{$new['deduct_amount']}";
            }

            return $desc;
        }

        return 'Withdrawal request updated';
    }
}
