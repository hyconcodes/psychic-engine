<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">
                {{ __('Edit Plan') }} - {{ $plan->name }}
            </h2>
            <a href="{{ route('admin.plans.index') }}" class="text-sm text-primary hover:text-primary/80 font-medium">
                &larr; Back to Plans
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800/50 backdrop-blur-sm overflow-hidden shadow-xl shadow-black/5 dark:shadow-black/20 sm:rounded-3xl border border-gray-100 dark:border-gray-700/50">
                <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-text dark:text-text mb-2">Plan Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="price" class="block text-sm font-medium text-text dark:text-text mb-2">Price (₦)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" required min="0" step="0.01"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                    </div>

                    {{-- Earnings --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="voice_earn_per_session" class="block text-sm font-medium text-text dark:text-text mb-2">Voice Earn per Session (₦)</label>
                            <input type="number" name="voice_earn_per_session" id="voice_earn_per_session" value="{{ old('voice_earn_per_session', $plan->voice_earn_per_session) }}" required min="0" step="0.01"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                        </div>
                        <div>
                            <label for="word_game_per_word" class="block text-sm font-medium text-text dark:text-text mb-2">Word Game per Word (₦)</label>
                            <input type="number" name="word_game_per_word" id="word_game_per_word" value="{{ old('word_game_per_word', $plan->word_game_per_word) }}" required min="0" step="0.01"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                        </div>
                    </div>

                    {{-- Features --}}
                    <div>
                        <label class="block text-sm font-medium text-text dark:text-text mb-2">Features</label>
                        <div id="features-container" class="space-y-3">
                            @foreach(old('features', $plan->features ?? []) as $index => $feature)
                                <div class="flex items-center gap-3">
                                    <input type="text" name="features[]" value="{{ $feature }}" required
                                        class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                                    <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addFeature()" class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-text/70 dark:text-text/70 hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Feature
                        </button>
                    </div>

                    {{-- Sort Order --}}
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-text dark:text-text mb-2">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $plan->sort_order) }}" required min="0"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                    </div>

                    {{-- Toggles --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_popular" value="0">
                            <input type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}
                                class="w-5 h-5 text-primary border-gray-300 dark:border-gray-600 rounded focus:ring-primary">
                            <label for="is_popular" class="text-sm font-medium text-text dark:text-text">Mark as Popular</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-primary border-gray-300 dark:border-gray-600 rounded focus:ring-primary">
                            <label for="is_active" class="text-sm font-medium text-text dark:text-text">Active</label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                        <a href="{{ route('admin.plans.index') }}" class="px-4 py-2 text-sm font-medium text-text/70 dark:text-text/70 hover:text-text dark:hover:text-text transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white font-semibold shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addFeature() {
            const container = document.getElementById('features-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3';
            div.innerHTML = `
                <input type="text" name="features[]" required
                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 dark:text-text shadow-sm focus:border-primary focus:ring-primary text-sm">
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</x-layouts::app>
