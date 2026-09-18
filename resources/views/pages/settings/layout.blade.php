<div class="flex items-start gap-6 max-md:flex-col">
    <aside class="w-full shrink-0 md:w-56">
        <nav class="flex gap-1 overflow-x-auto pb-2 md:flex-col md:overflow-visible md:pb-0">
            <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-[13px] font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-md shadow-primary/20' : 'text-text/60 hover:bg-gray-100 hover:text-text dark:hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                {{ __('Profile') }}
            </a>
            <a href="{{ route('payout.edit') }}" wire:navigate class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-[13px] font-medium transition-all {{ request()->routeIs('payout.edit') ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-md shadow-primary/20' : 'text-text/60 hover:bg-gray-100 hover:text-text dark:hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                {{ __('Payout Account') }}
            </a>
            <a href="{{ route('security.edit') }}" wire:navigate class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-[13px] font-medium transition-all {{ request()->routeIs('security.edit') ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-md shadow-primary/20' : 'text-text/60 hover:bg-gray-100 hover:text-text dark:hover:bg-white/5' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                {{ __('Security') }}
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-[13px] font-medium transition-all text-text/60 hover:bg-gray-100 hover:text-text dark:hover:bg-white/5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg>
                {{ __('Help & Support') }}
            </a>
        </nav>
    </aside>

    <div class="min-w-0 flex-1">
        <div class="rounded-2xl border border-gray-100 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-5 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-text leading-tight">{{ $heading ?? '' }}</h2>
                <p class="text-xs text-text/50 mt-0.5">{{ $subheading ?? '' }}</p>
            </div>

            <div class="w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
