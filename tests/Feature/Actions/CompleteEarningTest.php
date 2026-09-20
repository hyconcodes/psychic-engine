<?php

use App\Actions\CompleteEarning;
use App\Models\EarningPrompt;
use App\Models\EarningSubmission;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use RuntimeException;

uses(LazilyRefreshDatabase::class);

function makePlanUser(): User
{
    $user = User::factory()->create();

    $plan = Plan::create([
        'name' => 'Voice Spark',
        'slug' => 'voice-spark',
        'price' => 7500,
        'voice_earn_per_session' => 100,
        'word_game_per_word' => 50,
        'daily_voice_tasks' => 5,
        'daily_word_tasks' => 5,
        'sort_order' => 1,
    ]);

    UserSubscription::create([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'status' => 'active',
        'activated_at' => now(),
    ]);

    return $user;
}

function makePrompt(string $type = 'sentence'): EarningPrompt
{
    return EarningPrompt::create([
        'type' => $type,
        'language' => 'yo',
        'text' => $type === 'sentence' ? 'Ẹ káàárọ̀ o, ẹ káàbọ̀ sí VocalPay.' : 'àlàáfíà',
    ]);
}

test('credits the wallet and records a submission and transaction', function () {
    $user = makePlanUser();
    $prompt = makePrompt();

    $submission = app(CompleteEarning::class)->handle($user, 'sentence', $prompt, 'earnings/1/abc.webm', 5);

    expect($submission)->toBeInstanceOf(EarningSubmission::class);
    expect((float) $user->wallet()->first()->balance)->toEqual(100.0);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'type' => 'earning',
        'status' => 'successful',
    ]);

    $this->assertDatabaseHas('earning_submissions', [
        'user_id' => $user->id,
        'prompt_id' => $prompt->id,
        'type' => 'sentence',
        'amount' => 100.00,
        'audio_path' => 'earnings/1/abc.webm',
    ]);
});

test('uses the word rate for word submissions', function () {
    $user = makePlanUser();
    $prompt = makePrompt('word');

    app(CompleteEarning::class)->handle($user, 'word', $prompt, 'earnings/1/abc.webm');

    expect((float) $user->wallet()->first()->balance)->toEqual(50.0);
});

test('rejects when the user has no active plan', function () {
    $user = User::factory()->create();
    $prompt = makePrompt();

    app(CompleteEarning::class)->handle($user, 'sentence', $prompt, 'earnings/1/abc.webm');
})->throws(RuntimeException::class, 'active plan');

test('rejects when the daily limit is reached', function () {
    $user = makePlanUser();
    $prompt = makePrompt();

    for ($i = 0; $i < 5; $i++) {
        EarningSubmission::create([
            'user_id' => $user->id,
            'prompt_id' => $prompt->id,
            'type' => 'sentence',
            'language' => 'yo',
            'audio_path' => "earnings/1/{$i}.webm",
            'amount' => 100,
            'status' => 'completed',
        ]);
    }

    app(CompleteEarning::class)->handle($user, 'sentence', $prompt, 'earnings/1/new.webm');
})->throws(RuntimeException::class, 'daily limit');
