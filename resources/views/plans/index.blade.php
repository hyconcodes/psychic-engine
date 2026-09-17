<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">Plans & Pricing</h2>
                <p class="text-xs text-text/50">Activate instantly with your deposit balance</p>
            </div>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $wallet = $user->wallet;
        $balance = $wallet ? $wallet->formattedBalance() : '₦0.00';
        $hasPlan = $currentPlan !== null;

        $planColors = [
            ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-300', 'badge' => 'bg-blue-500/20 text-blue-300', 'icon' => 'text-blue-400', 'iconBg' => 'bg-blue-500/20'],
            ['bg' => 'bg-green-500/20', 'text' => 'text-green-300', 'badge' => 'bg-green-500/20 text-green-300', 'icon' => 'text-green-400', 'iconBg' => 'bg-green-500/20'],
            ['bg' => 'bg-purple-500/20', 'text' => 'text-purple-300', 'badge' => 'bg-purple-500/20 text-purple-300', 'icon' => 'text-purple-400', 'iconBg' => 'bg-purple-500/20'],
            ['bg' => 'bg-amber-500/20', 'text' => 'text-amber-300', 'badge' => 'bg-amber-500/20 text-amber-300', 'icon' => 'text-amber-400', 'iconBg' => 'bg-amber-500/20'],
        ];

        $featureColors = [
            ['bg' => 'bg-blue-500/10 dark:bg-blue-500/20', 'text' => 'text-blue-500'],
            ['bg' => 'bg-green-500/10 dark:bg-green-500/20', 'text' => 'text-green-500'],
            ['bg' => 'bg-purple-500/10 dark:bg-purple-500/20', 'text' => 'text-purple-500'],
            ['bg' => 'bg-amber-500/10 dark:bg-amber-500/20', 'text' => 'text-amber-500'],
            ['bg' => 'bg-cyan-500/10 dark:bg-cyan-500/20', 'text' => 'text-cyan-500'],
            ['bg' => 'bg-rose-500/10 dark:bg-rose-500/20', 'text' => 'text-rose-500'],
        ];
    @endphp

    <div class="space-y-5 pb-8">
        {{-- Deposit Balance Card --}}
        <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-neutral-950 dark:via-neutral-900 dark:to-neutral-950 rounded-2xl p-5 relative overflow-hidden shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-xl"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4 blur-xl"></div>
            <div class="relative">
                <p class="text-xs text-white/50 mb-1">Your deposit balance</p>
                <p class="text-2xl font-bold text-white mb-3" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $balance }}</p>
                <a href="{{ route('wallet.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg text-xs font-medium text-white transition-colors border border-white/10">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                    Fund wallet
                </a>
            </div>
        </div>

        {{-- Subtitle --}}
        <p class="text-xs text-text/40 text-center">Every plan is a one-time <span class="font-semibold text-text/60">Lifetime</span> activation - pay once, earn forever.</p>

        {{-- Plan Cards --}}
        @foreach($plans as $plan)
            @php
                $isCurrent = $hasPlan && $currentPlan->id === $plan->id;
                $isUpgrade = $hasPlan && !$isCurrent && $plan->sort_order > $currentPlan->sort_order;
                $isLower = $hasPlan && !$isCurrent && $plan->sort_order < $currentPlan->sort_order;
                $colors = $planColors[$loop->index % count($planColors)];
            @endphp
            <div class="bg-white dark:bg-neutral-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-neutral-800 shadow-sm">
                {{-- Gradient Header --}}
                <div class="relative bg-gradient-to-br from-[#BF360C] via-primary to-secondary p-5 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/4"></div>

                    {{-- Popular Badge --}}
                    @if($plan->is_popular)
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white text-[#BF360C] uppercase tracking-wider">
                                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03z" clip-rule="evenodd"/></svg>
                                Popular
                            </span>
                        </div>
                    @endif

                    <div class="relative">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 {{ $colors['bg'] }} rounded-lg flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-4 h-4 {{ $colors['text'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                            </div>
                            <h3 class="text-white font-bold text-lg">{{ $plan->name }}</h3>
                        </div>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-white/60 text-sm">₦</span>
                            <span class="text-white text-3xl font-bold" style="font-family: 'DM Serif Display', Georgia, serif;">{{ number_format($plan->price) }}</span>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 {{ $colors['badge'] }} rounded text-[10px] font-medium">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Lifetime access
                        </span>
                    </div>
                </div>

                {{-- Features --}}
                <div class="p-5">
                    <div class="space-y-3 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-primary/10 dark:bg-primary/20 rounded flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                            </div>
                            <span class="text-sm text-text/70 dark:text-text/70"><span class="font-semibold text-primary">₦{{ number_format($plan->voice_earn_per_session) }}</span> per Voice Earn session</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-secondary/10 dark:bg-secondary/20 rounded flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-secondary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <span class="text-sm text-text/70 dark:text-text/70"><span class="font-semibold text-secondary">₦{{ number_format($plan->word_game_per_word) }}</span> per Word Game</span>
                        </div>
                        @foreach($plan->features as $feature)
                            @php
                                $fColor = $featureColors[$loop->index % count($featureColors)];
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 {{ $fColor['bg'] }} rounded flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 {{ $fColor['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <span class="text-sm text-text/70 dark:text-text/70">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- CTA Button --}}
                    @if($isCurrent)
                        <button disabled class="w-full py-3 px-4 rounded-xl bg-text dark:bg-white text-white dark:text-text font-semibold cursor-not-allowed opacity-80">
                            Current Plan
                        </button>
                    @elseif($isUpgrade)
                        <form method="POST" action="{{ route('plans.subscribe', $plan) }}">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-semibold transition-all duration-300 shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                Upgrade ₦{{ number_format($plan->price) }}
                            </button>
                        </form>
                    @elseif($isLower)
                        <button disabled class="w-full py-3 px-4 rounded-xl border-2 border-gray-200 dark:border-neutral-700 text-text/40 dark:text-text/40 font-semibold cursor-not-allowed">
                            Active Plan
                        </button>
                    @else
                        <form method="POST" action="{{ route('plans.subscribe', $plan) }}">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-semibold transition-all duration-300 shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 flex items-center justify-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                Deposit ₦{{ number_format($plan->price) }} to activate
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-layouts::app>
