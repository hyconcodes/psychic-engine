<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.balances.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Admin Payouts') }}</h2>
                <p class="text-xs text-text/50">{{ __('View payout history and request new payouts') }}</p>
            </div>
            <a href="{{ route('admin.payouts.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                {{ __('Request Payout') }}
            </a>
            <x-refresh-button />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
                <p class="text-xs text-text/50">{{ __('Total Earned') }}</p>
                <p class="mt-1 text-2xl font-bold text-text">₦{{ number_format((float) $totalEarned, 2) }}</p>
                <p class="text-[10px] text-text/30 mt-0.5">{{ __('All admin charges') }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-green-200 dark:border-green-800 p-4 shadow-sm">
                <p class="text-xs text-green-600">{{ __('Available to Withdraw') }}</p>
                <p class="mt-1 text-2xl font-bold text-green-600">₦{{ number_format((float) $confirmedBalance, 2) }}</p>
                <p class="text-[10px] text-green-500/70 mt-0.5">{{ __('Confirmed balance') }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
                <p class="text-xs text-text/50">{{ __('Total Withdrawn') }}</p>
                <p class="mt-1 text-2xl font-bold text-text">₦{{ number_format((float) $totalPaidOut, 2) }}</p>
                <p class="text-[10px] text-text/30 mt-0.5">{{ __('Completed payouts') }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-amber-200 dark:border-amber-800 p-4 shadow-sm">
                <p class="text-xs text-amber-600">{{ __('Pending Confirmation') }}</p>
                <p class="mt-1 text-2xl font-bold text-amber-600">₦{{ number_format((float) $pendingBalance, 2) }}</p>
                <p class="text-[10px] text-amber-500/70 mt-0.5">{{ __('Awaiting admin action') }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
            <p class="text-xs text-text/50">{{ __('Bank Account') }}</p>
            @if($payoutAccount)
                <p class="mt-1 text-sm font-medium text-text">{{ $payoutAccount->bank_name }}</p>
                <p class="text-[11px] text-text/40">{{ $payoutAccount->account_number }} — {{ $payoutAccount->account_name }}</p>
            @else
                <p class="mt-1 text-sm text-yellow-600">{{ __('No bank account linked') }}</p>
                <a href="{{ route('admin.payouts.create') }}" class="text-[11px] text-primary hover:underline">{{ __('Add one now') }}</a>
            @endif
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-neutral-800">
                <h3 class="text-sm font-semibold text-text">{{ __('Payout History') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Amount') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Bank') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Account') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-neutral-800/50">
                        @forelse ($payouts as $payout)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/30 transition-colors">
                                <td class="px-4 py-3 text-xs font-semibold text-text">{{ $payout->formattedAmount() }}</td>
                                <td class="px-4 py-3 text-xs text-text">{{ $payout->payoutAccount->bank_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-xs text-text/50">{{ $payout->payoutAccount->account_number ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($payout->status === 'completed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('Completed') }}</span>
                                    @elseif($payout->status === 'failed')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400" title="{{ $payout->error_message }}">{{ __('Failed') }}</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">{{ __('Processing') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-text/50">{{ $payout->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-xs text-text/40">{{ __('No payouts yet.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-100 dark:border-neutral-800">
                {{ $payouts->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
