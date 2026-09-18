<?php

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public bool $twoFactorEnabled = false;
    public ?array $payoutAccount = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->twoFactorEnabled = $user->hasEnabledTwoFactorAuthentication();

        $account = $user->payoutAccount;

        if ($account) {
            $this->payoutAccount = [
                'bank_name' => $account->bank_name,
                'account_number' => $account->account_number,
                'account_name' => $account->account_name,
            ];
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading level="2" class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Your account details')">
        <div class="space-y-5">
            <flux:input wire:model="name" :label="__('Name')" type="text" disabled />

            <flux:input wire:model="phone" :label="__('Phone number')" type="text" disabled placeholder="—" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" disabled />

                @if ($this->hasUnverifiedEmail)
                    <div class="mt-3">
                        <flux:text class="text-xs">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-xs cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 text-xs font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between rounded-xl border border-gray-100 dark:border-neutral-800 bg-gray-50 dark:bg-neutral-800/50 px-4 py-3">
                <span class="text-sm text-text/70">{{ __('Two-factor authentication') }}</span>
                @if ($twoFactorEnabled)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-500/10 px-2.5 py-1 text-xs font-semibold text-green-600 dark:bg-green-500/20 dark:text-green-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ __('Enabled') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 dark:bg-neutral-700 px-2.5 py-1 text-xs font-semibold text-text/50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        {{ __('Not enabled') }}
                    </span>
                @endif
            </div>

            @if ($payoutAccount)
                <div class="rounded-xl border border-gray-100 dark:border-neutral-800 bg-gray-50 dark:bg-neutral-800/50 p-4">
                    <p class="text-xs text-text/40 uppercase tracking-wider mb-1">{{ __('Payout account') }}</p>
                    <p class="text-sm font-semibold text-text">{{ $payoutAccount['bank_name'] }}</p>
                    <p class="text-xs text-text/60 mt-0.5">{{ $payoutAccount['account_number'] }} &middot; {{ $payoutAccount['account_name'] }}</p>
                </div>
            @endif
        </div>
    </x-pages::settings.layout>
</section>
