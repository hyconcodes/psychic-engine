<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors relative shrink-0">
        <svg class="w-4 h-4 text-text/50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
        <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white dark:border-neutral-900"></span>
    </button>

    <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-2 w-72 sm:w-80 bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-xl z-50 overflow-hidden">
        <div class="p-3 border-b border-gray-100 dark:border-neutral-800">
            <p class="text-xs font-semibold text-text">{{ __('Recent transactions') }}</p>
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-neutral-800">
            @forelse ($recentTransactions as $transaction)
                <div class="px-3 py-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-medium text-text truncate">{{ $transaction->description ?? ucfirst($transaction->type) }}</p>
                            <p class="text-[10px] text-text/40">{{ $transaction->created_at->format('M d, H:i') }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-[11px] font-semibold {{ $transaction->type === 'earning' ? 'text-green-600' : 'text-text' }}">{{ $transaction->type === 'earning' ? '+' : '' }}{{ $transaction->formattedAmount() }}</p>
                            <span class="text-[9px] {{ $transaction->status === 'successful' ? 'text-green-500' : ($transaction->status === 'failed' ? 'text-red-500' : 'text-amber-500') }}">{{ ucfirst($transaction->status) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-3 py-6 text-center text-xs text-text/40">{{ __('No transactions yet') }}</div>
            @endforelse
        </div>

        <a href="{{ route('transactions.index') }}" wire:navigate class="block text-center py-2.5 text-[11px] font-semibold text-primary hover:bg-gray-50 dark:hover:bg-neutral-800 border-t border-gray-100 dark:border-neutral-800 transition-colors">
            {{ __('See all transactions') }}
        </a>
    </div>
</div>
