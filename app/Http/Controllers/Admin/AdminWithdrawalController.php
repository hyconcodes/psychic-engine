<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EarningSubmission;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\Exceptions\BachsException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminWithdrawalController extends Controller
{
    public function index(): View
    {
        $requests = WithdrawalRequest::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.withdrawals.index', compact('requests'));
    }

    public function show(WithdrawalRequest $withdrawal): View
    {
        $withdrawal->load(['user', 'payoutAccount', 'submissions.prompt']);

        return view('admin.withdrawals.review', [
            'withdrawal' => $withdrawal,
            'reasons' => WithdrawalRequest::DECLINE_REASONS,
            'deductionReasons' => WithdrawalRequest::DEDUCTION_REASONS,
        ]);
    }

    public function approve(WithdrawalRequest $withdrawal, BachsServiceInterface $bachs): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('toast_message', 'This request has already been reviewed.')->with('toast_variant', 'warning');
        }

        try {
            $payout = $this->createBachsPayout($withdrawal, (float) $withdrawal->amount, $bachs);
        } catch (BachsException $e) {
            return back()->with('toast_message', 'Payout failed: '.$e->getMessage())->with('toast_variant', 'error');
        }

        DB::transaction(function () use ($withdrawal, $payout) {
            $withdrawal->update([
                'status' => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'bachs_payout_id' => $payout['id'] ?? null,
                'bachs_reference' => $payout['reference'] ?? null,
            ]);

            $this->markTransaction($withdrawal, 'successful');
        });

        return redirect()->route('admin.withdrawals.index')
            ->with('toast_message', 'Withdrawal approved and payout sent.')
            ->with('toast_variant', 'success');
    }

    public function deduct(Request $request, WithdrawalRequest $withdrawal, BachsServiceInterface $bachs): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('toast_message', 'This request has already been reviewed.')->with('toast_variant', 'warning');
        }

        $validated = $request->validate([
            'deduct_amount' => ['required', 'numeric', 'min:1'],
            'deduct_reason' => ['required', 'string', 'in:'.implode(',', array_keys(WithdrawalRequest::DEDUCTION_REASONS))],
        ]);

        $original = (float) $withdrawal->amount;
        $deduct = (float) $validated['deduct_amount'];

        if ($deduct >= $original) {
            return back()->with('toast_message', 'Deduction must be less than the withdrawal amount.')->with('toast_variant', 'error');
        }

        $net = $original - $deduct;

        try {
            $payout = $this->createBachsPayout($withdrawal, $net, $bachs);
        } catch (BachsException $e) {
            return back()->with('toast_message', 'Payout failed: '.$e->getMessage())->with('toast_variant', 'error');
        }

        DB::transaction(function () use ($withdrawal, $payout, $deduct, $net, $original, $validated) {
            $withdrawal->update([
                'status' => 'approved',
                'deduct_amount' => $deduct,
                'deduct_reason' => $validated['deduct_reason'],
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'bachs_payout_id' => $payout['id'] ?? null,
                'bachs_reference' => $payout['reference'] ?? null,
            ]);

            $transaction = Transaction::where('metadata->withdrawal_request_id', $withdrawal->id)
                ->where('status', 'pending')
                ->first();

            if ($transaction) {
                $metadata = $transaction->metadata ?? [];
                $metadata['deduct_amount'] = $deduct;
                $metadata['deduct_reason'] = $validated['deduct_reason'];
                $metadata['original_amount'] = $original;

                $transaction->update([
                    'status' => 'successful',
                    'amount' => $net,
                    'metadata' => $metadata,
                ]);
            }
        });

        return redirect()->route('admin.withdrawals.index')
            ->with('toast_message', 'Withdrawal approved with a deduction of ₦'.number_format($deduct, 2).'.')
            ->with('toast_variant', 'success');
    }

    public function decline(Request $request, WithdrawalRequest $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('toast_message', 'This request has already been reviewed.')->with('toast_variant', 'warning');
        }

        $validated = $request->validate([
            'decline_reason' => ['required', 'string', 'in:'.implode(',', array_keys(WithdrawalRequest::DECLINE_REASONS))],
        ]);

        DB::transaction(function () use ($withdrawal, $validated) {
            $withdrawal->update([
                'status' => 'declined',
                'decline_reason' => $validated['decline_reason'],
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

            $transaction = Transaction::where('metadata->withdrawal_request_id', $withdrawal->id)
                ->where('status', 'pending')
                ->first();

            if ($transaction) {
                $metadata = $transaction->metadata ?? [];
                $metadata['decline_reason'] = $validated['decline_reason'];

                $transaction->update([
                    'status' => 'failed',
                    'metadata' => $metadata,
                ]);
            }

            if ($validated['decline_reason'] === 'spamming') {
                $withdrawal->user()->update([
                    'banned_until' => now()->addWeek(),
                ]);
            }
        });

        return redirect()->route('admin.withdrawals.index')
            ->with('toast_message', 'Withdrawal declined.')
            ->with('toast_variant', 'success');
    }

    public function audio(EarningSubmission $submission): StreamedResponse
    {
        $disk = config('earning.disk');

        if (! Storage::disk($disk)->exists($submission->audio_path)) {
            abort(404);
        }

        return Storage::disk($disk)->response($submission->audio_path);
    }

    private function createBachsPayout(WithdrawalRequest $withdrawal, float $amount, BachsServiceInterface $bachs): array
    {
        $payoutAccount = $withdrawal->payoutAccount;

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

        return $bachs->createPayout(
            $destinationId,
            number_format($amount, 2, '.', ''),
            'WD-'.$withdrawal->id.'-'.time(),
        );
    }

    private function markTransaction(WithdrawalRequest $withdrawal, string $status): void
    {
        Transaction::where('metadata->withdrawal_request_id', $withdrawal->id)
            ->where('status', 'pending')
            ->update(['status' => $status]);
    }
}
