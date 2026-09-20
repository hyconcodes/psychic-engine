<x-layouts::app :title="__('Dashboard')">
    @php
        $user = auth()->user();
        $currentPlan = $user->currentPlan();
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->formattedBalance() : '₦0.00';
        $tasksCompleted = $user->earningSubmissions()->count();
    @endphp
    <div class="space-y-6">

        {{-- Mobile Header --}}
        <div class="flex items-center justify-between lg:hidden">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-br from-primary to-secondary rounded-full blur-sm opacity-60"></div>
                    <div class="w-11 h-11 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold relative ring-2 ring-white dark:ring-neutral-900 shadow-lg shadow-primary/30">
                        {{ $user->initials() }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-400 rounded-full border-2 border-white dark:border-neutral-900"></div>
                </div>
                <div>
                    <p class="text-[11px] text-text/40 tracking-wide">Good {{ now()->format('A') < 12 ? 'morning' : (now()->format('A') < 17 ? 'afternoon' : 'evening') }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-base font-extrabold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent leading-tight" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $user->name }}</span>
                    </div>
                </div>
            </div>
            <button class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                <svg class="w-5 h-5 text-text/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            </button>
        </div>

        {{-- Desktop Header --}}
        <div class="hidden lg:flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-br from-primary to-secondary rounded-full blur-md opacity-50"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-xl font-bold relative ring-2 ring-white dark:ring-neutral-900 shadow-xl shadow-primary/30" style="font-family: 'DM Serif Display', Georgia, serif;">
                        {{ $user->initials() }}
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-400 rounded-full border-2 border-white dark:border-neutral-900"></div>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent" style="font-family: 'DM Serif Display', Georgia, serif;">Dashboard</h1>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-lg font-extrabold bg-gradient-to-r from-primary via-secondary to-primary bg-clip-text text-transparent" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $user->name }}</span>
                        <span class="text-xs text-text/30">&middot; Welcome back</span>
                    </div>
                </div>
            </div>
            <button class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors relative">
                <svg class="w-5 h-5 text-text/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-primary rounded-full border-2 border-white dark:border-neutral-900"></span>
            </button>
        </div>

        {{-- Review Warning Marquee --}}
        <div class="overflow-hidden rounded-xl bg-amber-50 dark:bg-amber-900/15 border border-amber-200 dark:border-amber-800/30 py-1.5">
            <div class="flex whitespace-nowrap animate-marquee">
                @foreach ([1, 2] as $copy)
                    <div class="flex items-center gap-2 px-8">
                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        <span class="text-[11px] font-medium text-amber-700 dark:text-amber-400">{{ __('All tasks are reviewed by the admin before being credited to your linked payout account. Nonsense or low-quality submissions may reduce your earnings or cause temporary account suspension.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Balance Card — ATM Style --}}
        <div class="bg-gradient-to-br from-primary via-primary to-secondary rounded-2xl p-6 relative overflow-hidden shadow-2xl shadow-primary/25 ring-1 ring-white/10">
            {{-- Background decorations --}}
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4 blur-xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4 blur-xl"></div>
            {{-- Transparent SVG decorations --}}
            <svg class="absolute top-3 right-14 w-20 h-20 text-white/[0.06] rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <svg class="absolute bottom-2 left-6 w-14 h-14 text-white/[0.05] -rotate-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            <svg class="absolute top-8 left-2 w-10 h-10 text-white/[0.04] rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <div class="absolute top-4 right-4 w-2 h-2 bg-white/30 rounded-full"></div>
            <div class="absolute top-8 right-10 w-1.5 h-1.5 bg-white/20 rounded-full"></div>
            <div class="absolute bottom-6 left-8 w-1.5 h-1.5 bg-white/20 rounded-full"></div>

            <div class="relative">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <p class="text-xs text-white/60 uppercase tracking-wider mb-1">Total balance</p>
                        <p class="text-3xl sm:text-4xl font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $balance }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="relative">
                                <div class="w-6 h-6 bg-white/25 rounded-full flex items-center justify-center text-[10px] font-bold text-white ring-1 ring-white/20">
                                    {{ $user->initials() }}
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-white/80 tracking-wide">{{ '@' . $user->username }}</span>
                            @if($currentPlan)
                                <span class="text-[10px] text-white/40">&middot; {{ $currentPlan->name }}</span>
                            @else
                                <span class="text-[10px] text-white/40">&middot; Free plan</span>
                            @endif
                        </div>
                    </div>
                    {{-- Bubbling Microphone --}}
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                        <div class="absolute -inset-1 bg-white/10 rounded-full animate-pulse"></div>
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center relative">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="#" class="flex items-center justify-center gap-1.5 py-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-sm font-semibold text-white transition-all cursor-pointer border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Withdraw
                    </a>
                    <a href="{{ route('plans.index') }}" class="flex items-center justify-center gap-1.5 py-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-sm font-semibold text-white transition-all cursor-pointer border border-white/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        Upgrade
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <p class="text-xs text-text/35 text-center mb-3">Ways to earn</p>
            <div class="grid grid-cols-3 gap-3">
                <a href="{{ route('earn.index') }}" wire:navigate class="flex flex-col items-center gap-2 p-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 hover:border-primary/30 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary/10 to-primary/5 rounded-full flex items-center justify-center group-hover:from-primary/20 group-hover:to-primary/10 transition-colors">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-text/60 text-center">Voice Earn</span>
                </a>
                <a href="{{ route('earn.index') }}" wire:navigate class="flex flex-col items-center gap-2 p-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 hover:border-blue-300 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-full flex items-center justify-center group-hover:from-blue-100 group-hover:to-blue-50 transition-colors">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-text/60 text-center">Word Game</span>
                </a>
                <div class="flex flex-col items-center gap-2 p-3 bg-white/50 dark:bg-neutral-900/50 rounded-xl border border-gray-100/50 dark:border-neutral-800/50 opacity-50 cursor-not-allowed">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-900/20 dark:to-gray-900/10 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-text/40 text-center">Coming Soon</span>
                </div>
            </div>
        </div>

        {{-- Next Step Banner --}}
        @if(!$currentPlan)
            <a href="{{ route('plans.index') }}" class="flex items-center gap-4 bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-2xl p-4 hover:bg-primary/10 transition-colors group">
                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-sm font-bold text-primary">0/3</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-semibold text-primary uppercase tracking-wider">Next step to start earning</p>
                    <p class="text-sm font-semibold text-text">Activate a plan</p>
                    <p class="text-xs text-text/40">Unlock all earning features</p>
                </div>
                <svg class="w-5 h-5 text-text/30 group-hover:text-primary transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        @endif

        {{-- Overview Stats --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-text">Overview</h2>
                <a href="{{ route('transactions.index') }}" class="text-xs font-medium text-primary hover:text-primary/80">All transactions</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-2xl font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $tasksCompleted }}</p>
                    <p class="text-[11px] text-text/40 mt-0.5">Tasks completed</p>
                </div>
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary/10 to-secondary/10 dark:from-primary/20 dark:to-secondary/10 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <p class="text-2xl font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">&#8358;0</p>
                    <p class="text-[11px] text-text/40 mt-0.5">Total withdrawn</p>
                </div>
            </div>
        </div>

        {{-- Referral Card --}}
        <div id="referrals" class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-primary/5 rounded-full blur-xl"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text">Your referral link</p>
                        <p class="text-xs text-text/40">Earn rewards when friends join</p>
                    </div>
                </div>
                @if($currentPlan)
                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $currentPlan->name }}</span>
                @else
                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full uppercase tracking-wider">Free Plan</span>
                @endif
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
                class="flex items-center gap-2 mb-4"
            >
                <div class="flex-1 bg-gray-50 dark:bg-neutral-800 rounded-lg px-3 py-2.5 text-xs text-text/50 font-mono truncate">
                    {{ route('register') }}?ref={{ $user->username }}
                </div>
                <button type="button" @click="copyReferralLink()" class="px-4 py-2.5 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white text-xs font-semibold rounded-lg transition-all shrink-0 cursor-pointer shadow-sm hover:shadow-md">
                    Copy
                </button>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center">
                    <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">0</p>
                    <p class="text-[10px] text-text/35 uppercase tracking-wider">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">0</p>
                    <p class="text-[10px] text-text/35 uppercase tracking-wider">Active</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-amber-500" style="font-family: 'DM Serif Display', Georgia, serif;">0</p>
                    <p class="text-[10px] text-text/35 uppercase tracking-wider">Pending</p>
                </div>
            </div>

            <a href="#" class="block text-center py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 text-xs font-medium text-text/60 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                View affiliate dashboard
            </a>
        </div>

        {{-- Quick Links --}}
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('plans.index') }}" class="flex items-center gap-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 hover:border-blue-300 hover:shadow-md transition-all group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-text">Ways to earn</p>
                    <p class="text-[11px] text-text/40">3 activities</p>
                </div>
                <svg class="w-4 h-4 text-text/20 group-hover:text-blue-500 transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
            <a href="{{ route('plans.index') }}" class="flex items-center gap-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 hover:border-amber-300 hover:shadow-md transition-all group">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0016.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-text">Star earners</p>
                    <p class="text-[11px] text-text/40">Top 10 this week</p>
                </div>
                <svg class="w-4 h-4 text-text/20 group-hover:text-amber-500 transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>

        {{-- Upgrade Banner --}}
        @if(!$currentPlan)
            <a href="{{ route('plans.index') }}" class="block bg-gradient-to-r from-primary to-orange-600 rounded-2xl p-5 relative overflow-hidden group hover:shadow-lg transition-shadow">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white">Upgrade your account</p>
                        <p class="text-xs text-white/70">Unlock Voice Earn, Word Game, higher rewards & payouts</p>
                    </div>
                    <svg class="w-5 h-5 text-white/60 group-hover:text-white transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </div>
            </a>
        @endif

        {{-- Earn Now --}}
        <div id="earn">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-text">Earn now</h2>
                @if(!$currentPlan)
                    <a href="{{ route('plans.index') }}" class="text-xs font-medium text-primary hover:text-primary/80">Activate plan</a>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('earn.index') }}" wire:navigate class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-5 text-center hover:border-primary/30 hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-text mb-0.5">Voice Earn</p>
                    <p class="text-xs text-primary font-medium">{{ $currentPlan ? '+&#8358;'.number_format((float) $currentPlan->voice_earn_per_session).'/session' : 'Activate plan' }}</p>
                    <p class="text-[10px] text-text/30 mt-1">{{ $currentPlan ? 'Start earning' : 'Unlock with a plan' }}</p>
                </a>
                <a href="{{ route('earn.index') }}" wire:navigate class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-5 text-center hover:border-blue-300 hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-text mb-0.5">Word Game</p>
                    <p class="text-xs text-primary font-medium">{{ $currentPlan ? '+&#8358;'.number_format((float) $currentPlan->word_game_per_word).'/word' : 'Activate plan' }}</p>
                    <p class="text-[10px] text-text/30 mt-1">{{ $currentPlan ? 'Start earning' : 'Unlock with a plan' }}</p>
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>
