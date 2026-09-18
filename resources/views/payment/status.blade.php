<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">Payment Status</h2>
                <p class="text-xs text-text/50">Plan activation</p>
            </div>
        </div>
    </x-slot>

    @php
        $heroes = [
            'success' => [
                'gradient' => 'from-emerald-500 via-emerald-600 to-green-600',
                'ring' => 'bg-white/20',
                'badge' => 'bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-400',
                'badgeText' => 'Successful',
                'title' => 'Payment successful',
            ],
            'processing' => [
                'gradient' => 'from-amber-500 via-orange-500 to-orange-600',
                'ring' => 'bg-white/20',
                'badge' => 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
                'badgeText' => 'Processing',
                'title' => 'Payment processing',
            ],
            'failed' => [
                'gradient' => 'from-red-500 via-red-600 to-rose-600',
                'ring' => 'bg-white/20',
                'badge' => 'bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-400',
                'badgeText' => 'Failed',
                'title' => 'Payment not completed',
            ],
            'cancelled' => [
                'gradient' => 'from-neutral-600 via-neutral-700 to-neutral-800',
                'ring' => 'bg-white/15',
                'badge' => 'bg-neutral-500/10 text-neutral-600 dark:bg-neutral-500/20 dark:text-neutral-400',
                'badgeText' => 'Cancelled',
                'title' => 'Payment cancelled',
            ],
            'error' => [
                'gradient' => 'from-red-500 via-red-600 to-rose-600',
                'ring' => 'bg-white/20',
                'badge' => 'bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-400',
                'badgeText' => 'Error',
                'title' => 'Something went wrong',
            ],
        ];

        $hero = $heroes[$state] ?? $heroes['error'];
    @endphp

    <div class="space-y-5 pb-8">
        {{-- Hero --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $hero['gradient'] }} p-8 shadow-2xl ring-1 ring-white/10">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/4 blur-2xl"></div>

            <div class="relative flex flex-col items-center text-center">
                {{-- Animated icon --}}
                <div class="relative mb-4">
                    @if($state === 'processing')
                        <div class="w-20 h-20 rounded-full {{ $hero['ring'] }} backdrop-blur-sm flex items-center justify-center ring-2 ring-white/30">
                            <svg class="w-10 h-10 text-white animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                    @elseif($state === 'success')
                        <div class="w-20 h-20 rounded-full {{ $hero['ring'] }} backdrop-blur-sm flex items-center justify-center ring-2 ring-white/30 animate-[scale-in_0.4s_ease-out]">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                    @else
                        <div class="w-20 h-20 rounded-full {{ $hero['ring'] }} backdrop-blur-sm flex items-center justify-center ring-2 ring-white/30">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                    @endif
                </div>

                <h3 class="text-2xl font-bold text-white mb-1" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $hero['title'] }}</h3>
                <p class="text-sm text-white/80 max-w-sm">{{ $message }}</p>

                @if($state === 'processing')
                    <div class="inline-flex items-center gap-2 mt-4 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20">
                        <svg class="w-3.5 h-3.5 text-white/80 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/></svg>
                        <span class="text-[11px] font-medium text-white/90">We'll confirm your payment automatically</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Receipt --}}
        @if(isset($plan_name) && isset($amount))
            <div class="bg-white dark:bg-neutral-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-neutral-800 shadow-sm">
                <div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-neutral-950 dark:via-neutral-900 dark:to-neutral-950 p-5 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-xs text-white/50 uppercase tracking-wider mb-1">Order summary</p>
                            <p class="text-lg font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $plan_name }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $hero['badge'] }}">
                            {{ $hero['badgeText'] }}
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-bold text-white" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format((float) $amount) }}</p>
                    </div>
                </div>

                <div class="p-5 space-y-3">
                    @if($reference)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-text/40">Reference</span>
                            <span class="text-xs font-mono text-text/70">{{ $reference }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-text/40">Date</span>
                        <span class="text-xs text-text/70">{{ \Illuminate\Support\Carbon::parse($date)->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="space-y-3">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-semibold transition-all duration-300 shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30">
                Go to dashboard
            </a>

            <div class="grid grid-cols-2 gap-3">
                @if($state === 'processing' && isset($checkout_id))
                    <a href="{{ route('plans.callback', ['checkout_id' => $checkout_id]) }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                        Check again
                    </a>
                @elseif(in_array($state, ['failed', 'cancelled', 'error']))
                    <a href="{{ route('plans.index') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                        Back to plans
                    </a>
                @else
                    <a href="{{ route('plans.index') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                        View plans
                    </a>
                @endif

                <a href="{{ route('transactions.index') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                    Transactions
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>
