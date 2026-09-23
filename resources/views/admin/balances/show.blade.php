<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.balances.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Admin Balance Details') }}</h2>
                <p class="text-xs text-text/50">{{ $balance->description }}</p>
            </div>
            <x-refresh-button />
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-text/50">{{ __('User') }}</p>
                    <p class="mt-0.5 text-sm font-medium text-text">{{ $balance->user->name }}</p>
                    <p class="text-xs text-text/40">{{ $balance->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-text/50">{{ __('Amount') }}</p>
                    <p class="mt-0.5 text-2xl font-bold text-text">₦{{ number_format((float) $balance->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-text/50">{{ __('Plan') }}</p>
                    <p class="mt-0.5 text-sm text-text">{{ $balance->plan->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-text/50">{{ __('Status') }}</p>
                    @if($balance->status === 'confirmed')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('Confirmed') }}</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ __('Pending') }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-text/50">{{ __('Created') }}</p>
                    <p class="mt-0.5 text-sm text-text">{{ $balance->created_at->format('M d, Y h:i A') }}</p>
                </div>
                @if($balance->processed_at)
                    <div>
                        <p class="text-xs text-text/50">{{ __('Processed') }}</p>
                        <p class="mt-0.5 text-sm text-text">{{ $balance->processed_at->format('M d, Y h:i A') }}</p>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 mt-4 border-t border-gray-100 dark:border-neutral-800">
                @if($balance->status === 'pending')
                    <form method="post" action="{{ route('admin.balances.process', $balance) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl bg-green-600 text-white text-xs font-semibold hover:bg-green-500 transition-colors">{{ __('Mark as Processed') }}</button>
                    </form>
                @endif
                <a href="{{ route('admin.balances.edit', $balance) }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-text text-xs font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">{{ __('Edit') }}</a>
                <a href="{{ route('admin.balances.index') }}" class="px-4 py-2 text-sm font-medium text-text/60 hover:text-text transition-colors">{{ __('Back to List') }}</a>
            </div>
        </div>
    </div>
</x-layouts::app>
