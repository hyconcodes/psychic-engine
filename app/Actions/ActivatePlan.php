<?php

namespace App\Actions;

use App\Models\AffiliateCommission;
use App\Models\Plan;
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

            $this->creditReferralCommission($user, $subscription->plan_id);

            return true;
        });
    }

    private function creditReferralCommission($user, int $planId): void
    {
        if (! $user->referred_by) {
            return;
        }

        $alreadyCommissioned = AffiliateCommission::where('referred_user_id', $user->id)->exists();

        if ($alreadyCommissioned) {
            return;
        }

        $plan = Plan::find($planId);

        if (! $plan || (float) $plan->referral_commission <= 0) {
            return;
        }

        AffiliateCommission::create([
            'referrer_id' => $user->referred_by,
            'referred_user_id' => $user->id,
            'plan_id' => $planId,
            'amount' => $plan->referral_commission,
            'status' => 'available',
        ]);
    }
}
