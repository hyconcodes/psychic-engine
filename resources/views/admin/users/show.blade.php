<x-layouts::app :title="__('User: '.$user->username)">
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="flex-1 min-w-0">
                <h2 class="font-semibold text-lg text-text leading-tight truncate">{{ $user->name }}</h2>
                <p class="text-[10px] text-text/40">{{ '@'.$user->username }} · {{ $user->email }}</p>
            </div>
            <div>
                @if($user->isBanned())
                    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-green-500/10 text-green-600 text-[10px] font-medium hover:bg-green-500/20 transition-colors">Unban</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Ban this user for 1 week?')" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-600 text-[10px] font-medium hover:bg-red-500/20 transition-colors">Ban (1 week)</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Profile Card --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold">{{ $user->initials() }}</div>
                <div>
                    <p class="text-sm font-semibold text-text">{{ $user->name }}</p>
                    <p class="text-[10px] text-text/40">{{ '@'.$user->username }} · {{ $user->email }}</p>
                </div>
                @if($user->isBanned())
                    <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-semibold bg-red-500/10 text-red-600">Banned until {{ $user->banned_until->format('M d') }}</span>
                @endif
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <p class="text-sm font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format((float) ($user->wallet?->balance ?? 0)) }}</p>
                    <p class="text-[9px] text-text/30">Balance</p>
                </div>
                <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <p class="text-sm font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalEarnings) }}</p>
                    <p class="text-[9px] text-text/30">Total earned</p>
                </div>
                <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <p class="text-sm font-bold text-red-500" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format($totalWithdrawn) }}</p>
                    <p class="text-[9px] text-text/30">Withdrawn</p>
                </div>
                <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-neutral-800">
                    <p class="text-sm font-bold text-primary" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $totalSubmissions }}</p>
                    <p class="text-[9px] text-text/30">Submissions</p>
                </div>
            </div>
        </div>

        {{-- Plan & Payout --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <h3 class="text-[10px] font-semibold text-text/40 uppercase mb-2">Subscription</h3>
                @if($user->activeSubscription)
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-text">{{ $user->activeSubscription->plan->name }}</p>
                            <p class="text-[9px] text-text/30">₦{{ number_format((float) $user->activeSubscription->plan->price) }} · {{ ucfirst($user->activeSubscription->status) }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-[10px] text-text/30">No active subscription</p>
                @endif
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <h3 class="text-[10px] font-semibold text-text/40 uppercase mb-2">Payout Account</h3>
                @if($user->payoutAccount)
                    <div>
                        <p class="text-[11px] font-semibold text-text">{{ $user->payoutAccount->bank_name }}</p>
                        <p class="text-[9px] text-text/30">{{ $user->payoutAccount->account_number }} · {{ $user->payoutAccount->account_name }}</p>
                    </div>
                @else
                    <p class="text-[10px] text-text/30">No payout account</p>
                @endif
            </div>
        </div>

        {{-- Referrals --}}
        @if($referrals->count() > 0)
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <h3 class="text-[10px] font-semibold text-text/40 uppercase mb-2">Referrals ({{ $referrals->count() }})</h3>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($referrals as $ref)
                        <a href="{{ route('admin.users.show', $ref) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-100 dark:bg-neutral-800 text-[9px] font-medium text-text/60 hover:bg-primary/10 hover:text-primary transition-colors">
                            <span class="w-4 h-4 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[7px] font-bold">{{ $ref->initials() }}</span>
                            {{ '@'.$ref->username }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Recent Submissions --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
            <h3 class="text-[10px] font-semibold text-text/40 uppercase mb-2">Recent Submissions</h3>
            <div class="space-y-1">
                @forelse($submissions as $sub)
                    <div class="flex items-center justify-between p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[8px] font-semibold {{ $sub->type === 'sentence' ? 'bg-primary/10 text-primary' : 'bg-blue-500/10 text-blue-500' }}">{{ $sub->type === 'sentence' ? 'S' : 'W' }}</span>
                            <span class="text-[10px] text-text/50">{{ config('earning.languages.'.$sub->language, $sub->language) }}</span>
                        </div>
                        <p class="text-[10px] font-semibold text-green-600">₦{{ number_format((float) $sub->amount) }}</p>
                    </div>
                @empty
                    <p class="text-[10px] text-text/30 text-center py-2">No submissions yet</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
            <h3 class="text-[10px] font-semibold text-text/40 uppercase mb-2">Recent Transactions</h3>
            <div class="space-y-1">
                @forelse($transactions as $tx)
                    <div class="flex items-center justify-between p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors">
                        <div>
                            <p class="text-[10px] font-medium text-text">{{ ucfirst($tx->type) }}</p>
                            <p class="text-[9px] text-text/30">{{ $tx->created_at->format('M d, H:i') }}</p>
                        </div>
                        <p class="text-[10px] font-semibold {{ $tx->type === 'withdrawal' ? 'text-red-500' : 'text-green-600' }}">
                            {{ $tx->type === 'withdrawal' ? '-' : '+' }}₦{{ number_format((float) $tx->amount) }}
                        </p>
                    </div>
                @empty
                    <p class="text-[10px] text-text/30 text-center py-2">No transactions yet</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
