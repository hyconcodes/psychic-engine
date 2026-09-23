<x-layouts::app>
    <div class="space-y-5" x-data="{ showDecline: false, showDeduct: false, deductAmount: '' }">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.withdrawals.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Review Withdrawal') }}</h2>
                <p class="text-xs text-text/50">{{ $withdrawal->user->name }} ({{ '@'.$withdrawal->user->username }})</p>
            </div>
            <x-refresh-button />
        </div>

        {{-- Summary card --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                        {{ $withdrawal->user->initials() }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text">{{ $withdrawal->user->name }}</p>
                        <p class="text-xs text-text/40">{{ '@'.$withdrawal->user->username }}</p>
                    </div>
                </div>

                <div class="flex-1"></div>

                <div class="text-right">
                    <p class="text-xs text-text/40 uppercase tracking-wider">{{ __('Amount') }}</p>
                    <p class="text-xl font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">₦{{ number_format((float) $withdrawal->amount, 2) }}</p>
                </div>
            </div>

            @if ($withdrawal->early_withdrawal)
                <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    {{ __('Early withdrawal (before 2-week threshold)') }}
                </div>
            @endif

            @if ($withdrawal->payoutAccount)
                <div class="mt-3 rounded-xl bg-gray-50 dark:bg-neutral-800/50 border border-gray-100 dark:border-neutral-800 p-3">
                    <p class="text-[11px] text-text/40 uppercase tracking-wider mb-1">{{ __('Payout account') }}</p>
                    <p class="text-sm font-semibold text-text">{{ $withdrawal->payoutAccount->bank_name }}</p>
                    <p class="text-xs text-text/60">{{ $withdrawal->payoutAccount->account_number }} &middot; {{ $withdrawal->payoutAccount->account_name }}</p>
                </div>
            @endif
        </div>

        {{-- Submissions list --}}
        <div>
            <h3 class="text-sm font-semibold text-text mb-3">{{ __('Tasks to review') }} ({{ $withdrawal->submissions->count() }})</h3>

            @if ($withdrawal->submissions->isEmpty())
                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-8 text-center text-sm text-text/40">
                    {{ __('No submissions attached to this request.') }}
                </div>
            @else
                <div class="space-y-2">
                    @foreach ($withdrawal->submissions as $submission)
                        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 {{ $submission->type === 'sentence' ? 'bg-primary/10 text-primary' : 'bg-blue-500/10 text-blue-500' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold text-text">{{ $submission->type === 'sentence' ? __('Sentence') : __('Word') }} &middot; {{ strtoupper($submission->language) }}</p>
                                    <p class="text-[11px] text-text/40">{{ $submission->created_at->format('M d, Y H:i') }} &middot; ₦{{ number_format((float) $submission->amount, 2) }}</p>
                                </div>
                                <audio controls preload="none" src="{{ route('admin.withdrawals.audio', $submission) }}" class="h-8 max-w-[180px] sm:max-w-[240px]"></audio>
                            </div>
                            @if ($submission->prompt)
                                <p class="mt-2 text-xs text-text/50 italic">{{ $submission->prompt->text }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Actions --}}
        @if ($withdrawal->status === 'pending')
            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm transition-all shadow-md shadow-green-500/20 hover:from-green-600 hover:to-emerald-700 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ __('Approve & pay') }}
                    </button>
                </form>

                <button type="button" @click="showDeduct = true" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold text-sm transition-all shadow-md shadow-amber-500/20 hover:from-amber-600 hover:to-orange-700 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6"/></svg>
                    {{ __('Deduct') }}
                </button>

                <button type="button" @click="showDecline = true" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold text-sm transition-all shadow-md shadow-red-500/20 hover:from-red-600 hover:to-rose-700 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ __('Decline') }}
                </button>
            </div>
        @else
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-sm font-semibold text-text/60">
                {{ ucfirst($withdrawal->status) }}
                @if ($withdrawal->decline_reason)
                    &middot; {{ $reasons[$withdrawal->decline_reason] ?? $withdrawal->decline_reason }}
                @endif
                @if ($withdrawal->deduct_reason)
                    &middot; {{ __('Deducted') }} ₦{{ number_format((float) $withdrawal->deduct_amount, 2) }}
                @endif
            </div>
        @endif

        {{-- Deduct modal --}}
        <div x-show="showDeduct" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDeduct = false"></div>
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl p-6 shadow-2xl max-w-sm w-full">
                <h3 class="text-base font-semibold text-text mb-1">{{ __('Deduct & approve') }}</h3>
                <p class="text-xs text-text/50 mb-4">{{ __('Deduct an amount from the payout and approve the rest.') }}</p>

                <form method="POST" action="{{ route('admin.withdrawals.deduct', $withdrawal) }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="deduct-amount" class="block text-xs font-medium text-text mb-1">{{ __('Amount to deduct (₦)') }}</label>
                        <input
                            type="number"
                            name="deduct_amount"
                            id="deduct-amount"
                            x-model="deductAmount"
                            step="0.01"
                            min="1"
                            max="{{ (int) $withdrawal->amount }}"
                            required
                            placeholder="0.00"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                        >
                    </div>

                    <div>
                        <label for="deduct-reason" class="block text-xs font-medium text-text mb-1">{{ __('Reason') }}</label>
                        <select name="deduct_reason" id="deduct-reason" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            <option value="">{{ __('Select a reason') }}</option>
                            @foreach ($deductionReasons as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold text-sm transition-all shadow-md shadow-amber-500/20 cursor-pointer">
                        {{ __('Deduct & approve') }}
                    </button>
                </form>

                <button type="button" @click="showDeduct = false" class="mt-3 w-full py-2 rounded-xl text-sm font-medium text-text/50 hover:text-text transition-colors cursor-pointer">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>

        {{-- Decline modal --}}
        <div x-show="showDecline" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDecline = false"></div>
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl p-6 shadow-2xl max-w-sm w-full">
                <h3 class="text-base font-semibold text-text mb-1">{{ __('Decline withdrawal') }}</h3>
                <p class="text-xs text-text/50 mb-4">{{ __('Select a reason') }}</p>

                <form method="POST" action="{{ route('admin.withdrawals.decline', $withdrawal) }}" class="space-y-2">
                    @csrf
                    @foreach ($reasons as $key => $label)
                        <button type="submit" name="decline_reason" value="{{ $key }}" class="w-full text-left px-4 py-2.5 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                            {{ $label }}
                        </button>
                    @endforeach
                </form>

                <button type="button" @click="showDecline = false" class="mt-3 w-full py-2 rounded-xl text-sm font-medium text-text/50 hover:text-text transition-colors cursor-pointer">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</x-layouts::app>
