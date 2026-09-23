<?php

namespace App\Providers;

use App\Models\AdminBalance;
use App\Models\AdminPayout;
use App\Models\AffiliateCommission;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use App\Observers\AdminBalanceObserver;
use App\Observers\AdminPayoutObserver;
use App\Observers\AffiliateCommissionObserver;
use App\Observers\PlanObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use App\Observers\UserSubscriptionObserver;
use App\Observers\WalletObserver;
use App\Observers\WithdrawalRequestObserver;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureRateLimiters();
        $this->configureObservers();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Configure rate limiters for payment security.
     */
    protected function configureRateLimiters(): void
    {
        RateLimiter::for('payment-subscribe', fn ($request) => Limit::perMinute(5)->by($request->user()?->id ?: $request->ip()));

        RateLimiter::for('payment-callback', fn ($request) => Limit::perMinute(10)->by($request->user()?->id ?: $request->ip()));

        RateLimiter::for('user-withdraw', fn ($request) => Limit::perMinute(3)->by($request->user()?->id ?: $request->ip()));

        RateLimiter::for('admin-finance', fn ($request) => Limit::perMinute(10)->by($request->user()?->id ?: $request->ip()));

        RateLimiter::for('webhook', fn ($request) => Limit::perMinute(60)->by($request->ip()));

        RateLimiter::for('bank-verify', fn ($request) => Limit::perMinute(10)->by($request->user()?->id ?: $request->ip()));
    }

    /**
     * Configure model observers for audit logging.
     */
    protected function configureObservers(): void
    {
        Transaction::observe(TransactionObserver::class);
        Wallet::observe(WalletObserver::class);
        WithdrawalRequest::observe(WithdrawalRequestObserver::class);
        AdminBalance::observe(AdminBalanceObserver::class);
        AdminPayout::observe(AdminPayoutObserver::class);
        UserSubscription::observe(UserSubscriptionObserver::class);
        Plan::observe(PlanObserver::class);
        User::observe(UserObserver::class);
        AffiliateCommission::observe(AffiliateCommissionObserver::class);
    }
}
