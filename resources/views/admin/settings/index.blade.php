<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Community Group Settings') }}</h2>
                <p class="text-xs text-text/50">{{ __('Set the WhatsApp or Telegram group link shown in the sidebar') }}</p>
            </div>
            <x-refresh-button />
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <form method="post" action="{{ route('admin.settings.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="community_group_link" class="block text-xs font-medium text-text mb-1">{{ __('Community Group Link') }}</label>
                    <input type="url" name="community_group_link" id="community_group_link" value="{{ old('community_group_link', $setting->community_group_link) }}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors" placeholder="{{ __('https://chat.whatsapp.com/EXAMPLE') }}">
                    <p class="mt-1 text-[11px] text-text/40">{{ __('Share this link with your community group members.') }}</p>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all">{{ __('Save Settings') }}</button>
                    @if($setting->community_group_link)
                        <a href="{{ $setting->community_group_link }}" target="_blank" class="px-4 py-2 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">{{ __('Test Link') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
