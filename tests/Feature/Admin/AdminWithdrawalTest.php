<?php

use App\Models\EarningPrompt;
use App\Models\EarningSubmission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

function adminUser(): User
{
    return User::factory()->create(['email' => 'admin@vocalpay.co']);
}

function pendingRequest(): WithdrawalRequest
{
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 100]);
    $payout = $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    $request = WithdrawalRequest::create([
        'user_id' => $user->id,
        'payout_account_id' => $payout->id,
        'amount' => 100,
        'status' => 'pending',
        'requested_at' => now(),
    ]);

    EarningSubmission::create([
        'user_id' => $user->id,
        'prompt_id' => EarningPrompt::create(['type' => 'sentence', 'language' => 'yo', 'text' => 'Ẹ káàárọ̀ o.'])->id,
        'type' => 'sentence',
        'language' => 'yo',
        'audio_path' => 'earnings/1/abc.webm',
        'amount' => 50,
        'status' => 'completed',
        'withdrawal_request_id' => $request->id,
    ]);

    Transaction::create([
        'user_id' => $user->id,
        'type' => 'withdrawal',
        'amount' => 100,
        'reference' => 'VP-TEST-WD',
        'status' => 'pending',
        'metadata' => ['withdrawal_request_id' => $request->id],
    ]);

    return $request;
}

test('admin can view the withdrawal review list', function () {
    $this->actingAs(adminUser());

    $this->get(route('admin.withdrawals.index'))
        ->assertOk()
        ->assertSee('Withdrawal Review');
});

test('admin can view a withdrawal review page', function () {
    $this->actingAs(adminUser());

    $request = pendingRequest();

    $this->get(route('admin.withdrawals.review', $request))
        ->assertOk()
        ->assertSee('Review Withdrawal')
        ->assertSee('Approve & pay');
});

test('approving a request marks it approved and pays out', function () {
    $this->actingAs(adminUser());

    $this->mock(BachsServiceInterface::class, function ($mock) {
        $mock->shouldReceive('createPayoutDestination')->once()->andReturn('pd_test');
        $mock->shouldReceive('createPayout')->once()->andReturn(['id' => 'pay_1', 'reference' => 'WD-1']);
    });

    $request = pendingRequest();

    $this->post(route('admin.withdrawals.approve', $request))
        ->assertRedirect(route('admin.withdrawals.index'));

    expect($request->fresh()->status)->toBe('approved');
    $this->assertDatabaseHas('transactions', [
        'status' => 'successful',
        'type' => 'withdrawal',
    ]);
});

test('declining with spamming bans the user for a week', function () {
    $this->actingAs(adminUser());

    $request = pendingRequest();

    $this->post(route('admin.withdrawals.decline', $request), ['decline_reason' => 'spamming'])
        ->assertRedirect(route('admin.withdrawals.index'));

    $request->refresh();

    expect($request->status)->toBe('declined');
    expect($request->user->isBanned())->toBeTrue();
});

test('a banned user is redirected to login', function () {
    $user = User::factory()->create(['banned_until' => now()->addWeek()]);

    $this->actingAs($user);

    $this->get(route('dashboard'))->assertRedirect(route('login'));

    expect(auth()->check())->toBeFalse();
});
