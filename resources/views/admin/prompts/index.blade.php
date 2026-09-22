<x-layouts::app :title="__('Earning Prompts')">
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                    <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Earning Prompts') }}</h2>
                    <p class="text-xs text-text/50">{{ __('Manage voice and word prompts') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.prompts.bulk-import') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    {{ __('Bulk Import') }}
                </a>
                <a href="{{ route('admin.prompts.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-gradient-to-r from-primary to-secondary text-white text-xs font-semibold hover:from-primary/90 hover:to-secondary/90 transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    {{ __('Add Prompt') }}
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-lg font-bold text-text" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['total'] }}</p>
                <p class="text-[10px] text-text/40">Total</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-lg font-bold text-green-600" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['active'] }}</p>
                <p class="text-[10px] text-text/40">Active</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-lg font-bold text-red-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['inactive'] }}</p>
                <p class="text-[10px] text-text/40">Inactive</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-lg font-bold text-primary" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['sentences'] }}</p>
                <p class="text-[10px] text-text/40">Sentences</p>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                <p class="text-lg font-bold text-blue-500" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $stats['words'] }}</p>
                <p class="text-[10px] text-text/40">Words</p>
            </div>
        </div>

        {{-- Filters --}}
        <form method="GET" class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
            <div class="grid grid-cols-2 sm:grid-cols-6 gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search text..." class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                <select name="type" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">All types</option>
                    <option value="sentence" {{ request('type') === 'sentence' ? 'selected' : '' }}>Sentence</option>
                    <option value="word" {{ request('type') === 'word' ? 'selected' : '' }}>Word</option>
                </select>
                <select name="language" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">All languages</option>
                    @foreach(config('earning.languages') as $code => $label)
                        <option value="{{ $code }}" {{ request('language') === $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="category" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">All categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <select name="difficulty" class="rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 px-3 py-1.5 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">All difficulty</option>
                    <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
                <div class="flex gap-1.5">
                    <button type="submit" class="flex-1 px-3 py-1.5 rounded-lg bg-primary/10 text-primary text-xs font-medium hover:bg-primary/20 transition-colors">Filter</button>
                    <a href="{{ route('admin.prompts.index') }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/50 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Reset</a>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Text</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Language</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Difficulty</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Submissions</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-text/40 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($prompts as $prompt)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="text-xs text-text truncate max-w-xs">{{ $prompt->text }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($prompt->type === 'sentence')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-primary/10 text-primary">Sentence</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-500/10 text-blue-500">Word</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-text/60">{{ config('earning.languages.'.$prompt->language, $prompt->language) }}</td>
                                <td class="px-4 py-3 text-xs text-text/60">{{ $prompt->category ? ucfirst($prompt->category) : '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($prompt->difficulty === 'easy')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-500/10 text-green-600">Easy</span>
                                    @elseif ($prompt->difficulty === 'medium')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-600">Medium</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-600">Hard</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-text/60">{{ $prompt->submissions_count }}</td>
                                <td class="px-4 py-3">
                                    @if ($prompt->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-500/10 text-green-600 dark:text-green-400">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-600 dark:text-red-400">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.prompts.edit', $prompt) }}" class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/70 text-[10px] font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">Edit</a>
                                        <form method="POST" action="{{ route('admin.prompts.toggle', $prompt) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-medium transition-colors {{ $prompt->is_active ? 'bg-red-500/10 text-red-600 hover:bg-red-500/20' : 'bg-green-500/10 text-green-600 hover:bg-green-500/20' }}">
                                                {{ $prompt->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-text/40">
                                    No prompts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $prompts->links() }}
    </div>
</x-layouts::app>
