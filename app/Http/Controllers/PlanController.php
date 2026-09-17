<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\CheckoutSessionRequest;
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
            cancelUrl: route('plans.index'),
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

    public function callback(Request $request): RedirectResponse
    {
        $checkoutId = $request->query('checkout_id');

        if (! $checkoutId) {
            return redirect()->route('dashboard')
                ->with('toast_message', 'Invalid payment callback.')
                ->with('toast_variant', 'error');
        }

        try {
            $verification = $this->bachs->verifyCheckoutSession($checkoutId);

            if ($verification->isSuccessful()) {
                $this->activatePlan($checkoutId, $verification->chargeId);

                return redirect()->route('dashboard')
                    ->with('toast_message', 'Plan activated successfully! Start earning now.')
                    ->with('toast_variant', 'success');
            }

            return redirect()->route('plans.index')
                ->with('toast_message', 'Payment was not completed. Please try again.')
                ->with('toast_variant', 'warning');
        } catch (BachsException) {
            return redirect()->route('plans.index')
                ->with('toast_message', 'Could not verify payment. Please contact support.')
                ->with('toast_variant', 'error');
        }
    }

    private function activatePlan(string $checkoutId, ?string $chargeId): void
    {
        DB::transaction(function () use ($checkoutId, $chargeId) {
            $subscription = UserSubscription::where('bachs_checkout_id', $checkoutId)
                ->where('status', 'pending')
                ->firstOrFail();

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
        });
    }
}
