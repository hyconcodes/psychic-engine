<x-layouts::app :title="__('Edit Earning Prompt')">
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prompts.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Edit Earning Prompt') }}</h2>
                <p class="text-xs text-text/50">{{ $prompt->text }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.prompts.update', $prompt) }}">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-xs font-semibold text-text/60 mb-1">Type</label>
                        <select name="type" id="type" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            <option value="sentence" {{ old('type', $prompt->type) === 'sentence' ? 'selected' : '' }}>Sentence (Voice Earn)</option>
                            <option value="word" {{ old('type', $prompt->type) === 'word' ? 'selected' : '' }}>Word (Word Game)</option>
                        </select>
                        @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="language" class="block text-xs font-semibold text-text/60 mb-1">Language</label>
                        <select name="language" id="language" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            @foreach(config('earning.languages') as $code => $label)
                                <option value="{{ $code }}" {{ old('language', $prompt->language) === $code ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('language') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="category" class="block text-xs font-semibold text-text/60 mb-1">Category</label>
                        <input type="text" name="category" id="category" list="categories" value="{{ old('category', $prompt->category) }}" placeholder="e.g. greetings, food, travel" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        <datalist id="categories">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                        @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="difficulty" class="block text-xs font-semibold text-text/60 mb-1">Difficulty</label>
                        <select name="difficulty" id="difficulty" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            <option value="easy" {{ old('difficulty', $prompt->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $prompt->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $prompt->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="text" class="block text-xs font-semibold text-text/60 mb-1">Prompt Text</label>
                    <textarea name="text" id="text" rows="3" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none resize-none">{{ old('text', $prompt->text) }}</textarea>
                    @error('text') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('admin.prompts.destroy', $prompt) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="px-4 py-2 rounded-xl bg-red-500/10 text-red-600 text-xs font-medium hover:bg-red-500/20 transition-colors">Delete</button>
                    </form>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.prompts.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Cancel</a>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold hover:from-primary/90 hover:to-secondary/90 transition-colors shadow-sm">Update Prompt</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>
