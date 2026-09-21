<?php

use App\Actions\WithdrawEarnings;
use App\Models\EarningPrompt;
use App\Models\EarningSubmission;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use RuntimeException;

uses(LazilyRefreshDatabase::class);

function withdrawUser(float $balance = 100): User
{
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => $balance]);
    $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    return $user;
}

function makeSubmission(User $user, int $daysAgo = 3): EarningSubmission
{
    $submission = EarningSubmission::create([
        'user_id' => $user->id,
        'prompt_id' => EarningPrompt::create(['type' => 'sentence', 'language' => 'yo', 'text' => 'Ẹ káàárọ̀ o.'])->id,
        'type' => 'sentence',
        'language' => 'yo',
        'audio_path' => 'earnings/1/abc.webm',
        'amount' => 50,
        'status' => 'completed',
    ]);

    $submission->forceFill(['created_at' => now()->subDays($daysAgo)])->save();

    return $submission;
}

test('creates a request, zeros the wallet, and records a transaction', function () {
    $user = withdrawUser(100);
    makeSubmission($user);

    $request = app(WithdrawEarnings::class)->handle($user);

    expect($request)->toBeInstanceOf(WithdrawalRequest::class);
    expect((float) $user->wallet()->first()->balance)->toEqual(0.0);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'type' => 'withdrawal',
        'status' => 'pending',
    ]);

    $this->assertDatabaseHas('earning_submissions', [
        'user_id' => $user->id,
        'withdrawal_request_id' => $request->id,
    ]);
});

test('rejects when the user has no payout account', function () {
    $user = User::factory()->create();
    $user->wallet()->create(['balance' => 100]);

    app(WithdrawEarnings::class)->handle($user);
})->throws(RuntimeException::class, 'payout account');

test('rejects when the user has no balance', function () {
    $user = User::factory()->create();
    $user->payoutAccount()->create([
        'bank_name' => 'Providus Bank',
        'bank_code' => '101',
        'account_number' => '0123456789',
        'account_name' => 'ADA OKAFOR',
    ]);

    app(WithdrawEarnings::class)->handle($user);
})->throws(RuntimeException::class, 'no earnings');

test('marks the request as early when a task is younger than two weeks', function () {
    $user = withdrawUser(100);
    makeSubmission($user, 2);

    $request = app(WithdrawEarnings::class)->handle($user);

    expect($request->early_withdrawal)->toBeTrue();
});

test('does not mark early when all tasks are older than two weeks', function () {
    $user = withdrawUser(100);
    makeSubmission($user, 20);

    $request = app(WithdrawEarnings::class)->handle($user);

    expect($request->early_withdrawal)->toBeFalse();
});
