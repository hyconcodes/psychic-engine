<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">Transactions</h2>
                <p class="text-xs text-text/50">Your complete transaction history</p>
            </div>
        </div>
    </x-slot>

    @php
        $typeIcons = [
            'plan_purchase' => ['bg' => 'bg-purple-500/10 dark:bg-purple-500/20', 'text' => 'text-purple-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>'],
            'earning' => ['bg' => 'bg-green-500/10 dark:bg-green-500/20', 'text' => 'text-green-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>'],
            'withdrawal' => ['bg' => 'bg-amber-500/10 dark:bg-amber-500/20', 'text' => 'text-amber-500', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>'],
        ];

        $statusColors = [
            'pending' => 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
            'successful' => 'bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-400',
            'failed' => 'bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-400',
        ];

        $typeLabels = [
            'plan_purchase' => 'Plan Purchase',
            'earning' => 'Earning',
            'withdrawal' => 'Withdrawal',
        ];
    @endphp

    <div class="space-y-5 pb-8">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $transactions->total() }}</p>
                <p class="text-[10px] text-text/40 uppercase tracking-wider mt-0.5">Total</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $transactions->where('status', 'successful')->count() }}</p>
                <p class="text-[10px] text-text/40 uppercase tracking-wider mt-0.5">Successful</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 text-center shadow-sm">
                <p class="text-2xl font-bold text-amber-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $transactions->where('status', 'pending')->count() }}</p>
                <p class="text-[10px] text-text/40 uppercase tracking-wider mt-0.5">Pending</p>
            </div>
        </div>

        {{-- Transactions List --}}
        @if($transactions->count() > 0)
            <div class="space-y-2">
                @foreach($transactions as $transaction)
                    @php
                        $typeStyle = $typeIcons[$transaction->type] ?? $typeIcons['earning'];
                        $statusStyle = $statusColors[$transaction->status] ?? $statusColors['pending'];
                        $planName = $transaction->metadata['plan_name'] ?? null;
                    @endphp
                    <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm flex items-center gap-3">
                        {{-- Type Icon --}}
                        <div class="w-10 h-10 {{ $typeStyle['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 {{ $typeStyle['text'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $typeStyle['icon'] !!}</svg>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <p class="text-sm font-semibold text-text truncate">{{ $transaction->description ?? $typeLabels[$transaction->type] ?? 'Transaction' }}</p>
                                @if($planName)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-semibold bg-purple-500/10 text-purple-500 border border-purple-500/20 shrink-0">{{ $planName }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-text/30">{{ $transaction->created_at->format('M d, Y') }}</span>
                                <span class="text-[10px] text-text/20">&middot;</span>
                                <span class="text-[10px] text-text/30 font-mono">{{ $transaction->reference }}</span>
                            </div>
                        </div>

                        {{-- Amount & Status --}}
                        <div class="text-right shrink-0">
                            <p class="text-sm font-bold {{ $transaction->type === 'earning' ? 'text-green-600' : 'text-text' }}" style="font-family: 'DM Serif Display', Georgia, serif;">
                                {{ $transaction->type === 'earning' ? '+' : '' }}{{ $transaction->formattedAmount() }}
                            </p>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-semibold {{ $statusStyle }} mt-0.5">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-12 text-center shadow-sm">
                <div class="w-16 h-16 bg-gray-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-text/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <p class="text-sm font-medium text-text/40">No transactions yet</p>
                <p class="text-xs text-text/25 mt-1">Your transaction history will appear here</p>
            </div>
        @endif
    </div>
</x-layouts::app>
