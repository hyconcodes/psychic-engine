<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50/60 text-text dark:bg-neutral-950">

        {{-- Desktop Sidebar --}}
        <flux:sidebar sticky collapsible="mobile" class="border-e border-gray-100 bg-gradient-to-b from-white to-gray-50/50 dark:border-neutral-800 dark:from-neutral-900 dark:to-neutral-950/50">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="space-y-1">
                {{-- Main --}}
                <flux:sidebar.group>
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Home') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="microphone" :href="route('dashboard') . '#earn'" wire:navigate>
                        {{ __('Earn') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-path" :href="route('dashboard') . '#transactions'" wire:navigate>
                        {{ __('Transactions') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                {{-- Wallet --}}
                <flux:sidebar.group :heading="__('Wallet')">
                    <flux:sidebar.item icon="banknotes" :href="route('dashboard') . '#fund-wallet'" wire:navigate>
                        {{ __('Fund Wallet') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-up-right" :href="route('dashboard') . '#withdraw'" wire:navigate>
                        {{ __('Withdraw') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="sparkles" :href="route('dashboard') . '#plans'" wire:navigate>
                        {{ __('Plans & Upgrade') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                {{-- Community --}}
                <flux:sidebar.group :heading="__('Community')">
                    <flux:sidebar.item icon="user-group" :href="route('dashboard') . '#referrals'" wire:navigate>
                        {{ __('Referrals') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="trophy" :href="route('dashboard') . '#top-earners'" wire:navigate>
                        {{ __('Top Earners') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                {{-- Account --}}
                <flux:sidebar.group :heading="__('Account')">
                    <flux:sidebar.item icon="bell" :href="route('dashboard') . '#notifications'" wire:navigate>
                        {{ __('Notifications') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user" :href="route('profile.edit')" wire:navigate>
                        {{ __('Profile') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            {{-- Community Links --}}
            <div class="px-3 pb-3 space-y-2">
                <a href="#" class="sidebar-link-telegram flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                    Telegram Channel
                </a>
                <a href="#" class="sidebar-link-community flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                    Community Group
                </a>
            </div>

            {{-- User Menu --}}
            <div class="border-t border-gray-100 dark:border-neutral-800 p-3">
                <x-desktop-user-menu :name="auth()->user()->name" />
            </div>
        </flux:sidebar>

        {{-- Mobile Header --}}
        <flux:header class="lg:hidden sticky top-0 z-40 border-b border-gray-100 bg-white/80 backdrop-blur-md dark:border-neutral-800 dark:bg-neutral-900/80">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                <img src="/images/logo-icon.svg" alt="VocalPay" class="w-7 h-7">
                <span class="font-semibold text-text">VocalPay</span>
            </a>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold cursor-pointer">
                    {{ auth()->user()->initials() }}
                </div>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.radio.group>
                        <flux:menu.item
                            x-data
                            x-on:click="$flux.appearance = ($flux.appearance === 'dark' || ($flux.appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) ? 'light' : 'dark'"
                            x-bind:icon="($flux.appearance === 'light' || ($flux.appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)) ? 'moon' : 'sun'"
                            class="cursor-pointer"
                        >
                            <span x-text="($flux.appearance === 'light' || ($flux.appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)) ? '{{ __('Switch to Dark') }}' : '{{ __('Switch to Light') }}'"></span>
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{-- Page Content --}}
        {{-- <flux:main class="pb-24 lg:pb-6"> --}}
            {{ $slot }}

            {{-- Mobile Bottom Nav --}}
            <x-bottom-nav />

            @persist('toast')
                <flux:toast.group>
                    <flux:toast />
                </flux:toast.group>
            @endpersist

            @fluxScripts
        {{-- </flux:main> --}}
    </body>
</html>
