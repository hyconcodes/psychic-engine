<?php

namespace App\Actions;

use App\Models\Transaction;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;

class ActivatePlan
{
    public function handle(string $checkoutId, ?string $chargeId): bool
    {
        return DB::transaction(function () use ($checkoutId, $chargeId) {
            $subscription = UserSubscription::where('bachs_checkout_id', $checkoutId)
                ->where('status', 'pending')
                ->first();

            if (! $subscription) {
                return false;
            }

            $subscription->update([
                'status' => 'active',
                'bachs_charge_id' => $chargeId,
                'activated_at' => now(),
            ]);

            Transaction::where('bachs_checkout_id', $checkoutId)
                ->where('status', 'pending')
                ->update([
                    'status' => 'successful',
                    'bachs_charge_id' => $chargeId,
                ]);

            $user = $subscription->user;
            if (! $user->wallet) {
                $user->wallet()->create(['balance' => 0]);
            }

            return true;
        });
    }
}
