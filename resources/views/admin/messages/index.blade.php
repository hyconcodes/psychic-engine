<x-layouts::app :title="__('Contact Messages')">
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-lg text-text leading-tight">{{ __('Contact Messages') }}</h2>
                <p class="text-[10px] text-text/40">{{ $stats['unread'] }} unread of {{ $stats['total'] }} total</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['total'] }}</p>
                <p class="text-[9px] text-text/40">Total</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-pink-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['unread'] }}</p>
                <p class="text-[9px] text-text/40">Unread</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
                <p class="text-base font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['read'] }}</p>
                <p class="text-[9px] text-text/40">Read</p>
            </div>
        </div>

        <form method="GET" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-2.5 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 min-w-[140px] rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-[11px] text-text focus:border-primary outline-none">
                <select name="status" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-[11px] text-text focus:border-primary outline-none">
                    <option value="">All</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                </select>
                <button type="submit" class="px-3 py-1.5 rounded-lg bg-primary/10 text-primary text-[11px] font-medium hover:bg-primary/20 transition-colors">Filter</button>
                <a href="{{ route('admin.messages.index') }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/50 text-[11px] font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Reset</a>
            </div>
        </form>

        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-100 dark:divide-neutral-800">
                @forelse($messages as $msg)
                    <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-start gap-3 p-3 hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="w-7 h-7 {{ is_null($msg->read_at) ? 'bg-pink-500/10' : 'bg-gray-100 dark:bg-neutral-800' }} rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 {{ is_null($msg->read_at) ? 'text-pink-500' : 'text-text/30' }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-[11px] font-semibold text-text truncate">{{ $msg->name }}</p>
                                <p class="text-[9px] text-text/25 shrink-0">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-[10px] text-text/50 truncate">{{ $msg->subject }}</p>
                            <p class="text-[9px] text-text/30 truncate">{{ Str::limit($msg->message, 80) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-[10px] text-text/30">No messages found</div>
                @endforelse
            </div>
        </div>

        {{ $messages->links() }}
    </div>
</x-layouts::app>
