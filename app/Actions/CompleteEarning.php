<?php

namespace App\Actions;

use App\Models\EarningPrompt;
use App\Models\EarningSubmission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CompleteEarning
{
    public function handle(User $user, string $type, EarningPrompt $prompt, string $audioPath, ?int $duration = null): EarningSubmission
    {
        $plan = $user->currentPlan();

        if (! $plan) {
            throw new RuntimeException('You need an active plan to start earning.');
        }

        $this->assertWithinDailyLimit($user, $type, $plan);

        $rate = $type === 'sentence'
            ? (float) $plan->voice_earn_per_session
            : (float) $plan->word_game_per_word;

        return DB::transaction(function () use ($user, $type, $prompt, $audioPath, $duration, $rate) {
            $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->first();

            if (! $wallet) {
                $wallet = Wallet::create(['user_id' => $user->id, 'balance' => 0]);
            }

            $wallet->increment('balance', $rate);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'earning',
                'amount' => $rate,
                'description' => $type === 'sentence' ? 'Voice Earn session' : 'Word Game',
                'reference' => Transaction::generateReference(),
                'status' => 'successful',
                'metadata' => [
                    'kind' => $type === 'sentence' ? 'voice' : 'word',
                    'language' => $prompt->language,
                    'prompt_id' => $prompt->id,
                    'rate' => $rate,
                ],
            ]);

            return EarningSubmission::create([
                'user_id' => $user->id,
                'prompt_id' => $prompt->id,
                'type' => $type,
                'language' => $prompt->language,
                'audio_path' => $audioPath,
                'audio_duration' => $duration,
                'amount' => $rate,
                'status' => 'completed',
            ]);
        });
    }

    private function assertWithinDailyLimit(User $user, string $type, $plan): void
    {
        $limit = $type === 'sentence'
            ? (int) $plan->daily_voice_tasks
            : (int) $plan->daily_word_tasks;

        $count = EarningSubmission::where('user_id', $user->id)
            ->where('type', $type)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        if ($count >= $limit) {
            throw new RuntimeException('You have reached your daily limit for this task.');
        }
    }
}
