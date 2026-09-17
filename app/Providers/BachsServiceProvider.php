<?php

namespace App\Providers;

use App\Services\Bachs\BachsService;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Illuminate\Support\ServiceProvider;

class BachsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BachsServiceInterface::class, BachsService::class);
    }

    public function boot(): void
    {
        //
    }
}
