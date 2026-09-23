<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.payouts.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Request Payout') }}</h2>
                <p class="text-xs text-text/50">{{ __('Available: ₦'.number_format((float) $confirmedBalance, 2)) }}</p>
            </div>
        </div>

        {{-- Step 1: Bank Account --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-text mb-3">{{ __('Bank Account') }}</h3>

            @if($payoutAccount)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-900/30">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-text">{{ $payoutAccount->bank_name }}</p>
                        <p class="text-xs text-text/50">{{ $payoutAccount->account_number }} — {{ $payoutAccount->account_name }}</p>
                    </div>
                </div>
                <p class="mt-2 text-[11px] text-text/40">{{ __('Verified and ready for payouts.') }}</p>
            @else
                <form method="post" action="{{ route('admin.payouts.store-bank') }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="bank_code" class="block text-xs font-medium text-text mb-1">{{ __('Bank') }} <span class="text-red-500">*</span></label>
                            <select name="bank_code" id="bank_code" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                                <option value="">{{ __('Select a bank') }}</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="account_number" class="block text-xs font-medium text-text mb-1">{{ __('Account Number') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="account_number" id="account_number" required maxlength="10" pattern="[0-9]{10}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="{{ __('10-digit account number') }}">
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-text text-xs font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Verify & Save Account') }}
                    </button>
                </form>
            @endif
        </div>

        {{-- Step 2: Payout Amount --}}
        @if($payoutAccount && $confirmedBalance > 0)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-text mb-3">{{ __('Payout Amount') }}</h3>
                <form method="post" action="{{ route('admin.payouts.process') }}" class="space-y-3" onsubmit="return confirm('Send ₦{{ number_format((float) request()->input('amount', 0), 2) }} to {{ $payoutAccount->account_name }}?')">
                    @csrf
                    <div>
                        <label for="amount" class="block text-xs font-medium text-text mb-1">{{ __('Amount (₦)') }} <span class="text-red-500">*</span></label>
                        <input type="number" name="amount" id="amount" required min="1" max="{{ $confirmedBalance }}" step="0.01" value="{{ $confirmedBalance }}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        <p class="mt-1 text-[11px] text-text/40">{{ __('Maximum: ₦'.number_format((float) $confirmedBalance, 2)) }}</p>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        {{ __('Send Payout') }}
                    </button>
                </form>
            </div>
        @elseif($payoutAccount && $confirmedBalance <= 0)
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
                <div class="text-center py-4">
                    <p class="text-sm text-text/50">{{ __('No confirmed balance available for payout.') }}</p>
                    <p class="text-xs text-text/30 mt-1">{{ __('Confirmed balances are available when plan charges are processed.') }}</p>
                </div>
            </div>
        @endif
    </div>
</x-layouts::app>
