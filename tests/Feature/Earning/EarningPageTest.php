<?php

use App\Models\EarningPrompt;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    EarningPrompt::create([
        'type' => 'sentence',
        'language' => 'yo',
        'text' => 'Ẹ káàárọ̀ o.',
    ]);
    EarningPrompt::create([
        'type' => 'word',
        'language' => 'yo',
        'text' => 'àlàáfíà',
    ]);
});

function planUser(): User
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

test('guests are redirected to login', function () {
    $this->get(route('earn.index'))->assertRedirect(route('login'));
    $this->get(route('earn.voice'))->assertRedirect(route('login'));
    $this->get(route('earn.word-game'))->assertRedirect(route('login'));
});

test('earn hub lists the available tasks for today', function () {
    $this->actingAs(planUser());

    $this->get(route('earn.index'))
        ->assertOk()
        ->assertSee('Voice Earn')
        ->assertSee('Word Game')
        ->assertSee('left today');
});

test('voice earn page renders and defaults to select language', function () {
    $this->actingAs(planUser());

    $this->get(route('earn.voice'))
        ->assertOk()
        ->assertSee('Voice Earn')
        ->assertSee('Select your language');
});

test('word game page renders and defaults to select language', function () {
    $this->actingAs(planUser());

    $this->get(route('earn.word-game'))
        ->assertOk()
        ->assertSee('Word Game')
        ->assertSee('Select your language');
});

test('shows an activation prompt when the user has no plan', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('earn.index'))
        ->assertOk()
        ->assertSee('Activate a plan to start earning');
});
