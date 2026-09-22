<x-layouts::app :title="__('Bulk Import Prompts')">
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prompts.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Bulk Import Prompts') }}</h2>
                <p class="text-xs text-text/50">{{ __('Import multiple prompts from a CSV file (one prompt per line)') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.prompts.bulk-import.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm space-y-4">
                {{-- Instructions --}}
                <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800/30 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        <div class="text-xs text-blue-700 dark:text-blue-400 space-y-1">
                            <p class="font-semibold">CSV Format Instructions:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Each line should contain one prompt text</li>
                                <li>No header row needed (or include "text" as the first line — it will be skipped)</li>
                                <li>Empty lines are automatically skipped</li>
                                <li>Duplicate prompts (same type + language + text) are skipped</li>
                                <li>Max file size: 10MB</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="csv_file" class="block text-xs font-semibold text-text/60 mb-1">CSV File</label>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer">
                        @error('csv_file') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="type" class="block text-xs font-semibold text-text/60 mb-1">Type</label>
                        <select name="type" id="type" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            <option value="sentence">Sentence (Voice Earn)</option>
                            <option value="word">Word (Word Game)</option>
                        </select>
                    </div>
                    <div>
                        <label for="language" class="block text-xs font-semibold text-text/60 mb-1">Language</label>
                        <select name="language" id="language" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            @foreach(config('earning.languages') as $code => $label)
                                <option value="{{ $code }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('language') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="category" class="block text-xs font-semibold text-text/60 mb-1">Category</label>
                        <input type="text" name="category" id="category" list="categories" value="{{ old('category') }}" placeholder="e.g. greetings, food" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        <datalist id="categories">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label for="difficulty" class="block text-xs font-semibold text-text/60 mb-1">Difficulty</label>
                        <select name="difficulty" id="difficulty" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none" required>
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.prompts.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Cancel</a>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold hover:from-primary/90 hover:to-secondary/90 transition-colors shadow-sm">Import Prompts</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>
