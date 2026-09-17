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
                'features' => [
                    'Basic voice earning tasks',
                    'Word game access',
                    '₦100 per Voice Earn session',
                    '₦50 per Word Game',
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
                'features' => [
                    'All Voice Spark features',
                    'Increased voice earning rates',
                    '₦150 per Voice Earn session',
                    '₦75 per Word Game',
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
                'features' => [
                    'All Echo Pro features',
                    'Premium voice earning rates',
                    '₦250 per Voice Earn session',
                    '₦100 per Word Game',
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
                'features' => [
                    'All Vox Elite features',
                    'Maximum voice earning rates',
                    '₦400 per Voice Earn session',
                    '₦200 per Word Game',
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
