<?php

use App\Models\Transaction;
use App\Models\User;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\CheckoutSessionVerification;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function verification(string $status, string $paymentStatus, ?string $amount = '7500.00'): CheckoutSessionVerification
{
    return new CheckoutSessionVerification(
        checkoutId: 'chk_123',
        status: $status,
        paymentStatus: $paymentStatus,
        chargeId: 'ch_456',
        amount: $amount,
        currency: 'NGN',
    );
}

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders the success state and activates the plan when payment completed', function () {
    Transaction::create([
        'user_id' => $this->user->id,
        'type' => 'plan_purchase',
        'amount' => 7500,
        'reference' => 'VP-TEST-1',
        'bachs_checkout_id' => 'chk_123',
        'status' => 'pending',
        'metadata' => ['plan_name' => 'Voice Spark'],
    ]);

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('verifyCheckoutSession')->once()->andReturn(verification('completed', 'succeeded'));
    });

    $this->get(route('plans.callback', ['checkout_id' => 'chk_123']))
        ->assertOk()
        ->assertSee('Payment successful')
        ->assertSee('Voice Spark');
});

it('renders the processing state when payment is still open', function () {
    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('verifyCheckoutSession')->once()->andReturn(verification('open', 'pending'));
    });

    $this->get(route('plans.callback', ['checkout_id' => 'chk_123']))
        ->assertOk()
        ->assertSee('Payment processing');
});

it('renders the failed state when the checkout expired', function () {
    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('verifyCheckoutSession')->once()->andReturn(verification('expired', 'pending'));
    });

    $this->get(route('plans.callback', ['checkout_id' => 'chk_123']))
        ->assertOk()
        ->assertSee('Payment not completed');
});

it('renders the error state when the checkout id is missing', function () {
    $this->get(route('plans.callback'))
        ->assertOk()
        ->assertSee('Something went wrong');
});

it('renders the cancelled state', function () {
    $this->get(route('plans.cancelled'))
        ->assertOk()
        ->assertSee('Payment cancelled');
});
