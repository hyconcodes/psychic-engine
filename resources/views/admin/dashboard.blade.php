<x-layouts::app :title="__('Admin Dashboard')">
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Admin Dashboard') }}</h2>
                <p class="text-[11px] text-text/40">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <x-refresh-button />
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-primary/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Users</span>
                </div>
                <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ number_format($totalUsers) }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-green-500/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Subscriptions</span>
                </div>
                <p class="text-lg font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ number_format($activeSubscriptions) }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-amber-500/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Revenue</span>
                </div>
                <p class="text-lg font-bold text-amber-600" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalRevenue) }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-red-500/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Pending</span>
                </div>
                <p class="text-lg font-bold text-red-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $pendingWithdrawals }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-blue-500/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Earnings</span>
                </div>
                <p class="text-lg font-bold text-blue-600" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalEarnings) }}</p>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-6 h-6 bg-pink-500/10 rounded-md flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    </div>
                    <span class="text-[10px] text-text/40">Messages</span>
                </div>
                <p class="text-lg font-bold text-pink-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $unreadMessages }}</p>
            </div>
        </div>

        {{-- Financial Summary --}}
        <div class="grid grid-cols-2 gap-2">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-[10px] text-text/40 mb-1">This month revenue</p>
                <p class="text-sm font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($thisMonthRevenue) }}</p>
                @php $change = $lastMonthRevenue > 0 ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) : 0; @endphp
                <p class="text-[9px] {{ $change >= 0 ? 'text-green-500' : 'text-red-500' }}">{{ $change >= 0 ? '+' : '' }}{{ $change }}% vs last month</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-[10px] text-text/40 mb-1">Withdrawals this month</p>
                <p class="text-sm font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($thisMonthWithdrawals) }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-[10px] text-text/40 mb-1">Total wallet balance</p>
                <p class="text-sm font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalWalletBalance) }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-[10px] text-text/40 mb-1">Affiliate commissions</p>
                <p class="text-sm font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalAffiliateCommissions) }}</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-3 gap-2">
            <a href="{{ route('admin.withdrawals.index') }}" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm hover:border-amber-300 transition-colors text-center">
                <p class="text-lg font-bold text-amber-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $pendingWithdrawals }}</p>
                <p class="text-[9px] text-text/40">Pending withdrawals</p>
            </a>
            <a href="{{ route('admin.prompts.index') }}" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm hover:border-primary/30 transition-colors text-center">
                <p class="text-lg font-bold text-primary" style="font-family: 'DM Serif Display', Georgia, serif;">Prompts</p>
                <p class="text-[9px] text-text/40">Manage prompts</p>
            </a>
            <a href="{{ route('admin.messages.index') }}" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm hover:border-pink-300 transition-colors text-center">
                <p class="text-lg font-bold text-pink-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $unreadMessages }}</p>
                <p class="text-[9px] text-text/40">Unread messages</p>
            </a>
        </div>

        {{-- Recent Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            {{-- Pending Withdrawals --}}
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs font-semibold text-text">Pending Withdrawals</h3>
                    <a href="{{ route('admin.withdrawals.index') }}" class="text-[10px] text-primary font-medium">View all</a>
                </div>
                <div class="space-y-1.5">
                    @forelse($pendingWithdrawalList as $withdrawal)
                        <a href="{{ route('admin.withdrawals.review', $withdrawal) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[9px] font-bold shrink-0">
                                    {{ $withdrawal->user->initials() }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium text-text truncate">{{ '@'.$withdrawal->user->username }}</p>
                                    <p class="text-[9px] text-text/30">{{ $withdrawal->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-[11px] font-semibold text-amber-600 shrink-0">₦{{ number_format((float) $withdrawal->amount) }}</p>
                        </a>
                    @empty
                        <p class="text-[10px] text-text/30 text-center py-3">No pending withdrawals</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs font-semibold text-text">Recent Transactions</h3>
                    <a href="{{ route('admin.dashboard') }}" class="text-[10px] text-primary font-medium">View all</a>
                </div>
                <div class="space-y-1.5">
                    @forelse($recentTransactions as $tx)
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 {{ $tx->type === 'earning' ? 'bg-green-500/10' : ($tx->type === 'withdrawal' ? 'bg-red-500/10' : 'bg-blue-500/10') }}">
                                    <span class="text-[9px] font-bold {{ $tx->type === 'earning' ? 'text-green-500' : ($tx->type === 'withdrawal' ? 'text-red-500' : 'text-blue-500') }}">
                                        {{ $tx->type === 'earning' ? 'E' : ($tx->type === 'withdrawal' ? 'W' : 'P') }}
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium text-text truncate">{{ '@'.$tx->user->username ?? 'Deleted' }}</p>
                                    <p class="text-[9px] text-text/30">{{ ucfirst($tx->type) }} · {{ $tx->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-[11px] font-semibold {{ $tx->type === 'earning' ? 'text-green-600' : ($tx->type === 'withdrawal' ? 'text-red-600' : 'text-blue-600') }} shrink-0">
                                {{ $tx->type === 'withdrawal' ? '-' : '+' }}₦{{ number_format((float) $tx->amount) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-[10px] text-text/30 text-center py-3">No transactions yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-semibold text-text">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-[10px] text-primary font-medium">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-2 py-1.5 text-left text-[9px] font-semibold text-text/40 uppercase">User</th>
                            <th class="px-2 py-1.5 text-left text-[9px] font-semibold text-text/40 uppercase">Plan</th>
                            <th class="px-2 py-1.5 text-left text-[9px] font-semibold text-text/40 uppercase">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse($recentUsers as $u)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-2 py-1.5">
                                    <a href="{{ route('admin.users.show', $u) }}" class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[8px] font-bold shrink-0">{{ $u->initials() }}</div>
                                        <span class="text-[11px] font-medium text-text truncate">{{ '@'.$u->username }}</span>
                                    </a>
                                </td>
                                <td class="px-2 py-1.5 text-[10px] text-text/50">{{ $u->activeSubscription?->plan?->name ?? '—' }}</td>
                                <td class="px-2 py-1.5 text-[10px] text-text/30">{{ $u->created_at->format('M d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-2 py-3 text-center text-[10px] text-text/30">No users yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
