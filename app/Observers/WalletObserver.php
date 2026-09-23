<?php

namespace App\Observers;

use App\Observers\Traits\Auditable;

class WalletObserver
{
    use Auditable;

    protected static function getDescription($model, string $event, array $old, array $new): string
    {
        if (isset($new['balance'])) {
            $oldBalance = $old['balance'] ?? 0;
            $newBalance = $new['balance'];
            $diff = $newBalance - $oldBalance;
            $direction = $diff > 0 ? 'increased' : 'decreased';

            return "Wallet balance {$direction} by ₦".number_format(abs($diff), 2).' (from ₦'.number_format((float) $oldBalance, 2).' to ₦'.number_format((float) $newBalance, 2).')';
        }

        return 'Wallet updated';
    }
}
