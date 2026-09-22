<?php

namespace Database\Seeders;

use App\Models\AffiliateCommission;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliateCommissionSeeder extends Seeder
{
    public function run(): void
    {
        $plan = Plan::first();
        if (! $plan) {
            $this->command->error('No plans found. Run PlanSeeder first.');

            return;
        }

        DB::table('affiliate_commissions')->truncate();

        $existing = User::where('email', 'like', 'referrer%@example.com')
            ->orWhere('email', 'like', 'referred%@example.com')
            ->pluck('id');

        User::whereIn('id', $existing)->delete();

        for ($i = 1; $i <= 20; $i++) {
            $referrer = User::factory()->create([
                'username' => "referrer{$i}",
                'email' => "referrer{$i}@example.com",
            ]);

            $referred = User::factory()->create([
                'username' => "referred{$i}",
                'email' => "referred{$i}@example.com",
                'referred_by' => $referrer->id,
            ]);

            $amount = 5000 + ($i * 500);

            AffiliateCommission::create([
                'referrer_id' => $referrer->id,
                'referred_user_id' => $referred->id,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'status' => 'available',
            ]);
        }

        $this->command->info('Created 20 affiliate referrers with commissions.');
    }
}
