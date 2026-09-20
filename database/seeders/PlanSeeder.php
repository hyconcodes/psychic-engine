<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Voice Spark',
                'slug' => 'voice-spark',
                'price' => 7500,
                'voice_earn_per_session' => 100,
                'word_game_per_word' => 50,
                'daily_voice_tasks' => 5,
                'daily_word_tasks' => 5,
                'features' => [
                    'Basic voice earning tasks',
                    'Word game access',
                    '₦100 per Voice Earn session',
                    '₦50 per Word Game',
                    '5 voice & 5 word tasks daily',
                    'Basic support',
                ],
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Echo Pro',
                'slug' => 'echo-pro',
                'price' => 12500,
                'voice_earn_per_session' => 150,
                'word_game_per_word' => 75,
                'daily_voice_tasks' => 8,
                'daily_word_tasks' => 8,
                'features' => [
                    'All Voice Spark features',
                    'Increased voice earning rates',
                    '₦150 per Voice Earn session',
                    '₦75 per Word Game',
                    '8 voice & 8 word tasks daily',
                    'Priority support',
                ],
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Vox Elite',
                'slug' => 'vox-elite',
                'price' => 15000,
                'voice_earn_per_session' => 250,
                'word_game_per_word' => 100,
                'daily_voice_tasks' => 10,
                'daily_word_tasks' => 15,
                'features' => [
                    'All Echo Pro features',
                    'Premium voice earning rates',
                    '₦250 per Voice Earn session',
                    '₦100 per Word Game',
                    '10 voice & 15 word tasks daily',
                    'Premium support',
                ],
                'is_popular' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Prime Vocal',
                'slug' => 'prime-vocal',
                'price' => 25000,
                'voice_earn_per_session' => 400,
                'word_game_per_word' => 200,
                'daily_voice_tasks' => 15,
                'daily_word_tasks' => 25,
                'features' => [
                    'All Vox Elite features',
                    'Maximum voice earning rates',
                    '₦400 per Voice Earn session',
                    '₦200 per Word Game',
                    '15 voice & 25 word tasks daily',
                    'VIP support',
                ],
                'is_popular' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
