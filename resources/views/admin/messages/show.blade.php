<x-layouts::app :title="__('Message: '.$message->subject)">
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.messages.index') }}" class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-3.5 h-3.5 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="flex-1 min-w-0">
                <h2 class="font-semibold text-lg text-text leading-tight truncate">{{ $message->subject }}</h2>
                <p class="text-[10px] text-text/40">From {{ $message->name }} · {{ $message->email }}</p>
            </div>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this message?')" class="px-2.5 py-1.5 rounded-lg bg-red-500/10 text-red-600 text-[10px] font-medium hover:bg-red-500/20 transition-colors">Delete</button>
            </form>
        </div>

        {{-- Original Message --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-pink-500/10 rounded-full flex items-center justify-center text-pink-500 text-[10px] font-bold">{{ strtoupper(substr($message->name, 0, 2)) }}</div>
                <div>
                    <p class="text-[11px] font-semibold text-text">{{ $message->name }}</p>
                    <p class="text-[9px] text-text/30">{{ $message->email }} · {{ $message->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
            <div class="text-[11px] text-text/70 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>

        {{-- Reply Form --}}
        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
            @csrf
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[8px] font-bold">AP</div>
                    <p class="text-[10px] font-semibold text-text">Reply to {{ $message->name }}</p>
                </div>
                <div>
                    <textarea name="reply_message" rows="4" required placeholder="Type your reply..." class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-[11px] text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none resize-none">{{ old('reply_message') }}</textarea>
                    @error('reply_message') <p class="text-[9px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[9px] text-text/30">Reply will be sent from vocalpay247@gmail.com</p>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-[11px] font-semibold hover:from-primary/90 hover:to-secondary/90 transition-colors shadow-sm">Send Reply</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>
