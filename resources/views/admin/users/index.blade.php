<x-layouts::app :title="__('User Management')">
    <div class="space-y-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                    <svg class="w-3.5 h-3.5 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-lg text-text leading-tight">{{ __('User Management') }}</h2>
                    <p class="text-[10px] text-text/40">View and manage all users</p>
                </div>
                <x-refresh-button />
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ number_format($stats['total']) }}</p>
                <p class="text-[9px] text-text/40">Total</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ number_format($stats['verified']) }}</p>
                <p class="text-[9px] text-text/40">Verified</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-red-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['banned'] }}</p>
                <p class="text-[9px] text-text/40">Banned</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-primary" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['with_plan'] }}</p>
                <p class="text-[9px] text-text/40">Has plan</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-blue-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['with_payout'] }}</p>
                <p class="text-[9px] text-text/40">Payout set</p>
            </div>
        </div>

        <form method="GET" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 min-w-[140px] rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-[11px] text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                <select name="status" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-[11px] text-text focus:border-primary outline-none">
                    <option value="">All status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                </select>
                <select name="plan" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-[11px] text-text focus:border-primary outline-none">
                    <option value="">All plans</option>
                    <option value="has_plan" {{ request('plan') === 'has_plan' ? 'selected' : '' }}>Has plan</option>
                    <option value="no_plan" {{ request('plan') === 'no_plan' ? 'selected' : '' }}>No plan</option>
                </select>
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-primary/10 text-primary text-[11px] font-medium hover:bg-primary/20 transition-colors">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/50 text-[11px] font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Reset</a>
            </div>
        </form>

        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-3 py-2 text-left text-[9px] font-semibold text-text/40 uppercase">User</th>
                            <th class="px-3 py-2 text-left text-[9px] font-semibold text-text/40 uppercase hidden sm:table-cell">Plan</th>
                            <th class="px-3 py-2 text-left text-[9px] font-semibold text-text/40 uppercase">Status</th>
                            <th class="px-3 py-2 text-left text-[9px] font-semibold text-text/40 uppercase hidden sm:table-cell">Joined</th>
                            <th class="px-3 py-2 text-right text-[9px] font-semibold text-text/40 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse($users as $u)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-3 py-2">
                                    <a href="{{ route('admin.users.show', $u) }}" class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[9px] font-bold shrink-0">{{ $u->initials() }}</div>
                                        <div class="min-w-0">
                                            <p class="text-[11px] font-medium text-text truncate">{{ '@'.$u->username }}</p>
                                            <p class="text-[9px] text-text/30 truncate sm:hidden">{{ $u->activeSubscription?->plan?->name ?? 'No plan' }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-3 py-2 hidden sm:table-cell">
                                    <span class="text-[10px] text-text/50">{{ $u->activeSubscription?->plan?->name ?? '—' }}</span>
                                </td>
                                <td class="px-3 py-2">
                                    @if($u->isBanned())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-semibold bg-red-500/10 text-red-600">Banned</span>
                                    @elseif($u->hasActivePlan())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-semibold bg-green-500/10 text-green-600">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-semibold bg-gray-500/10 text-gray-500">Free</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 hidden sm:table-cell text-[10px] text-text/30">{{ $u->created_at->format('M d, Y') }}</td>
                                <td class="px-3 py-2 text-right">
                                    <a href="{{ route('admin.users.show', $u) }}" class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/60 text-[9px] font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-8 text-center text-[10px] text-text/30">No users found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $users->links() }}
    </div>
</x-layouts::app>
