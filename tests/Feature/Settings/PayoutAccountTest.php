<?php

use App\Models\User;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;

uses(LazilyRefreshDatabase::class);

test('payout page is displayed with the list of banks', function () {
    $this->actingAs(User::factory()->create());

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('listBanks')->andReturn([
            ['name' => 'Providus Bank', 'code' => '101'],
            ['name' => 'Sterling Bank', 'code' => '232'],
        ]);
    });

    $this->get(route('payout.edit'))
        ->assertOk()
        ->assertSee('Providus Bank')
        ->assertSee('Sterling Bank');
});

test('resolves the account name from the bank and account number', function () {
    $this->actingAs(User::factory()->create());

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('listBanks')->andReturn([
            ['name' => 'Providus Bank', 'code' => '101'],
        ]);
        $mock->shouldReceive('resolveBankAccount')
            ->with('0123456789', '101')
            ->andReturn(['resolved' => true, 'account_name' => 'ADA OKAFOR']);
    });

    Livewire::test('pages::settings.payout')
        ->set('bankCode', '101')
        ->set('accountNumber', '0123456789')
        ->call('verify')
        ->assertSet('resolved', true)
        ->assertSet('resolvedName', 'ADA OKAFOR');
});

test('saves a resolved payout account', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('listBanks')->andReturn([
            ['name' => 'Providus Bank', 'code' => '101'],
        ]);
        $mock->shouldReceive('resolveBankAccount')->andReturn(['resolved' => true, 'account_name' => 'ADA OKAFOR']);
    });

    Livewire::test('pages::settings.payout')
        ->set('bankCode', '101')
        ->set('accountNumber', '0123456789')
        ->set('resolvedName', 'ADA OKAFOR')
        ->set('resolved', true)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('payout_accounts', [
        'user_id' => $user->id,
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);
});

test('prevents linking a payout account already used by another user', function () {
    $other = User::factory()->create();
    $other->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'OTHER PERSON',
    ]);

    $this->actingAs(User::factory()->create());

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('listBanks')->andReturn([
            ['name' => 'Providus Bank', 'code' => '101'],
        ]);
        $mock->shouldReceive('resolveBankAccount')->andReturn(['resolved' => true, 'account_name' => 'ADA OKAFOR']);
    });

    Livewire::test('pages::settings.payout')
        ->set('bankCode', '101')
        ->set('accountNumber', '0123456789')
        ->set('resolvedName', 'ADA OKAFOR')
        ->set('resolved', true)
        ->call('save')
        ->assertHasErrors('accountNumber');

    $this->assertDatabaseCount('payout_accounts', 1);
});
