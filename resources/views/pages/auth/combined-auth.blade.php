@php
    $initialForm = request()->route()->getName() === 'register' ? 'register' : 'login';
@endphp

<x-layouts::auth :title="$initialForm === 'register' ? __('Register') : __('Login')">
    <div x-data="{ activeTab: '{{ $initialForm }}', refUsername: new URLSearchParams(window.location.search).get('ref') || '', showRefToast: false, refToastMsg: '' }" x-init="if (refUsername) { refToastMsg = 'Invited by @' + refUsername; showRefToast = true; setTimeout(() => showRefToast = false, 3000); }" class="flex flex-col gap-0">

        {{-- Header --}}
        <div class="text-center mb-1">
            <p class="text-xs font-semibold tracking-widest text-primary uppercase mb-2">{{ __('Get Started') }}</p>
            <flux:heading size="xl" level="1" class="font-serif-display text-text" style="font-family: 'DM Serif Display', Georgia, serif;">
                {{ __('Create your VocalPay account') }}
            </flux:heading>
            <flux:subheading class="text-text/50">{{ __('Join the contributor network and start taking AI training activities.') }}</flux:subheading>
        </div>

        {{-- Tab Toggle --}}
        <div class="bg-neutral-100 dark:bg-neutral-800 rounded-full p-1 flex mt-4 mb-6">
            <button
                @click="activeTab = 'register'"
                :class="activeTab === 'register' ? 'bg-white dark:bg-neutral-700 shadow-sm text-text font-semibold' : 'text-text/50 hover:text-text/70'"
                class="flex-1 py-2.5 rounded-full text-sm transition-all duration-200 cursor-pointer"
            >
                {{ __('Create account') }}
            </button>
            <button
                @click="activeTab = 'login'"
                :class="activeTab === 'login' ? 'bg-white dark:bg-neutral-700 shadow-sm text-text font-semibold' : 'text-text/50 hover:text-text/70'"
                class="flex-1 py-2.5 rounded-full text-sm transition-all duration-200 cursor-pointer"
            >
                {{ __('Sign in') }}
            </button>
        </div>

        {{-- Toast Notifications --}}
        @php
            $toastMessage = session('toast_message');
            $toastVariant = session('toast_variant', 'success');
        @endphp
        @if ($toastMessage)
            <div
                x-data="{
                    show: false,
                    message: @js($toastMessage),
                    variant: @js($toastVariant),
                    init() {
                        this.show = true;
                        setTimeout(() => { this.show = false; }, 3000);
                    }
                }"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[100]"
            >
                <div class="flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg border"
                    :class="{
                        'bg-green-50 border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400': variant === 'success',
                        'bg-red-50 border-red-200 text-red-700 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400': variant === 'danger' || variant === 'error',
                        'bg-amber-50 border-amber-200 text-amber-700 dark:bg-amber-900/30 dark:border-amber-800 dark:text-amber-400': variant === 'warning',
                        'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400': variant === 'info'
                    }"
                >
                    <template x-if="variant === 'success'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </template>
                    <template x-if="variant === 'danger' || variant === 'error'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    </template>
                    <template x-if="variant === 'warning'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </template>
                    <template x-if="variant === 'info'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    </template>
                    <span class="text-sm font-medium" x-text="message"></span>
                    <button @click="show = false" class="ml-2 shrink-0 opacity-60 hover:opacity-100 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Also show validation errors as toast --}}
        @if ($errors->any())
            <div
                x-data="{
                    show: false,
                    errors: @js($errors->all()),
                    init() {
                        this.show = true;
                        setTimeout(() => { this.show = false; }, 3000);
                    }
                }"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[100] max-w-md w-full"
            >
                <div class="flex items-start gap-3 px-5 py-3 rounded-xl shadow-lg border bg-red-50 border-red-200 text-red-700 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    <div class="flex-1 text-sm">
                        <template x-if="errors.length === 1">
                            <span x-text="errors[0]"></span>
                        </template>
                        <template x-if="errors.length > 1">
                            <ul class="list-disc list-inside space-y-0.5">
                                <template x-for="(err, i) in errors" :key="i">
                                    <li x-text="err"></li>
                                </template>
                            </ul>
                        </template>
                    </div>
                    <button @click="show = false" class="ml-2 shrink-0 opacity-60 hover:opacity-100 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Referral Toast --}}
        <div
            x-show="showRefToast"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed bottom-4 left-1/2 -translate-x-1/2 z-[100]"
        >
            <div class="flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg border bg-green-50 border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                <span class="text-sm font-medium" x-text="refToastMsg"></span>
                <button @click="showRefToast = false" class="ml-2 shrink-0 opacity-60 hover:opacity-100 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Register Form --}}
        <div x-show="activeTab === 'register'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <form method="POST" action="{{ route('register.store') }}" x-data="{ submitting: false, showPassword: false }" @submit="if (submitting) { $event.preventDefault(); return; } submitting = true" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="reg-name" class="block text-sm font-medium text-text mb-1.5">{{ __('Full name') }}</label>
                    <input
                        id="reg-name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="e.g. Alex Johnson"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="reg-username" class="block text-sm font-medium text-text mb-1.5">{{ __('Username') }}</label>
                    <input
                        id="reg-username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        required
                        maxlength="8"
                        autocomplete="username"
                        placeholder="e.g. alexjohn"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="reg-email" class="block text-sm font-medium text-text mb-1.5">{{ __('Email address') }}</label>
                    <input
                        id="reg-email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="you@example.com"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="reg-phone" class="block text-sm font-medium text-text mb-1.5">{{ __('Phone number') }} <span class="text-text/30">({{ __('optional') }})</span></label>
                    <input
                        id="reg-phone"
                        name="phone"
                        type="tel"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        placeholder="e.g. 08012345678"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="reg-ref" class="block text-sm font-medium text-text mb-1.5">{{ __('Referral Username') }} <span class="text-text/30">({{ __('optional') }})</span></label>
                    <input
                        id="reg-ref"
                        name="ref"
                        type="text"
                        x-model="refUsername"
                        autocomplete="off"
                        placeholder="e.g. puqoh"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <label for="reg-password" class="block text-sm font-medium text-text mb-1.5">{{ __('Create password') }}</label>
                    <div class="relative">
                        <input
                            id="reg-password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            autocomplete="new-password"
                            placeholder="At least 8 characters"
                            passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 pr-12 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                        >
                        <button type="button" @click="showPassword = !showPassword" :aria-pressed="showPassword" aria-label="{{ __('Toggle password visibility') }}" class="absolute inset-y-0 right-0 flex items-center px-4 text-text/40 hover:text-primary transition-colors cursor-pointer">
                            <template x-if="!showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                            </template>
                            <template x-if="showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.584 10.587A2.25 2.25 0 0013.5 13.5M9.88 5.275A9.82 9.82 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a18.09 18.09 0 01-3.197 4.044M6.228 6.228A18.13 18.13 0 002.25 12S6 18.75 12 18.75a9.9 9.9 0 003.725-.725"/></svg>
                            </template>
                        </button>
                    </div>
                </div>

                <button type="submit" :disabled="submitting" class="w-full bg-primary hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-full text-sm transition-colors mt-2 cursor-pointer flex items-center justify-center gap-2">
                    <template x-if="!submitting">
                        <span>{{ __('Create Free Account') }} &rarr;</span>
                    </template>
                    <template x-if="submitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            {{ __('Creating account...') }}
                        </span>
                    </template>
                </button>

                <p class="text-xs text-center text-text/40">
                    {{ __('By creating an account, you agree to our') }}
                    <a href="#" class="text-primary hover:text-primary/80">{{ __('Terms') }}</a>
                    {{ __('and') }}
                    <a href="#" class="text-primary hover:text-primary/80">{{ __('Privacy Policy') }}</a>.
                </p>
            </form>

            <p class="text-xs text-center text-text/40 mt-5">
                {{ __('Already have an account?') }}
                <button @click="activeTab = 'login'" class="text-primary hover:text-primary/80 font-semibold cursor-pointer">{{ __('Sign in') }}</button>
            </p>
        </div>

        {{-- Login Form --}}
        <div x-show="activeTab === 'login'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <form method="POST" action="{{ route('login.store') }}" x-data="{ submitting: false, showPassword: false }" @submit="if (submitting) { $event.preventDefault(); return; } submitting = true" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="login-email" class="block text-sm font-medium text-text mb-1.5">{{ __('Email address') }}</label>
                    <input
                        id="login-email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="you@example.com"
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                    >
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="login-password" class="block text-sm font-medium text-text">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-primary hover:text-primary/80" wire:navigate>
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input
                            id="login-password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-3 pr-12 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                        >
                        <button type="button" @click="showPassword = !showPassword" :aria-pressed="showPassword" aria-label="{{ __('Toggle password visibility') }}" class="absolute inset-y-0 right-0 flex items-center px-4 text-text/40 hover:text-primary transition-colors cursor-pointer">
                            <template x-if="!showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                            </template>
                            <template x-if="showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.584 10.587A2.25 2.25 0 0013.5 13.5M9.88 5.275A9.82 9.82 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a18.09 18.09 0 01-3.197 4.044M6.228 6.228A18.13 18.13 0 002.25 12S6 18.75 12 18.75a9.9 9.9 0 003.725-.725"/></svg>
                            </template>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-neutral-600 text-primary focus:ring-primary">
                    <label for="remember" class="text-sm text-text/60">{{ __('Remember me') }}</label>
                </div>

                <button type="submit" :disabled="submitting" class="w-full bg-primary hover:bg-primary/90 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-full text-sm transition-colors mt-1 cursor-pointer flex items-center justify-center gap-2">
                    <template x-if="!submitting">
                        <span>{{ __('Sign in') }}</span>
                    </template>
                    <template x-if="submitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            {{ __('Signing in...') }}
                        </span>
                    </template>
                </button>
            </form>

            <p class="text-xs text-center text-text/40 mt-5">
                {{ __('Don\'t have an account?') }}
                <button @click="activeTab = 'register'" class="text-primary hover:text-primary/80 font-semibold cursor-pointer">{{ __('Create account') }}</button>
            </p>
        </div>

        {{-- Back Link --}}
        <div class="text-center mt-6 pt-4 border-t border-gray-100 dark:border-neutral-800">
            <a href="{{ route('home') }}" class="text-sm text-primary hover:text-primary/80 font-medium">
                &larr; {{ __('Back to VocalPay') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
