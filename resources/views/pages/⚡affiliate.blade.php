<?php

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Affiliate Dashboard')] class extends Component {
    public array $referrals = [];

    public float $totalCommission = 0;

    public float $availableBalance = 0;

    public int $totalReferrals = 0;

    public int $activeReferrals = 0;

    public int $pendingReferrals = 0;

    public array $commissionPerPlan = [];

    public string $referralLink = '';

    public function mount(): void
    {
        $this->load();
    }

    public function load(): void
    {
        $user = Auth::user();

        $this->totalCommission = (float) $user->affiliateCommissions()->sum('amount');
        $this->availableBalance = $user->availableAffiliateBalance();

        $commissions = $user->affiliateCommissions()->get()->keyBy('referred_user_id');

        $referrals = $user->referrals()
            ->with('activeSubscription.plan')
            ->latest()
            ->get();

        $this->totalReferrals = $referrals->count();
        $this->activeReferrals = $referrals->filter(fn ($r) => $r->activeSubscription !== null)->count();
        $this->pendingReferrals = $this->totalReferrals - $this->activeReferrals;

        $this->referrals = $referrals->map(function ($referral) use ($commissions) {
            $commission = $commissions->get($referral->id);

            return [
                'name' => $referral->name,
                'username' => $referral->username,
                'plan' => $referral->activeSubscription?->plan?->name,
                'commission' => $commission ? (float) $commission->amount : null,
            ];
        })->toArray();

        $this->commissionPerPlan = Plan::ordered()->get()->map(fn (Plan $plan) => [
            'name' => $plan->name,
            'commission' => (float) $plan->referral_commission,
        ])->toArray();

        $this->referralLink = route('register').'?ref='.$user->username;
    }
}; ?>

<div class="space-y-5">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
            <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Affiliate Dashboard') }}</h2>
            <p class="text-xs text-text/50">{{ __('Your referrals and commission') }}</p>
        </div>
        <x-refresh-button class="ml-auto" />
    </div>

    {{-- Summary cards --}}
    <div class="grid grid-cols-3 gap-2.5">
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 shadow-sm">
            <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalCommission, 2) }}</p>
            <p class="text-[10px] text-text/40 mt-0.5">{{ __('Total earned') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 shadow-sm">
            <p class="text-lg font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($availableBalance, 2) }}</p>
            <p class="text-[10px] text-text/40 mt-0.5">{{ __('Available') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 shadow-sm">
            <p class="text-lg font-bold text-primary" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $totalReferrals }}</p>
            <p class="text-[10px] text-text/40 mt-0.5">{{ __('Referrals') }}</p>
        </div>
    </div>

    {{-- Copy referral link --}}
    <div
        x-data="{
            referralLink: @js($referralLink),
            async copy() {
                try {
                    await navigator.clipboard.writeText(this.referralLink);
                    $flux.toast('{{ __('Referral link copied.') }}', { variant: 'success' });
                } catch {
                    const textarea = document.createElement('textarea');
                    textarea.value = this.referralLink;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    textarea.remove();
                }
            }
        }"
        class="flex items-center gap-2 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm"
    >
        <div class="flex-1 bg-gray-50 dark:bg-neutral-800 rounded-lg px-3 py-2 text-[11px] text-text/50 font-mono truncate">{{ $referralLink }}</div>
        <button type="button" @click="copy()" class="px-3 py-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white text-[11px] font-semibold rounded-lg transition-all shrink-0 cursor-pointer shadow-sm">
            {{ __('Copy') }}
        </button>
    </div>

    {{-- Commission per plan --}}
    <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
        <h3 class="text-xs font-semibold text-text mb-2.5">{{ __('Commission per plan activated') }}</h3>
        <div class="space-y-1.5">
            @foreach ($commissionPerPlan as $item)
                <div class="flex items-center justify-between text-xs">
                    <span class="text-text/60">{{ $item['name'] }}</span>
                    <span class="font-semibold text-green-600">₦{{ number_format($item['commission'], 0) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Referrals list --}}
    <div>
        <h3 class="text-xs font-semibold text-text mb-2.5">{{ __('Your referrals') }} ({{ $totalReferrals }})</h3>

        @if (count($referrals) > 0)
            <div class="space-y-2">
                @foreach ($referrals as $referral)
                    <div class="flex items-center gap-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ \Illuminate\Support\Str::initials($referral['name'], true) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-text truncate">{{ $referral['name'] }}</p>
                            <p class="text-[10px] text-text/40">{{ '@'.$referral['username'] }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-[11px] font-medium text-text">{{ $referral['plan'] ?? '—' }}</p>
                            @if ($referral['commission'] !== null)
                                <p class="text-[10px] text-green-600 font-semibold">+₦{{ number_format($referral['commission'], 0) }}</p>
                            @else
                                <p class="text-[10px] text-amber-500">{{ __('Pending') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-8 text-center">
                <p class="text-sm text-text/40">{{ __('No referrals yet. Share your link to start earning.') }}</p>
            </div>
        @endif
    </div>
</div>
