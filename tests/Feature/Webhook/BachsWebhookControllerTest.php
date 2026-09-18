<?php

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function signedBachsRequest(string $secret, array $payload, ?int $timestamp = null): array
{
    $rawBody = json_encode($payload);
    $timestamp ??= time();
    $signature = hash_hmac('sha256', $timestamp.'.'.$rawBody, $secret);

    return [
        'body' => $rawBody,
        'headers' => [
            'X-Bachs-Timestamp' => (string) $timestamp,
            'X-Bachs-Signature-V2' => "t={$timestamp},v1={$signature}",
        ],
    ];
}

function makePendingSubscription(string $checkoutId): UserSubscription
{
    $user = User::factory()->create();
    $plan = Plan::create([
        'name' => 'Voice Spark',
        'slug' => 'voice-spark',
        'price' => 7500,
        'voice_earn_per_session' => 100,
        'word_game_per_word' => 50,
        'sort_order' => 1,
    ]);

    $subscription = UserSubscription::create([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'status' => 'pending',
        'bachs_checkout_id' => $checkoutId,
    ]);

    Transaction::create([
        'user_id' => $user->id,
        'type' => 'plan_purchase',
        'amount' => 7500,
        'reference' => 'VP-TEST-1',
        'bachs_checkout_id' => $checkoutId,
        'status' => 'pending',
    ]);

    return $subscription;
}

beforeEach(function () {
    config()->set('bachs.webhook_secret', 'whsec_test');
    config()->set('bachs.webhook_tolerance', 300);
});

it('rejects a request with an invalid signature', function () {
    $request = signedBachsRequest('whsec_test', [
        'id' => 'evt_1',
        'type' => 'collection.succeeded',
        'data' => [],
    ]);

    $response = $this->postJson('/webhooks/bachs', json_decode($request['body'], true), [
        'X-Bachs-Timestamp' => $request['headers']['X-Bachs-Timestamp'],
        'X-Bachs-Signature-V2' => 't=9999999999,v1=deadbeef',
    ]);

    $response->assertStatus(401);
});

it('rejects a stale delivery', function () {
    $request = signedBachsRequest('whsec_test', [
        'id' => 'evt_2',
        'type' => 'collection.succeeded',
        'data' => [],
    ], time() - 1000);

    $response = $this->postJson('/webhooks/bachs', json_decode($request['body'], true), $request['headers']);

    $response->assertStatus(401);
});

it('activates a pending subscription when a collection succeeds', function () {
    $subscription = makePendingSubscription('chk_123');
    $request = signedBachsRequest('whsec_test', [
        'id' => 'evt_3',
        'type' => 'collection.succeeded',
        'data' => [
            'checkout_id' => 'chk_123',
            'charge_id' => 'ch_456',
            'reference' => 'VP-TEST-1',
            'amount' => '7500.00',
        ],
    ]);

    $response = $this->postJson('/webhooks/bachs', json_decode($request['body'], true), $request['headers']);

    $response->assertOk()->assertJson(['received' => true]);

    $this->assertDatabaseHas('user_subscriptions', [
        'id' => $subscription->id,
        'status' => 'active',
        'bachs_charge_id' => 'ch_456',
    ]);
    $this->assertDatabaseHas('transactions', [
        'bachs_checkout_id' => 'chk_123',
        'status' => 'successful',
        'bachs_charge_id' => 'ch_456',
    ]);
});

it('ignores a duplicate delivery', function () {
    makePendingSubscription('chk_123');
    $payload = [
        'id' => 'evt_4',
        'type' => 'collection.succeeded',
        'data' => ['checkout_id' => 'chk_123', 'charge_id' => 'ch_456'],
    ];

    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();
    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();

    $this->assertDatabaseCount('webhook_events', 1);
});

it('marks a pending subscription failed when a collection fails', function () {
    $subscription = makePendingSubscription('chk_123');
    $payload = [
        'id' => 'evt_5',
        'type' => 'collection.failed',
        'data' => ['checkout_id' => 'chk_123'],
    ];

    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();

    $this->assertDatabaseHas('user_subscriptions', [
        'id' => $subscription->id,
        'status' => 'failed',
    ]);
    $this->assertDatabaseHas('transactions', [
        'bachs_checkout_id' => 'chk_123',
        'status' => 'failed',
    ]);
});

it('marks a pending subscription expired when a checkout expires', function () {
    $subscription = makePendingSubscription('chk_123');
    $payload = [
        'id' => 'evt_6',
        'type' => 'checkout.expired',
        'data' => ['checkout_id' => 'chk_123'],
    ];

    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();

    $this->assertDatabaseHas('user_subscriptions', [
        'id' => $subscription->id,
        'status' => 'expired',
    ]);
});

it('does not activate a subscription on checkout completed', function () {
    $subscription = makePendingSubscription('chk_123');
    $payload = [
        'id' => 'evt_7',
        'type' => 'checkout.completed',
        'data' => ['checkout_id' => 'chk_123'],
    ];

    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();

    $this->assertDatabaseHas('user_subscriptions', [
        'id' => $subscription->id,
        'status' => 'pending',
    ]);
});

it('activates a subscription when the charge id is null', function () {
    $subscription = makePendingSubscription('chk_123');
    $payload = [
        'id' => 'evt_8',
        'type' => 'collection.succeeded',
        'data' => ['checkout_id' => 'chk_123', 'charge_id' => null],
    ];

    $this->postJson('/webhooks/bachs', $payload, signedBachsRequest('whsec_test', $payload)['headers'])->assertOk();

    $this->assertDatabaseHas('user_subscriptions', [
        'id' => $subscription->id,
        'status' => 'active',
        'bachs_charge_id' => null,
    ]);
});
