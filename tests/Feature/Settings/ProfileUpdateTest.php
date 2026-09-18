<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get(route('profile.edit'))->assertOk();
});

test('profile page shows the user name and email', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('profile page shows the phone number and two-factor status', function () {
    $user = User::factory()->create(['phone' => '08012345678']);

    $this->actingAs($user);

    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('08012345678')
        ->assertSee('Not enabled');
});

test('profile page shows the linked payout account', function () {
    $user = User::factory()->create();
    $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    $this->actingAs($user);

    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Providus Bank')
        ->assertSee('0123456789')
        ->assertSee('ADA OKAFOR');
});
