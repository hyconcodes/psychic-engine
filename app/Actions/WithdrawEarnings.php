<?php

namespace App\Actions;

use App\Models\EarningSubmission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WithdrawEarnings
{
    public function handle(User $user): WithdrawalRequest
    {
        $payoutAccount = $user->payoutAccount;

        if (! $payoutAccount) {
            throw new RuntimeException('Link your payout account before withdrawing.');
        }

        $wallet = $user->wallet;

        if (! $wallet || (float) $wallet->balance <= 0) {
            throw new RuntimeException('You have no earnings to withdraw.');
        }

        $amount = (float) $wallet->balance;

        return DB::transaction(function () use ($user, $payoutAccount, $wallet, $amount) {
            $early = EarningSubmission::where('user_id', $user->id)
                ->whereNull('withdrawal_request_id')
                ->where('created_at', '>=', now()->subDays(14))
                ->exists();

            $request = WithdrawalRequest::create([
                'user_id' => $user->id,
                'payout_account_id' => $payoutAccount->id,
                'amount' => $amount,
                'status' => 'pending',
                'early_withdrawal' => $early,
                'requested_at' => now(),
            ]);

            EarningSubmission::where('user_id', $user->id)
                ->whereNull('withdrawal_request_id')
                ->update(['withdrawal_request_id' => $request->id]);

            $wallet->update(['balance' => 0]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'description' => 'Task earnings withdrawal',
                'reference' => Transaction::generateReference(),
                'status' => 'pending',
                'metadata' => [
                    'withdrawal_request_id' => $request->id,
                ],
            ]);

            return $request;
        });
    }
}
