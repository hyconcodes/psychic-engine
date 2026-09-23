<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.payouts.create') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Update Bank Account') }}</h2>
                <p class="text-xs text-text/50">{{ __('Change your linked payout bank account') }}</p>
            </div>
            <x-refresh-button />
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            @if($payoutAccount)
                <div class="mb-4 p-3 rounded-xl bg-gray-50 dark:bg-neutral-800/50 border border-gray-100 dark:border-neutral-700">
                    <p class="text-[11px] text-text/40 uppercase tracking-wider font-semibold mb-1">{{ __('Current Account') }}</p>
                    <p class="text-sm font-medium text-text">{{ $payoutAccount->bank_name }}</p>
                    <p class="text-xs text-text/50">{{ $payoutAccount->account_number }} — {{ $payoutAccount->account_name }}</p>
                </div>
            @endif

            <form method="post" action="{{ route('admin.payouts.update-bank') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="bank_code" class="block text-xs font-medium text-text mb-1">{{ __('Bank') }} <span class="text-red-500">*</span></label>
                        <select name="bank_code" id="bank_code" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            <option value="">{{ __('Select a bank') }}</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank['code'] }}" {{ old('bank_code', $payoutAccount->bank_code ?? '') == $bank['code'] ? 'selected' : '' }}>{{ $bank['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="account_number" class="block text-xs font-medium text-text mb-1">{{ __('Account Number') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $payoutAccount->account_number ?? '') }}" required maxlength="10" pattern="[0-9]{10}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="{{ __('10-digit account number') }}">
                    </div>
                </div>

                <p class="text-[11px] text-text/40">{{ __('Your account will be re-verified with the bank. The account name will be updated automatically.') }}</p>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                    <a href="{{ route('admin.payouts.create') }}" class="px-3.5 py-2 text-sm font-medium text-text/60 hover:text-text transition-colors">{{ __('Cancel') }}</a>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">{{ __('Update & Verify') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
