<?php

namespace App\Actions;

use App\Models\Transaction;
use App\Models\User;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\Exceptions\BachsException;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WithdrawAffiliateCommission
{
    public function handle(User $user, BachsServiceInterface $bachs): float
    {
        $payoutAccount = $user->payoutAccount;

        if (! $payoutAccount) {
            throw new RuntimeException('Link your payout account before withdrawing.');
        }

        $commissions = $user->affiliateCommissions()
            ->where('status', 'available')
            ->get();

        if ($commissions->isEmpty()) {
            throw new RuntimeException('You have no affiliate earnings to withdraw.');
        }

        $amount = (float) $commissions->sum('amount');

        try {
            $destinationId = $payoutAccount->bachs_destination_id;

            if (! $destinationId) {
                $destinationId = $bachs->createPayoutDestination(
                    $payoutAccount->account_name,
                    'NGN',
                    $payoutAccount->account_number,
                    $payoutAccount->bank_code,
                );

                $payoutAccount->update(['bachs_destination_id' => $destinationId]);
            }

            $bachs->createPayout(
                $destinationId,
                number_format($amount, 2, '.', ''),
                'AFF-'.$user->id.'-'.time(),
            );
        } catch (BachsException $e) {
            throw new RuntimeException('Payout failed: '.$e->getMessage());
        }

        DB::transaction(function () use ($user, $commissions, $amount) {
            $commissions->each->update(['status' => 'withdrawn']);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'description' => 'Affiliate commission withdrawal',
                'reference' => Transaction::generateReference(),
                'status' => 'successful',
                'metadata' => ['affiliate' => true],
            ]);
        });

        return $amount;
    }
}
