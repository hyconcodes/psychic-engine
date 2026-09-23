<x-layouts::app :title="__('Dashboard')">
    @php
        $user = auth()->user();
        $currentPlan = $user->currentPlan();
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->formattedBalance() : '₦0.00';
        $tasksCompletedToday = $user->earningSubmissions()
            ->where('created_at', '>=', now()->startOfDay())
            ->count();
        $dailyTasksTotal = $currentPlan
            ? ((int) $currentPlan->daily_voice_tasks + (int) $currentPlan->daily_word_tasks)
            : 0;
        $totalWithdrawn = (float) $user->transactions()
            ->where('type', 'withdrawal')
            ->where('status', 'successful')
            ->sum('amount');
        $totalReferrals = $user->referrals()->count();
        $activeReferrals = $user->referrals()->whereHas('activeSubscription')->count();
        $pendingReferrals = $totalReferrals - $activeReferrals;
        $recentTransactions = $user->transactions()->latest()->take(5)->get();
    @endphp
    <div class="space-y-5">

        {{-- Mobile Header --}}
        <div class="flex items-center justify-between lg:hidden">
            <div class="flex items-center gap-2.5">
                <div class="relative shrink-0">
                    <div class="absolute -inset-0.5 bg-gradient-to-br from-primary to-secondary rounded-full blur-sm opacity-60"></div>
                    <div class="w-9 h-9 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-xs font-bold relative ring-2 ring-white dark:ring-neutral-900 shadow-md shadow-primary/30">
                        {{ $user->initials() }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white dark:border-neutral-900"></div>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] text-text/40 tracking-wide">Good {{ now()->format('A') < 12 ? 'morning' : (now()->format('A') < 17 ? 'afternoon' : 'evening') }}</p>
                    <span class="text-sm font-extrabold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent leading-tight truncate block" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $user->name }}</span>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <x-refresh-button />
                @include('partials.notifications-popup')
            </div>
        </div>

        {{-- Desktop Header --}}
        <div class="hidden lg:flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="relative shrink-0">
                    <div class="absolute -inset-1 bg-gradient-to-br from-primary to-secondary rounded-full blur-md opacity-50"></div>
                    <div class="w-11 h-11 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-base font-bold relative ring-2 ring-white dark:ring-neutral-900 shadow-lg shadow-primary/30" style="font-family: 'DM Serif Display', Georgia, serif;">
                        {{ $user->initials() }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white dark:border-neutral-900"></div>
                </div>
                <div>
                    <h1 class="text-lg font-bold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent" style="font-family: 'DM Serif Display', Georgia, serif;">Dashboard</h1>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-base font-extrabold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $user->name }}</span>
                        <span class="text-xs text-text/30">&middot; Welcome back</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <x-refresh-button />
                @include('partials.notifications-popup')
            </div>
        </div>

        {{-- Review Warning Marquee --}}
        <div class="overflow-hidden rounded-xl bg-amber-50 dark:bg-amber-900/15 border border-amber-200 dark:border-amber-800/30 py-1.5">
            <div class="flex whitespace-nowrap animate-marquee">
                @foreach ([1, 2] as $copy)
                    <div class="flex items-center gap-2 px-8">
                        <svg class="w-3 h-3 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <span class="text-[10px] font-medium text-amber-700 dark:text-amber-400">{{ __('All tasks are reviewed by the admin before being credited to your linked payout account. Nonsense or low-quality submissions may reduce your earnings or cause temporary account suspension.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Balance Card --}}
        <div class="bg-gradient-to-br from-primary via-primary to-secondary rounded-2xl p-5 relative overflow-hidden shadow-xl shadow-primary/25 ring-1 ring-white/10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4 blur-xl"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4 blur-xl"></div>

            <div class="relative">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <p class="text-[10px] text-white/60 uppercase tracking-wider mb-1">Total balance</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $balance }}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <div class="w-5 h-5 bg-white/25 rounded-full flex items-center justify-center text-[9px] font-bold text-white ring-1 ring-white/20 shrink-0">
                                {{ $user->initials() }}
                            </div>
                            <span class="text-[11px] font-semibold text-white/80 tracking-wide truncate">{{ '@' . $user->username }}</span>
                            <span class="text-[10px] text-white/40 shrink-0">&middot; {{ $currentPlan?->name ?? 'Free plan' }}</span>
                        </div>
                    </div>
                    <div class="relative shrink-0">
                        <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center relative">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('withdraw.index') }}" wire:navigate class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-xs font-semibold text-white transition-all cursor-pointer border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Withdraw
                    </a>
                    <a href="{{ route('plans.index') }}" class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-xs font-semibold text-white transition-all cursor-pointer border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        Upgrade
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <p class="text-[11px] text-text/35 text-center mb-2.5">Ways to earn</p>
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('earn.index') }}" wire:navigate class="flex flex-col items-center gap-1.5 p-2.5 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 hover:border-primary/30 hover:shadow-sm transition-all group">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary/10 to-primary/5 rounded-full flex items-center justify-center group-hover:from-primary/20 group-hover:to-primary/10 transition-colors">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-text/60 text-center">Voice Earn</span>
                </a>
                <a href="{{ route('earn.index') }}" wire:navigate class="flex flex-col items-center gap-1.5 p-2.5 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 hover:border-blue-300 hover:shadow-sm transition-all group">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-full flex items-center justify-center group-hover:from-blue-100 group-hover:to-blue-50 transition-colors">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-text/60 text-center">Word Game</span>
                </a>
                <div class="flex flex-col items-center gap-1.5 p-2.5 bg-white/50 dark:bg-neutral-900/50 rounded-xl border border-gray-100/50 dark:border-neutral-800/50 opacity-50 cursor-not-allowed">
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-900/20 dark:to-gray-900/10 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] font-medium text-text/40 text-center">Coming Soon</span>
                </div>
            </div>
        </div>

        {{-- Next Step Banner --}}
        @if(!$currentPlan)
            <a href="{{ route('plans.index') }}" class="flex items-center gap-3 bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-xl p-3.5 hover:bg-primary/10 transition-colors group">
                <div class="w-9 h-9 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-primary">0/3</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-semibold text-primary uppercase tracking-wider">Next step to start earning</p>
                    <p class="text-xs font-semibold text-text">Activate a plan</p>
                </div>
                <svg class="w-4 h-4 text-text/30 group-hover:text-primary transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        @endif

        {{-- Overview Stats --}}
        <div>
            <div class="flex items-center justify-between mb-2.5">
                <h2 class="text-xs font-semibold text-text">Overview</h2>
                <a href="{{ route('transactions.index') }}" class="text-[11px] font-medium text-primary hover:text-primary/80">All transactions</a>
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 shadow-sm">
                    <div class="w-7 h-7 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $tasksCompletedToday }}/{{ $dailyTasksTotal }}</p>
                    <p class="text-[10px] text-text/40 mt-0.5">Tasks completed</p>
                </div>
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 shadow-sm">
                    <div class="w-7 h-7 bg-gradient-to-br from-primary/10 to-secondary/10 dark:from-primary/20 dark:to-secondary/10 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalWithdrawn, 2) }}</p>
                    <p class="text-[10px] text-text/40 mt-0.5">Total withdrawn</p>
                </div>
            </div>
        </div>

        {{-- Referral Card --}}
        <div id="referrals" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm relative overflow-hidden">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-text">Your referral link</p>
                        <p class="text-[10px] text-text/40">Earn rewards when friends join</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full uppercase tracking-wider shrink-0">{{ $currentPlan?->name ?? 'Free Plan' }}</span>
            </div>

            <div
                x-data="{
                    referralLink: @js(route('register') . '?ref=' . $user->username),
                    async copyReferralLink() {
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
                            const copied = document.execCommand('copy');
                            textarea.remove();
                            $flux.toast(
                                copied ? '{{ __('Referral link copied.') }}' : '{{ __('Unable to copy the referral link.') }}',
                                { variant: copied ? 'success' : 'danger' },
                            );
                        }
                    }
                }"
                class="flex items-center gap-2 mb-3"
            >
                <div class="flex-1 bg-gray-50 dark:bg-neutral-800 rounded-lg px-3 py-2 text-[11px] text-text/50 font-mono truncate">
                    {{ route('register') }}?ref={{ $user->username }}
                </div>
                <button type="button" @click="copyReferralLink()" class="px-3 py-2 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white text-[11px] font-semibold rounded-lg transition-all shrink-0 cursor-pointer shadow-sm">
                    Copy
                </button>
            </div>

            <div class="grid grid-cols-3 gap-3 mb-3">
                <div class="text-center">
                    <p class="text-base font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $totalReferrals }}</p>
                    <p class="text-[9px] text-text/35 uppercase tracking-wider">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $activeReferrals }}</p>
                    <p class="text-[9px] text-text/35 uppercase tracking-wider">Active</p>
                </div>
                <div class="text-center">
                    <p class="text-base font-bold text-amber-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $pendingReferrals }}</p>
                    <p class="text-[9px] text-text/35 uppercase tracking-wider">Pending</p>
                </div>
            </div>

            <a href="{{ route('affiliate.index') }}" wire:navigate class="block text-center py-2 rounded-lg border border-gray-200 dark:border-neutral-700 text-[11px] font-medium text-text/60 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                View affiliate dashboard
            </a>
        </div>

        {{-- Quick Links --}}
        <div class="grid grid-cols-2 gap-2.5">
            <a href="{{ route('earn.index') }}" class="flex items-center gap-2.5 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 hover:border-blue-300 hover:shadow-sm transition-all group">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-text">Ways to earn</p>
                    <p class="text-[10px] text-text/40">2 activities</p>
                </div>
            </a>
            <a href="{{ route('affiliate.earners') }}" wire:navigate class="flex items-center gap-2.5 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 hover:border-amber-300 hover:shadow-sm transition-all group">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0016.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-text">Affiliate Earners</p>
                    <p class="text-[10px] text-text/40">Top earners</p>
                </div>
            </a>
        </div>

        {{-- Upgrade Banner --}}
        @if(!$currentPlan)
            <a href="{{ route('plans.index') }}" class="block bg-gradient-to-r from-primary to-orange-600 rounded-xl p-4 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-white">Upgrade your account</p>
                        <p class="text-[10px] text-white/70">Unlock Voice Earn, Word Game & payouts</p>
                    </div>
                    <svg class="w-4 h-4 text-white/60 group-hover:text-white transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </a>
        @endif

        {{-- Earn Now --}}
        <div id="earn">
            <div class="flex items-center justify-between mb-2.5">
                <h2 class="text-xs font-semibold text-text">Earn now</h2>
                @if(!$currentPlan)
                    <a href="{{ route('plans.index') }}" class="text-[11px] font-medium text-primary hover:text-primary/80">Activate plan</a>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <a href="{{ route('earn.voice') }}" wire:navigate class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 text-center hover:border-primary/30 hover:shadow-sm transition-all">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-text mb-0.5">Voice Earn</p>
                    <p class="text-[11px] text-primary font-medium">{{ $currentPlan ? '+₦'.number_format((float) $currentPlan->voice_earn_per_session).' / session' : 'Activate plan' }}</p>
                </a>
                <a href="{{ route('earn.word-game') }}" wire:navigate class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3.5 text-center hover:border-blue-300 hover:shadow-sm transition-all">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-text mb-0.5">Word Game</p>
                    <p class="text-[11px] text-primary font-medium">{{ $currentPlan ? '+₦'.number_format((float) $currentPlan->word_game_per_word).' / word' : 'Activate plan' }}</p>
                </a>
            </div>
        </div>

        {{-- Report an Issue --}}
        <div class="text-center pt-2 pb-1" x-data="{ reportOpen: false }">
            <button type="button" @click="reportOpen = true" class="text-[11px] text-text/30 hover:text-primary transition-colors cursor-pointer">
                {{ __('Report an issue') }}
            </button>

            {{-- Report Modal --}}
            <div x-show="reportOpen" x-cloak
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
                @keydown.escape.window="reportOpen = false">
                <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="reportOpen = false"></div>
                <div class="relative w-full sm:max-w-md bg-white dark:bg-neutral-900 rounded-t-2xl sm:rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-2xl max-h-[85vh] overflow-y-auto"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="translate-y-4 sm:translate-y-0 sm:scale-95 opacity-0"
                    x-transition:enter-end="translate-y-0 sm:scale-100 opacity-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="translate-y-0 sm:scale-100 opacity-100"
                    x-transition:leave-end="translate-y-4 sm:translate-y-0 sm:scale-95 opacity-0">
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-text">{{ __('Report an issue') }}</h3>
                            <button type="button" @click="reportOpen = false" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                                <svg class="w-4 h-4 text-text/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-3" x-data="{ sending: false }" @submit.prevent="
                            sending = true;
                            const formData = new FormData($el);
                            fetch('{{ route('contact.store') }}', {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            }).then(r => r.ok ? r.text() : Promise.reject(r))
                              .then(() => {
                                reportOpen = false;
                                $flux.toast('{{ __('Your report has been sent. We will get back to you shortly.') }}', { variant: 'success' });
                                $el.reset();
                              }).catch(() => {
                                $flux.toast('{{ __('Something went wrong. Please try again.') }}', { variant: 'danger' });
                              }).finally(() => { sending = false; });
                        ">
                            @csrf
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <div>
                                <label for="report-subject" class="block text-[11px] font-medium text-text/60 mb-1">{{ __('Subject') }}</label>
                                <input type="text" name="subject" id="report-subject" required maxlength="255"
                                    class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                                    placeholder="{{ __('Brief description of the issue') }}">
                            </div>
                            <div>
                                <label for="report-message" class="block text-[11px] font-medium text-text/60 mb-1">{{ __('Message') }}</label>
                                <textarea name="message" id="report-message" rows="4" required maxlength="5000"
                                    class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors resize-none"
                                    placeholder="{{ __('Describe what happened...') }}"></textarea>
                            </div>
                            <button type="submit" :disabled="sending"
                                class="w-full py-2.5 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all disabled:opacity-50 cursor-pointer flex items-center justify-center gap-1.5">
                                <template x-if="!sending">
                                    <span>{{ __('Send Report') }}</span>
                                </template>
                                <template x-if="sending">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                        {{ __('Sending...') }}
                                    </span>
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Avatar Theme Toggle --}}
        <div class="fixed bottom-20 right-4 sm:bottom-6 sm:right-6 z-40" x-data="{ themeOpen: false }">
            <button type="button" @click="themeOpen = !themeOpen"
                class="w-11 h-11 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-primary/30 ring-2 ring-white dark:ring-neutral-900 cursor-pointer hover:scale-105 transition-transform">
                {{ $user->initials() }}
            </button>
            <div x-show="themeOpen" x-cloak
                x-transition:enter="ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-90 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                @click.outside="themeOpen = false"
                class="absolute bottom-14 right-0 w-40 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 shadow-xl p-1.5">
                <button type="button" @click="$flux.appearance = 'light'; themeOpen = false"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-colors cursor-pointer"
                    :class="$flux.appearance === 'light' || ($flux.appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'bg-primary/10 text-primary' : 'text-text/60 hover:bg-gray-100 dark:hover:bg-neutral-800'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                    {{ __('Light') }}
                </button>
                <button type="button" @click="$flux.appearance = 'dark'; themeOpen = false"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-colors cursor-pointer"
                    :class="$flux.appearance === 'dark' || ($flux.appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'bg-primary/10 text-primary' : 'text-text/60 hover:bg-gray-100 dark:hover:bg-neutral-800'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                    {{ __('Dark') }}
                </button>
                <button type="button" @click="$flux.appearance = 'system'; themeOpen = false"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-colors cursor-pointer"
                    :class="$flux.appearance === 'system' ? 'bg-primary/10 text-primary' : 'text-text/60 hover:bg-gray-100 dark:hover:bg-neutral-800'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 7.41A2.25 2.25 0 012.25 5.496V5.25"/></svg>
                    {{ __('System') }}
                </button>
            </div>
        </div>
    </div>
</x-layouts::app>
