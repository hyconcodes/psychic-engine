<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50/60 text-text dark:bg-neutral-950">

        {{-- Desktop Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 w-72 hidden lg:flex flex-col border-e border-gray-100 bg-white dark:border-neutral-800 dark:bg-neutral-900">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 h-16 border-b border-gray-100 dark:border-neutral-800 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5" wire:navigate>
                    <img src="/images/logo-icon.svg" alt="VocalPay" class="w-8 h-8">
                    <span class="text-lg font-bold text-text tracking-tight">Vocal<span class="text-primary">Pay</span></span>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                {{-- Main --}}
                <a href="{{ route('dashboard') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'active' : 'text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5' }}" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Home
                </a>
                <a href="{{ route('dashboard') }}#earn" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    Earn
                </a>
                <a href="{{ route('dashboard') }}#transactions" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    Transactions
                </a>

                <div class="!mt-5 !mb-2 px-3 text-[10px] font-semibold text-text/30 uppercase tracking-widest">Wallet</div>

                <a href="{{ route('wallet.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('wallet.*') ? 'active' : 'text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5' }}" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    Fund Wallet
                </a>
                <a href="{{ route('dashboard') }}#withdraw" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Withdraw
                </a>
                <a href="{{ route('plans.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('plans.*') ? 'active' : 'text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5' }}" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                    Plans & Upgrade
                </a>

                <div class="!mt-5 !mb-2 px-3 text-[10px] font-semibold text-text/30 uppercase tracking-widest">Community</div>

                <a href="{{ route('dashboard') }}#referrals" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                    Referrals
                </a>
                <a href="{{ route('dashboard') }}#top-earners" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0016.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.023 6.023 0 01-2.77.665 6.023 6.023 0 01-2.77-.665"/></svg>
                    Top Earners
                </a>

                <div class="!mt-5 !mb-2 px-3 text-[10px] font-semibold text-text/30 uppercase tracking-widest">Account</div>

                <a href="{{ route('dashboard') }}#notifications" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    Notifications
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5" wire:navigate>
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>

                @if(auth()->check() && auth()->user()->email === 'admin@vocalpay.co')
                    <div class="!mt-5 !mb-2 px-3 text-[10px] font-semibold text-text/30 uppercase tracking-widest">Admin</div>
                    <a href="{{ route('admin.plans.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.*') ? 'active' : 'text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5' }}" wire:navigate>
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/></svg>
                        Plan Management
                    </a>
                @endif

                {{-- Community Links --}}
                <div class="!mt-5 space-y-2">
                    <a href="#" class="sidebar-link-telegram flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                        Telegram Channel
                    </a>
                    <a href="#" class="sidebar-link-community flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium transition-all shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                        Community Group
                    </a>
                </div>
            </nav>

            {{-- Bottom: Dark Mode Toggle + User + Logout --}}
            <div class="shrink-0 border-t border-gray-100 dark:border-neutral-800 p-3 space-y-1">
                {{-- Dark Mode Toggle --}}
                <button
                    x-data
                    x-on:click="$flux.appearance = ($flux.appearance === 'dark' || ($flux.appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) ? 'light' : 'dark'"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-text/60 hover:text-text hover:bg-gray-100 dark:hover:bg-white/5 transition-all cursor-pointer"
                >
                    <template x-if="($flux.appearance === 'light') || ($flux.appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                    </template>
                    <template x-if="($flux.appearance === 'dark') || ($flux.appearance === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                    </template>
                    <span x-text="($flux.appearance === 'light' || ($flux.appearance === 'system' && !window.matchMedia('(prefers-color-scheme: dark)').matches)) ? 'Dark Mode' : 'Light Mode'"></span>
                </button>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-text/60 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 transition-all cursor-pointer">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile Header --}}
        <flux:header class="lg:hidden sticky top-0 z-40 border-b border-gray-100 bg-white/80 backdrop-blur-md dark:border-neutral-800 dark:bg-neutral-900/80">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                <img src="/images/logo-icon.svg" alt="VocalPay" class="w-7 h-7">
                <span class="font-semibold text-text">VocalPay</span>
            </a>

            <flux:spacer />

            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold">
                {{ auth()->user()->initials() }}
            </div>
        </flux:header>

        {{-- Page Content --}}
        <div class="lg:pl-72 min-h-screen">
            <div class="px-4 sm:px-6 lg:px-8 py-6 pb-24 lg:pb-6 max-w-5xl mx-auto">
                {{ $slot }}
            </div>
        </div>

        {{-- Mobile Sidebar --}}
        <flux:sidebar collapsible="mobile" class="lg:hidden">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse />
            </flux:sidebar.header>

            <flux:sidebar.nav class="space-y-1">
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

                <flux:sidebar.group :heading="__('Wallet')">
                    <flux:sidebar.item icon="banknotes" :href="route('wallet.index')" :current="request()->routeIs('wallet.*')" wire:navigate>
                        {{ __('Fund Wallet') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-up-right" :href="route('dashboard') . '#withdraw'" wire:navigate>
                        {{ __('Withdraw') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="sparkles" :href="route('plans.index')" wire:navigate>
                        {{ __('Plans & Upgrade') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Community')">
                    <flux:sidebar.item icon="user-group" :href="route('dashboard') . '#referrals'" wire:navigate>
                        {{ __('Referrals') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="trophy" :href="route('dashboard') . '#top-earners'" wire:navigate>
                        {{ __('Top Earners') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Account')">
                    <flux:sidebar.item icon="bell" :href="route('dashboard') . '#notifications'" wire:navigate>
                        {{ __('Notifications') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user" :href="route('profile.edit')" wire:navigate>
                        {{ __('Profile') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @if(auth()->check() && auth()->user()->email === 'admin@vocalpay.co')
                    <flux:sidebar.group :heading="__('Admin')">
                        <flux:sidebar.item icon="cog-6-tooth" :href="route('admin.plans.index')" wire:navigate>
                            {{ __('Plan Management') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

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

            <div class="border-t border-gray-100 dark:border-neutral-800 p-3">
                <x-desktop-user-menu :name="auth()->user()->name" />
            </div>
        </flux:sidebar>

        {{-- Mobile Bottom Nav --}}
        <x-bottom-nav />

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
