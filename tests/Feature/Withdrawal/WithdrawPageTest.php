<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

test('guests are redirected to login', function () {
    $this->get(route('withdraw.index'))->assertRedirect(route('login'));
});

test('withdraw page shows the balance and withdraw button', function () {
    $user = User::factory()->create();
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
    $user->wallet()->create(['balance' => 100]);

    $this->actingAs($user);

    $this->get(route('withdraw.index'))
        ->assertOk()
        ->assertSee('Link your account');
});

test('withdraw requires the correct password', function () {
    $user = User::factory()->create();
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
