<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBalance;
use App\Models\AdminPayout;
use App\Models\PayoutAccount;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\Exceptions\BachsException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminPayoutController extends Controller
{
    public function index(): View
    {
        $payouts = AdminPayout::with('payoutAccount')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        $confirmedBalance = AdminBalance::where('status', 'confirmed')
            ->where('user_id', Auth::id())
            ->sum('amount');

        $totalPaidOut = AdminPayout::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->sum('amount');

        $payoutAccount = PayoutAccount::where('user_id', Auth::id())->first();

        return view('admin.payouts.index', compact('payouts', 'confirmedBalance', 'totalPaidOut', 'payoutAccount'));
    }

    public function create(): View
    {
        $payoutAccount = PayoutAccount::where('user_id', Auth::id())->first();
        $banks = [];
        $confirmedBalance = AdminBalance::where('status', 'confirmed')
            ->where('user_id', Auth::id())
            ->sum('amount');

        try {
            $banks = app(BachsServiceInterface::class)->listBanks();
        } catch (\Exception $e) {
            // Banks list unavailable
        }

        return view('admin.payouts.create', compact('payoutAccount', 'banks', 'confirmedBalance'));
    }

    public function storeBank(Request $request, BachsServiceInterface $bachs): RedirectResponse
    {
        $validated = $request->validate([
            'bank_code' => 'required|string',
            'account_number' => 'required|string|size:10',
        ]);

        try {
            $result = $bachs->resolveBankAccount(
                $validated['account_number'],
                $validated['bank_code'],
            );

            $accountName = $result['account_name'] ?? 'Unknown Account';

            PayoutAccount::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'bank_name' => $result['bank_name'] ?? $validated['bank_code'],
                    'bank_code' => $validated['bank_code'],
                    'account_number' => $validated['account_number'],
                    'account_name' => $accountName,
                ],
            );

            return redirect()->route('admin.payouts.create')
                ->with('toast_message', 'Bank account verified and saved: '.$accountName)
                ->with('toast_variant', 'success');

        } catch (BachsException $e) {
            return back()->with('toast_message', 'Bank verification failed: '.$e->getMessage())->with('toast_variant', 'error');
        } catch (\Exception $e) {
            return back()->with('toast_message', 'An error occurred while verifying your bank account.')->with('toast_variant', 'error');
        }
    }

    public function edit(): View
    {
        $payoutAccount = PayoutAccount::where('user_id', Auth::id())->first();

        $banks = [];
        try {
            $banks = app(BachsServiceInterface::class)->listBanks();
        } catch (\Exception $e) {
            // Banks list unavailable
        }

        return view('admin.payouts.edit', compact('payoutAccount', 'banks'));
    }

    public function updateBank(Request $request, BachsServiceInterface $bachs): RedirectResponse
    {
        $validated = $request->validate([
            'bank_code' => 'required|string',
            'account_number' => 'required|string|size:10',
        ]);

        try {
            $result = $bachs->resolveBankAccount(
                $validated['account_number'],
                $validated['bank_code'],
            );

            $accountName = $result['account_name'] ?? 'Unknown Account';

            $payoutAccount = PayoutAccount::where('user_id', Auth::id())->first();

            if (! $payoutAccount) {
                return back()->with('toast_message', 'No payout account found.')->with('toast_variant', 'error');
            }

            $payoutAccount->update([
                'bank_name' => $result['bank_name'] ?? $validated['bank_code'],
                'bank_code' => $validated['bank_code'],
                'account_number' => $validated['account_number'],
                'account_name' => $accountName,
                'bachs_destination_id' => null,
            ]);

            return redirect()->route('admin.payouts.index')
                ->with('toast_message', 'Bank account updated and re-verified: '.$accountName)
                ->with('toast_variant', 'success');

        } catch (BachsException $e) {
            return back()->with('toast_message', 'Bank verification failed: '.$e->getMessage())->with('toast_variant', 'error');
        } catch (\Exception $e) {
            return back()->with('toast_message', 'An error occurred while verifying your bank account.')->with('toast_variant', 'error');
        }
    }

    public function process(Request $request, BachsServiceInterface $bachs): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $payoutAccount = PayoutAccount::where('user_id', Auth::id())->first();

        if (! $payoutAccount) {
            return back()->with('toast_message', 'Please add a bank account first.')->with('toast_variant', 'error');
        }

        $confirmedBalance = (float) AdminBalance::where('status', 'confirmed')
            ->where('user_id', Auth::id())
            ->sum('amount');

        $amount = (float) $validated['amount'];

        if ($amount > $confirmedBalance) {
            return back()->with('toast_message', 'Insufficient confirmed balance. Available: ₦'.number_format($confirmedBalance, 2))->with('toast_variant', 'error');
        }

        $adminPayout = AdminPayout::create([
            'user_id' => Auth::id(),
            'payout_account_id' => $payoutAccount->id,
            'amount' => $amount,
            'status' => 'processing',
        ]);

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

            $payout = $bachs->createPayout(
                $destinationId,
                number_format($amount, 2, '.', ''),
                'ADMIN-PAYOUT-'.$adminPayout->id.'-'.time(),
            );

            $adminPayout->update([
                'status' => 'completed',
                'bachs_payout_id' => $payout['id'] ?? null,
                'bachs_reference' => $payout['reference'] ?? null,
                'processed_at' => now(),
            ]);

            $this->markBalancesProcessed($amount);

            return redirect()->route('admin.payouts.index')
                ->with('toast_message', 'Payout of ₦'.number_format($amount, 2).' sent successfully to '.$payoutAccount->account_name.'.')
                ->with('toast_variant', 'success');

        } catch (BachsException $e) {
            $adminPayout->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('toast_message', 'Payout failed: '.$e->getMessage())->with('toast_variant', 'error');

        } catch (\Exception $e) {
            $adminPayout->update([
                'status' => 'failed',
                'error_message' => 'An unexpected error occurred.',
            ]);

            return back()->with('toast_message', 'Payout failed due to an unexpected error.')->with('toast_variant', 'error');
        }
    }

    private function markBalancesProcessed(float $amount): void
    {
        $remaining = $amount;

        $balances = AdminBalance::where('status', 'confirmed')
            ->where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();

        foreach ($balances as $balance) {
            if ($remaining <= 0) {
                break;
            }

            $balance->update(['status' => 'paid_out']);
            $remaining -= (float) $balance->amount;
        }
    }
}
