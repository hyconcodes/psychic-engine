@php
    $user = auth()->user();
@endphp

<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-neutral-900 border-t border-gray-100 dark:border-neutral-800 lg:hidden" style="padding-bottom: env(safe-area-inset-bottom)">
    <div class="grid grid-cols-4 h-16">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-text/40 hover:text-text/60' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('earn.index') }}" class="flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('earn.*') ? 'text-primary' : 'text-text/40 hover:text-text/60' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
            <span class="text-[10px] font-medium">Earn</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-text/40 hover:text-text/60' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </div>
</nav>
