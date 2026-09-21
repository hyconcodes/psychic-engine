<?php

use App\Actions\WithdrawEarnings;
use App\Models\EarningSubmission;
use App\Models\Transaction;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Withdraw')] class extends Component {
    public string $balance = '₦0.00';

    public float $balanceRaw = 0;

    public float $voiceEarnings = 0;

    public float $wordEarnings = 0;

    public bool $hasPayoutAccount = false;

    public array $recentWithdrawals = [];

    public function mount(): void
    {
        $this->load();
    }

    public function load(): void
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        $this->balanceRaw = $wallet ? (float) $wallet->balance : 0.0;
        $this->balance = '₦'.number_format($this->balanceRaw, 2);

        $this->voiceEarnings = (float) EarningSubmission::where('user_id', $user->id)
            ->where('type', 'sentence')
            ->whereNull('withdrawal_request_id')
            ->sum('amount');

        $this->wordEarnings = (float) EarningSubmission::where('user_id', $user->id)
            ->where('type', 'word')
            ->whereNull('withdrawal_request_id')
            ->sum('amount');

        $this->hasPayoutAccount = (bool) $user->payoutAccount;

        $this->recentWithdrawals = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (Transaction $transaction) => [
                'amount' => $transaction->formattedAmount(),
                'status' => $transaction->status,
                'date' => $transaction->created_at->format('M d, Y'),
                'datetime' => $transaction->created_at->format('M d, Y \a\t h:i A'),
                'reference' => $transaction->reference,
                'description' => $transaction->description,
                'decline_reason' => $transaction->metadata['decline_reason'] ?? null,
                'deduct_amount' => $transaction->metadata['deduct_amount'] ?? null,
                'deduct_reason' => $transaction->metadata['deduct_reason'] ?? null,
                'original_amount' => $transaction->metadata['original_amount'] ?? null,
            ])
            ->toArray();
    }

    public function withdraw(WithdrawEarnings $withdraw): void
    {
        try {
            $withdraw->handle(Auth::user());
        } catch (RuntimeException $e) {
            Flux::toast(variant: 'error', text: $e->getMessage());

            return;
        }

        Flux::toast(variant: 'success', text: __('Your tasks are under review — expect your money ASAP.'));

        $this->load();
    }
}; ?>

<div class="space-y-6" x-data="{ tab: 'tasks' }">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
            <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Withdraw') }}</h2>
            <p class="text-xs text-text/50">{{ __('Send your earnings to your bank account') }}</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="bg-neutral-100 dark:bg-neutral-800 rounded-full p-1 flex">
        <button @click="tab = 'tasks'" :class="tab === 'tasks' ? 'bg-white dark:bg-neutral-700 shadow-sm text-text font-semibold' : 'text-text/50 hover:text-text/70'" class="flex-1 py-2 rounded-full text-sm transition-all cursor-pointer">
            {{ __('Tasks withdraw') }}
        </button>
        <button @click="tab = 'affiliate'" :class="tab === 'affiliate' ? 'bg-white dark:bg-neutral-700 shadow-sm text-text font-semibold' : 'text-text/50 hover:text-text/70'" class="flex-1 py-2 rounded-full text-sm transition-all cursor-pointer">
            {{ __('Affiliate withdraw') }}
        </button>
    </div>

    {{-- Tasks tab --}}
    <div x-show="tab === 'tasks'" class="space-y-5">
        {{-- Balance card --}}
        <div class="bg-gradient-to-br from-primary via-primary to-secondary rounded-2xl p-6 relative overflow-hidden shadow-2xl shadow-primary/25 ring-1 ring-white/10">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4 blur-xl"></div>
            <div class="relative">
                <p class="text-xs text-white/60 uppercase tracking-wider mb-1">{{ __('Available to withdraw') }}</p>
                <p class="text-3xl sm:text-4xl font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $balance }}</p>
                <div class="flex items-center gap-4 mt-3 text-xs text-white/80">
                    <span>{{ __('Voice') }}: ₦{{ number_format($voiceEarnings, 2) }}</span>
                    <span>{{ __('Word') }}: ₦{{ number_format($wordEarnings, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Payout account --}}
        @if (! $hasPayoutAccount)
            <a href="{{ route('payout.edit') }}" wire:navigate class="flex items-center gap-2 w-fit px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-semibold border border-primary/20 hover:bg-primary/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                {{ __('Link your account') }}
            </a>
        @endif

        {{-- 2-week notice --}}
        <div class="rounded-xl bg-amber-50 dark:bg-amber-900/15 border border-amber-200 dark:border-amber-800/30 px-4 py-3">
            <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">{{ __('Withdraw after 14 days / 2 weeks of a completed task. Do not withdraw early.') }}</p>
        </div>

        {{-- Withdraw button --}}
        <button
            type="button"
            wire:click="withdraw"
            @if (! $hasPayoutAccount || $balanceRaw <= 0) disabled @endif
            class="w-full py-4 rounded-xl font-semibold text-white transition-all flex items-center justify-center gap-2 {{ (! $hasPayoutAccount || $balanceRaw <= 0) ? 'bg-gray-300 dark:bg-neutral-800 text-text/40 cursor-not-allowed' : 'bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 shadow-lg shadow-primary/20 cursor-pointer' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            {{ __('Withdraw') }} {{ $balance }}
        </button>

        {{-- Recent payouts --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-text">{{ __('Recent payouts') }}</h3>
                <a href="{{ route('transactions.index') }}" wire:navigate class="text-xs font-medium text-primary hover:text-primary/80">{{ __('See more') }}</a>
            </div>

            @if (count($recentWithdrawals) > 0)
                <div class="space-y-2">
                    @foreach ($recentWithdrawals as $withdrawal)
                        <div x-data="{ open: false }" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-text">{{ $withdrawal['amount'] }}</p>
                                        <p class="text-[11px] text-text/40">{{ $withdrawal['date'] }}</p>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold px-2 py-1 rounded-full {{ $withdrawal['status'] === 'successful' ? 'bg-green-500/10 text-green-600 dark:text-green-400' : ($withdrawal['status'] === 'failed' ? 'bg-red-500/10 text-red-600 dark:text-red-400' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400') }}">
                                    {{ ucfirst($withdrawal['status']) }}
                                </span>
                            </div>

                            <button @click="open = !open" class="w-full flex items-center justify-center gap-1 py-2 border-t border-gray-100 dark:border-neutral-800 text-[11px] font-medium text-primary hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors cursor-pointer">
                                <span x-text="open ? '{{ __('See less') }}' : '{{ __('See more') }}'"></span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </button>

                            <div x-show="open" x-cloak class="px-4 pb-4 pt-3 space-y-2 border-t border-gray-100 dark:border-neutral-800">
                                <div class="flex items-center justify-between text-xs gap-4">
                                    <span class="text-text/40 shrink-0">{{ __('Reference') }}</span>
                                    <span class="text-text/70 font-mono truncate text-right">{{ $withdrawal['reference'] }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-text/40">{{ __('Status') }}</span>
                                    <span class="text-text/70">{{ ucfirst($withdrawal['status']) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-text/40">{{ __('Date') }}</span>
                                    <span class="text-text/70">{{ $withdrawal['datetime'] }}</span>
                                </div>
                                @if ($withdrawal['original_amount'])
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-text/40">{{ __('Original amount') }}</span>
                                        <span class="text-text/70">₦{{ number_format((float) $withdrawal['original_amount'], 2) }}</span>
                                    </div>
                                @endif
                                @if ($withdrawal['deduct_amount'])
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-text/40">{{ __('Deduction') }}</span>
                                        <span class="text-red-600 dark:text-red-400">-₦{{ number_format((float) $withdrawal['deduct_amount'], 2) }}</span>
                                    </div>
                                @endif
                                @if ($withdrawal['deduct_reason'])
                                    <div class="flex items-start justify-between text-xs gap-4">
                                        <span class="text-text/40 shrink-0">{{ __('Deduction reason') }}</span>
                                        <span class="text-text/70 text-right">{{ \App\Models\WithdrawalRequest::DEDUCTION_REASONS[$withdrawal['deduct_reason']] ?? $withdrawal['deduct_reason'] }}</span>
                                    </div>
                                @endif
                                @if ($withdrawal['decline_reason'])
                                    <div class="flex items-start justify-between text-xs gap-4">
                                        <span class="text-text/40 shrink-0">{{ __('Reason') }}</span>
                                        <span class="text-red-600 dark:text-red-400 text-right">{{ \App\Models\WithdrawalRequest::DECLINE_REASONS[$withdrawal['decline_reason']] ?? $withdrawal['decline_reason'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-8 text-center">
                    <p class="text-sm text-text/40">{{ __('No withdrawals yet') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Affiliate tab --}}
    <div x-show="tab === 'affiliate'" class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-10 text-center shadow-sm">
        <div class="w-16 h-16 bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-text/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
        </div>
        <h3 class="text-sm font-semibold text-text">{{ __('No affiliate earnings yet') }}</h3>
        <p class="text-xs text-text/40 mt-1">{{ __('Affiliate withdrawals will be available soon.') }}</p>
    </div>
</div>
