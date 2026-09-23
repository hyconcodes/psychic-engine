<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Admin Balance Management') }}</h2>
                <p class="text-xs text-text/50">{{ __('Track and manage accumulated admin charges') }}</p>
            </div>
            <a href="{{ route('admin.balances.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                {{ __('Add Balance') }}
            </a>
            <a href="{{ route('admin.payouts.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-green-600 text-white text-xs font-semibold shadow-md hover:bg-green-500 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                {{ __('Request Payout') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
                <p class="text-xs text-text/50">{{ __('Total Balance') }}</p>
                <p class="mt-1 text-2xl font-bold text-text">₦{{ number_format((float) ($stats['total_balance'] ?? 0), 2) }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
                <p class="text-xs text-text/50">{{ __('Pending Balance') }}</p>
                <p class="mt-1 text-2xl font-bold text-yellow-600">₦{{ number_format((float) ($stats['pending_balance'] ?? 0), 2) }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
                <p class="text-xs text-text/50">{{ __('Confirmed') }}</p>
                <p class="mt-1 text-2xl font-bold text-green-600">₦{{ number_format((float) (($stats['total_balance'] ?? 0) - ($stats['pending_balance'] ?? 0)), 2) }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('User') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Plan') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Amount') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Date') }}</th>
                            <th class="px-4 py-3 text-right text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-neutral-800/50">
                        @forelse ($balances as $balance)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/30 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-xs font-medium text-text">{{ $balance->user->name }}</p>
                                    <p class="text-[11px] text-text/40">{{ $balance->user->email }}</p>
                                </td>
                                <td class="px-4 py-3 text-xs text-text">{{ $balance->plan->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-xs font-semibold text-text">₦{{ number_format((float) $balance->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if($balance->status === 'confirmed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('Confirmed') }}</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ __('Pending') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-text/50">{{ $balance->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        @if($balance->status === 'pending')
                                            <form method="post" action="{{ route('admin.balances.process', $balance) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors">
                                                    {{ __('Process') }}
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.balances.show', $balance) }}" class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-gray-100 text-text/60 hover:bg-gray-200 dark:bg-neutral-800 dark:text-text/60 dark:hover:bg-neutral-700 transition-colors">
                                            {{ __('View') }}
                                        </a>
                                        <a href="{{ route('admin.balances.edit', $balance) }}" class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-gray-100 text-text/60 hover:bg-gray-200 dark:bg-neutral-800 dark:text-text/60 dark:hover:bg-neutral-700 transition-colors">
                                            {{ __('Edit') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-xs text-text/40">{{ __('No balance records found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-100 dark:border-neutral-800">
                {{ $balances->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
