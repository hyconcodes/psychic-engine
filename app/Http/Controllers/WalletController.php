<?php

namespace App\Http\Controllers;

use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\CheckoutSessionRequest;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(
        private readonly BachsServiceInterface $bachs,
    ) {}

    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->formattedBalance() : '₦0.00';

        return view('wallet.index', compact('balance'));
    }

    public function fund(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500|max:500000',
        ]);

        $amount = (int) $request->amount;
        $user = auth()->user();

        $requestDto = new CheckoutSessionRequest(
            amount: $amount,
            currency: 'NGN',
            productName: 'VocalPay Wallet Funding',
            description: "Fund wallet with ₦{$amount}",
            email: $user->email,
            successUrl: route('wallet.callback').'?session_id={CHECKOUT_SESSION_ID}',
            cancelUrl: route('wallet.index'),
        );

        $response = $this->bachs->createCheckoutSession($requestDto);

        return redirect($response->checkoutUrl);
    }

    public function callback(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('wallet.index')->withErrors('Payment session not found.');
        }

        $verification = $this->bachs->verifyCheckoutSession($sessionId);

        if ($verification->isSuccessful()) {
            $user = auth()->user();
            $wallet = $user->wallet ?? $user->wallet()->create(['balance' => 0]);

            $amount = $verification->amount;
            $wallet->increment('balance', $amount);

            return redirect()->route('dashboard')->with('success', "Wallet funded successfully with ₦{$amount}.");
        }

        return redirect()->route('wallet.index')->withErrors('Payment was not completed. Please try again.');
    }
}
