<?php

use App\Actions\ActivatePlan;
use App\Actions\WithdrawAffiliateCommission;
use App\Models\AffiliateCommission;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function referrer(): User
{
    return User::factory()->create();
}

function referralPlan(float $commission = 2000): Plan
{
    return Plan::create([
        'name' => 'Echo Pro',
        'slug' => 'echo-pro',
        'price' => 12500,
        'voice_earn_per_session' => 150,
        'word_game_per_word' => 75,
        'daily_voice_tasks' => 8,
        'daily_word_tasks' => 8,
        'referral_commission' => $commission,
        'sort_order' => 2,
    ]);
}

test('credits commission when a referred user activates a plan', function () {
    $referrerUser = referrer();
    $plan = referralPlan(2000);
    $referred = User::factory()->create(['referred_by' => $referrerUser->id]);

    UserSubscription::create([
        'user_id' => $referred->id,
        'plan_id' => $plan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);

    app(ActivatePlan::class)->handle('chk_123', 'ch_456');

    $this->assertDatabaseHas('affiliate_commissions', [
        'referrer_id' => $referrerUser->id,
        'referred_user_id' => $referred->id,
        'plan_id' => $plan->id,
        'amount' => 2000,
        'status' => 'available',
    ]);
});

test('does not re-credit commission when a commission already exists', function () {
    $referrerUser = referrer();
    $plan = referralPlan(2000);
    $referred = User::factory()->create(['referred_by' => $referrerUser->id]);

    AffiliateCommission::create([
        'referrer_id' => $referrerUser->id,
        'referred_user_id' => $referred->id,
        'plan_id' => $plan->id,
        'amount' => 2000,
        'status' => 'available',
    ]);

    UserSubscription::create([
        'user_id' => $referred->id,
        'plan_id' => $plan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);

    app(ActivatePlan::class)->handle('chk_123', 'ch_456');

    expect(AffiliateCommission::where('referred_user_id', $referred->id)->count())->toBe(1);
});

test('affiliate withdrawal marks commissions withdrawn and records a transaction', function () {
    $referrerUser = referrer();
    
    $referrerUser->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);
    
    $plan = referralPlan(2000);
    $referred = User::factory()->create(['referred_by' => $referrerUser->id]);
    
    $referredPlan = Plan::create([
        'name' => 'Echo Pro',
        'slug' => 'echo-pro-'.fake()->randomDigit,
        'price' => 12500,
        'voice_earn_per_session' => 150,
        'word_game_per_word' => 75,
        'daily_voice_tasks' => 8,
        'daily_word_tasks' => 8,
        'referral_commission' => 2000,
        'features' => [],
        'is_popular' => false,
        'is_active' => true,
        'sort_order' => 1,
        'admin_charge_amount' => 0,
        'admin_charge_percentage' => 0,
    ]);
    UserSubscription::create([
        'user_id' => $referred->id,
        'plan_id' => $referredPlan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);
    app(ActivatePlan::class)->handle('chk_123', 'ch_456');

    AffiliateCommission::create([
        'referrer_id' => $referrerUser->id,
        'referred_user_id' => $referred->id,
        'plan_id' => $plan->id,
        'amount' => 2000,
        'status' => 'available',
    ]);

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('createPayoutDestination')->once()->andReturn('pd_test');
        $mock->shouldReceive('createPayout')->once()->andReturn(['id' => 'pay_1']);
    });

    $amount = app(WithdrawAffiliateCommission::class)->handle($referrerUser, app(BachsServiceInterface::class));

    expect($amount)->toEqual(2000.0);
    expect($referrerUser->availableAffiliateBalance())->toEqual(0.0);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $referrerUser->id,
        'type' => 'withdrawal',
        'status' => 'successful',
    ]);
});

test('affiliate dashboard page renders for authenticated users', function () {
    $referrerUser = referrer();
    $referrerPlan = Plan::create([
        'name' => 'Echo Pro',
        'slug' => 'echo-pro-'.fake()->randomDigit,
        'price' => 12500,
        'voice_earn_per_session' => 150,
        'word_game_per_word' => 75,
        'daily_voice_tasks' => 8,
        'daily_word_tasks' => 8,
        'referral_commission' => 2000,
        'features' => [],
        'is_popular' => false,
        'is_active' => true,
        'sort_order' => 1,
        'admin_charge_amount' => 0,
        'admin_charge_percentage' => 0,
    ]);
    UserSubscription::create([
        'user_id' => $referrerUser->id,
        'plan_id' => $referrerPlan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);
    app(ActivatePlan::class)->handle('chk_123', 'ch_456');
    
    User::factory()->create(['referred_by' => $referrerUser->id]);

    $this->actingAs($referrerUser);

    $this->get(route('affiliate.index'))
        ->assertOk()
        ->assertSee('Affiliate Dashboard');
});

    test('affiliate earns page renders the top earners', function () {
        $referrerUser = referrer();
        $plan = referralPlan(2000);
        
        $referred = User::factory()->create(['referred_by' => $referrerUser->id]);
        $referredPlan = Plan::create([
            'name' => 'Echo Pro',
            'slug' => 'echo-pro-'.fake()->randomDigit,
            'price' => 12500,
            'voice_earn_per_session' => 150,
            'word_game_per_word' => 75,
            'daily_voice_tasks' => 8,
            'daily_word_tasks' => 8,
            'referral_commission' => 2000,
            'features' => [],
            'is_popular' => false,
            'is_active' => true,
            'sort_order' => 1,
            'admin_charge_amount' => 0,
            'admin_charge_percentage' => 0,
        ]);
        UserSubscription::create([
            'user_id' => $referred->id,
            'plan_id' => $referredPlan->id,
            'status' => 'pending',
            'bachs_checkout_id' => 'chk_123',
        ]);
        app(ActivatePlan::class)->handle('chk_123', 'ch_456');

        AffiliateCommission::create([
            'referrer_id' => $referrerUser->id,
            'referred_user_id' => $referred->id,
            'plan_id' => $plan->id,
            'amount' => 2000,
            'status' => 'available',
        ]);

        $this->actingAs($referrerUser);

        $this->get(route('affiliate.earners'))
            ->assertOk()
            ->assertSee('Affiliate Earners')
            ->assertSee('@'.$referrerUser->username);
    });
