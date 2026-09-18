<?php

namespace App\Http\Controllers;

use App\Actions\ActivatePlan;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\CheckoutSessionRequest;
use App\Services\Bachs\DTOs\CheckoutSessionVerification;
use App\Services\Bachs\Exceptions\BachsException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct(
        private readonly BachsServiceInterface $bachs,
        private readonly ActivatePlan $activatePlan,
    ) {}

    public function index(): View
    {
        $plans = Plan::active()->ordered()->get();
        $currentPlan = Auth::user()->currentPlan();

        return view('plans.index', compact('plans', 'currentPlan'));
    }

    public function subscribe(Plan $plan): RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasActivePlan()) {
            $currentPlan = $user->currentPlan();

            if ($plan->sort_order <= $currentPlan->sort_order) {
                return redirect()->route('plans.index')
                    ->with('toast_message', 'You cannot downgrade to this plan.')
                    ->with('toast_variant', 'warning');
            }
        }

        if (! $plan->bachs_product_id) {
            return redirect()->route('plans.index')
                ->with('toast_message', 'This plan is not available for purchase yet. Please try again later.')
                ->with('toast_variant', 'error');
        }

        $reference = Transaction::generateReference();

        $checkoutRequest = new CheckoutSessionRequest(
            customerEmail: $user->email,
            customerName: $user->name,
            productId: $plan->bachs_product_id,
            successUrl: route('plans.callback').'?checkout_id={CHECKOUT_ID}',
            cancelUrl: route('plans.cancelled'),
            paymentMethodTypes: ['NGN_BANK_TRANSFER', 'CRYPTO'],
            reference: $reference,
            metadata: [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
            ],
        );

        try {
            $checkout = $this->bachs->createCheckoutSession($checkoutRequest);

            DB::transaction(function () use ($user, $plan, $checkout, $reference) {
                UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'status' => 'pending',
                    'bachs_checkout_id' => $checkout->checkoutId,
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'plan_purchase',
                    'amount' => $plan->price,
                    'description' => "Activate {$plan->name} plan",
                    'reference' => $reference,
                    'bachs_checkout_id' => $checkout->checkoutId,
                    'status' => 'pending',
                    'metadata' => [
                        'plan_id' => $plan->id,
                        'plan_name' => $plan->name,
                    ],
                ]);
            });

            return redirect($checkout->checkoutUrl);
        } catch (BachsException $e) {
            return redirect()->route('plans.index')
                ->with('toast_message', 'Payment could not be initiated. Please try again.')
                ->with('toast_variant', 'error');
        }
    }

    public function callback(Request $request): View
    {
        $checkoutId = $request->query('checkout_id');

        if (! $checkoutId) {
            return view('payment.status', $this->status('error', 'Invalid payment reference.'));
        }

        try {
            $verification = $this->bachs->verifyCheckoutSession($checkoutId);

            if ($verification->isSuccessful()) {
                $this->activatePlan->handle($checkoutId, $verification->chargeId);

                return view('payment.status', $this->status('success', 'Your plan has been activated. Start earning now!', $this->receipt($checkoutId, $verification)));
            }

            if ($verification->status === 'expired' || $verification->paymentStatus === 'failed') {
                return view('payment.status', $this->status('failed', 'Your payment did not complete. You can try again.', $this->receipt($checkoutId, $verification)));
            }

            return view('payment.status', $this->status('processing', 'Your payment is being confirmed. This can take a few minutes for bank transfers.', $this->receipt($checkoutId, $verification)));
        } catch (BachsException) {
            return view('payment.status', $this->status('error', 'We could not verify your payment. Please contact support if this persists.'));
        }
    }

    public function cancelled(): View
    {
        return view('payment.status', $this->status('cancelled', 'You cancelled the payment. No charge was made.'));
    }

    private function status(string $state, string $message, array $receipt = []): array
    {
        return array_merge([
            'state' => $state,
            'message' => $message,
        ], $receipt);
    }

    private function receipt(string $checkoutId, CheckoutSessionVerification $verification): array
    {
        $transaction = Transaction::where('bachs_checkout_id', $checkoutId)->first();

        return [
            'checkout_id' => $checkoutId,
            'plan_name' => $transaction?->metadata['plan_name'] ?? $transaction?->description ?? 'Plan',
            'amount' => $transaction?->amount ?? $verification->amount,
            'reference' => $transaction?->reference ?? $verification->chargeId,
            'date' => $transaction?->created_at ?? now(),
        ];
    }
}
