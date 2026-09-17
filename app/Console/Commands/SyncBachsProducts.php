<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Illuminate\Console\Command;

class SyncBachsProducts extends Command
{
    protected $signature = 'bachs:sync-products';

    protected $description = 'Create products on Bachs for all plans and store their product IDs';

    public function handle(BachsServiceInterface $bachs): int
    {
        $plans = Plan::whereNull('bachs_product_id')->get();

        if ($plans->isEmpty()) {
            $this->info('All plans already have Bachs product IDs.');

            return self::SUCCESS;
        }

        $this->info("Syncing {$plans->count()} plan(s) to Bachs...");

        foreach ($plans as $plan) {
            $this->line("Creating product: {$plan->name} (₦{$plan->price})...");

            try {
                $productId = $bachs->createProduct(
                    name: $plan->name,
                    amount: number_format((float) $plan->price, 2, '.', ''),
                    currency: 'NGN',
                    description: "VocalPay {$plan->name} plan - lifetime access",
                );

                $plan->update(['bachs_product_id' => $productId]);

                $this->info("  Created: {$productId}");
            } catch (\Exception $e) {
                $this->error("  Failed: {$e->getMessage()}");

                return self::FAILURE;
            }
        }

        $this->info('All products synced successfully.');

        return self::SUCCESS;
    }
}
