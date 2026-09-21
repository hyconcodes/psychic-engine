<x-layouts::app>
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Withdrawal Review') }}</h2>
                <p class="text-xs text-text/50">{{ __('Review and approve task withdrawal requests') }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('User') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Amount') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Requested') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($requests as $request)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                                            {{ $request->user->initials() }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-text truncate">{{ $request->user->name }}</p>
                                            <p class="text-xs text-text/40">{{ '@'.$request->user->username }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-semibold text-text">₦{{ number_format((float) $request->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if ($request->early_withdrawal)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400">{{ __('Early') }}</span>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $request->status === 'pending' ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400' : ($request->status === 'approved' ? 'bg-green-500/10 text-green-600 dark:text-green-400' : 'bg-red-500/10 text-red-600 dark:text-red-400') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-text/50">{{ $request->requested_at?->format('M d, Y') ?? $request->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.withdrawals.review', $request) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                                        {{ $request->status === 'pending' ? __('Review') : __('View') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-text/40">
                                    {{ __('No withdrawal requests yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    </div>
</x-layouts::app>
