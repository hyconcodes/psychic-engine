<?php

use App\Actions\ActivatePlan;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

test('guests are redirected to login', function () {
    $this->get(route('withdraw.index'))->assertRedirect(route('login'));
});

test('withdraw page shows the balance and withdraw button', function () {
    $user = User::factory()->create();
    $plan = Plan::create([
        'name' => 'Echo Pro',
        'slug' => 'echo-pro',
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
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);
    app(ActivatePlan::class)->handle('chk_123', 'ch_456');
    
    $user->wallet()->create(['balance' => 250]);
    $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    $this->actingAs($user);

    $this->get(route('withdraw.index'))
        ->assertOk()
        ->assertSee('Tasks withdraw')
        ->assertSee('₦250.00')
        ->assertSee('Withdraw');
});

    test('withdraw page shows a link account prompt when no payout account is linked', function () {
        $user = User::factory()->create();
        $plan = Plan::create([
            'name' => 'Echo Pro',
            'slug' => 'echo-pro',
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
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
            'bachs_checkout_id' => 'chk_123',
        ]);
        app(ActivatePlan::class)->handle('chk_123', 'ch_456');
        
        $user->wallet()->create(['balance' => 100]);

        $this->actingAs($user);

        $this->get(route('withdraw.index'))
            ->assertOk()
            ->assertSee('Link your account');
    });

test('withdraw requires the correct password', function () {
    $user = User::factory()->create();
    
    $plan = Plan::create([
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
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'status' => 'pending',
        'bachs_checkout_id' => 'chk_123',
    ]);
    app(ActivatePlan::class)->handle('chk_123', 'ch_456');
    
    $user->wallet()->create(['balance' => 100]);
    $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    $this->actingAs($user);

    Livewire::test('pages::withdraw')
        ->set('password', 'wrong-password')
        ->call('withdraw')
        ->assertHasErrors('password');
});

    test('withdraw succeeds with the correct password', function () {
        $user = User::factory()->create();
        
        $plan = Plan::create([
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
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
            'bachs_checkout_id' => 'chk_123',
        ]);
        app(ActivatePlan::class)->handle('chk_123', 'ch_456');
        
        $user->wallet()->create(['balance' => 100]);
        $user->payoutAccount()->create([
            'bank_name' => 'Providus Bank',
            'bank_code' => '101',
            'account_number' => '0123456789',
            'account_name' => 'ADA OKAFOR',
        ]);

        $this->actingAs($user);

        Livewire::test('pages::withdraw')
            ->set('password', 'password')
            ->call('withdraw')
            ->assertHasNoErrors();

        expect((float) $user->wallet()->first()->balance)->toEqual(0.0);
    });
