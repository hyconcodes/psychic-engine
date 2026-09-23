<?php

use App\Models\PayoutAccount;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Payout account settings')] class extends Component {
    public array $banks = [];
    public string $bankCode = '';
    public string $accountNumber = '';
    public ?string $resolvedName = null;
    public bool $resolved = false;
    public bool $hasAccount = false;

    public function mount(BachsServiceInterface $bachs): void
    {
        $this->banks = $bachs->listBanks();

        $account = Auth::user()->payoutAccount;

        if ($account) {
            $this->bankCode = $account->bank_code;
            $this->accountNumber = $account->account_number;
            $this->resolvedName = $account->account_name;
            $this->resolved = true;
            $this->hasAccount = true;
        }
    }

    public function updatedBankCode(BachsServiceInterface $bachs): void
    {
        $this->resetResolution();

        if ($this->bankCode !== '' && strlen($this->accountNumber) === 10) {
            $this->verify($bachs);
        }
    }

    public function updatedAccountNumber(BachsServiceInterface $bachs): void
    {
        $this->resetResolution();

        if ($this->bankCode !== '' && strlen($this->accountNumber) === 10) {
            $this->verify($bachs);
        }
    }

    public function verify(BachsServiceInterface $bachs): void
    {
        $throttleKey = 'bank-verify-'.Auth::id();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            Flux::toast(variant: 'error', text: __('Too many verification attempts. Please wait a moment.'));

            return;
        }
        RateLimiter::hit($throttleKey, 60);

        $this->validate([
            'bankCode' => ['required'],
            'accountNumber' => ['required', 'digits:10'],
        ]);

        $result = $bachs->resolveBankAccount($this->accountNumber, $this->bankCode);

        if (! ($result['resolved'] ?? false)) {
            Flux::toast(variant: 'error', text: __('Could not resolve account. Check the details and try again.'));

            return;
        }

        $this->resolvedName = $result['account_name'] ?? null;
        $this->resolved = true;
    }

    public function save(): void
    {
        $this->validate([
            'bankCode' => ['required'],
            'accountNumber' => ['required', 'digits:10'],
            'resolvedName' => ['required'],
        ]);

        $alreadyLinked = PayoutAccount::where('bank_code', $this->bankCode)
            ->where('account_number', $this->accountNumber)
            ->where('user_id', '!=', Auth::id())
            ->exists();

        if ($alreadyLinked) {
            $this->addError('accountNumber', __('This payout account is already linked to another user.'));

            return;
        }

        $bank = collect($this->banks)->firstWhere('code', $this->bankCode);

        PayoutAccount::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'bank_name' => $bank['name'] ?? '',
                'bank_code' => $this->bankCode,
                'account_number' => $this->accountNumber,
                'account_name' => $this->resolvedName,
            ],
        );

        $this->hasAccount = true;

        Flux::toast(variant: 'success', text: __('Payout account saved.'));
    }

    private function resetResolution(): void
    {
        $this->resolvedName = null;
        $this->resolved = false;
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">{{ __('Payout account settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Payout Account')" :subheading="__('Link the bank account that receives your earnings')">
        <div class="space-y-5">
            @if ($hasAccount)
                <div class="flex items-start gap-3 rounded-xl bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800 p-4">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="text-sm font-medium text-green-700 dark:text-green-400">{{ __('Payout account linked') }}</p>
                        <p class="text-xs text-green-600/70 dark:text-green-400/70 mt-0.5">{{ __('Your earnings will be paid to this account.') }}</p>
                    </div>
                </div>
            @endif

            <div>
                <label for="payout-bank" class="block text-sm font-medium text-text mb-1.5">{{ __('Bank name') }}</label>
                <select
                    wire:model.live="bankCode"
                    id="payout-bank"
                    class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                >
                    <option value="">{{ __('Select your bank') }}</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="payout-account-number" class="block text-sm font-medium text-text mb-1.5">{{ __('Account number') }}</label>
                <input
                    wire:model.live="accountNumber"
                    id="payout-account-number"
                    type="text"
                    inputmode="numeric"
                    maxlength="10"
                    placeholder="0123456789"
                    class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                >
                @error('accountNumber')
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if ($resolved && $resolvedName)
                <div class="rounded-xl bg-gray-50 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-4">
                    <p class="text-xs text-text/40 uppercase tracking-wider">{{ __('Account name') }}</p>
                    <p class="text-base font-semibold text-text mt-1">{{ $resolvedName }}</p>
                </div>
            @endif

            <div class="flex items-center gap-3 pt-1">
                <flux:button variant="outline" type="button" wire:click="verify">{{ __('Verify account') }}</flux:button>

                @if ($resolved)
                    <flux:button variant="primary" type="button" wire:click="save" data-test="save-payout-button">{{ __('Save account') }}</flux:button>
                @endif
            </div>
        </div>
    </x-pages::settings.layout>
</section>
