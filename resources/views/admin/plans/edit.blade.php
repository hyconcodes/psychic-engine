<x-layouts::app>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.plans.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Edit Plan') }}</h2>
                <p class="text-xs text-text/50">{{ $plan->name }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-medium text-text mb-1">{{ __('Plan name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                        class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="price" class="block text-xs font-medium text-text mb-1">{{ __('Price (₦)') }}</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" required min="0" step="0.01"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-medium text-text mb-1">{{ __('Sort order') }}</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" required min="0"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="voice_earn_per_session" class="block text-xs font-medium text-text mb-1">{{ __('Voice / session (₦)') }}</label>
                        <input type="number" name="voice_earn_per_session" id="voice_earn_per_session" value="{{ old('voice_earn_per_session', $plan->voice_earn_per_session) }}" required min="0" step="0.01"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="word_game_per_word" class="block text-xs font-medium text-text mb-1">{{ __('Word / word (₦)') }}</label>
                        <input type="number" name="word_game_per_word" id="word_game_per_word" value="{{ old('word_game_per_word', $plan->word_game_per_word) }}" required min="0" step="0.01"
                            class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-text mb-1">{{ __('Features') }}</label>
                    <div id="features-container" class="space-y-2">
                        @foreach (old('features', $plan->features ?? []) as $feature)
                            <div class="flex items-center gap-2">
                                <input type="text" name="features[]" value="{{ $feature }}" required
                                    class="flex-1 rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                                <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-500/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addFeature()" class="mt-2 inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                        {{ __('Add feature') }}
                    </button>
                </div>

                <div class="flex items-center gap-5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_popular" value="0">
                        <input type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 dark:border-neutral-600 text-primary focus:ring-primary">
                        <span class="text-xs font-medium text-text">{{ __('Popular') }}</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 dark:border-neutral-600 text-primary focus:ring-primary">
                        <span class="text-xs font-medium text-text">{{ __('Active') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100 dark:border-neutral-800">
                    <a href="{{ route('admin.plans.index') }}" class="px-3.5 py-2 text-sm font-medium text-text/60 hover:text-text transition-colors">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90 transition-all cursor-pointer">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addFeature() {
            const container = document.getElementById('features-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2';
            div.innerHTML = `
                <input type="text" name="features[]" required
                    class="flex-1 rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3.5 py-2 text-sm text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-500/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</x-layouts::app>
