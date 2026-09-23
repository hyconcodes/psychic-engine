<x-layouts::app>
    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="flex-1">
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Audit Log') }}</h2>
                <p class="text-xs text-text/50">{{ __('Track all system changes and user actions') }}</p>
            </div>
            <x-refresh-button />
        </div>

        {{-- Filters --}}
        <form method="get" action="{{ route('admin.audit-logs.index') }}" class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-medium text-text/50 mb-1">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search descriptions...') }}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-xs text-text placeholder-text/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-text/50 mb-1">{{ __('Event') }}</label>
                    <select name="event" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        <option value="">{{ __('All events') }}</option>
                        <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>{{ __('Created') }}</option>
                        <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>{{ __('Updated') }}</option>
                        <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-text/50 mb-1">{{ __('Model') }}</label>
                    <select name="model" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        <option value="">{{ __('All models') }}</option>
                        @foreach($models as $model)
                            <option value="{{ $model }}" {{ request('model') === $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-text/50 mb-1">{{ __('Date from') }}</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-text/50 mb-1">{{ __('Date to') }}</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 py-2 text-xs text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary/90 transition-colors">{{ __('Filter') }}</button>
                    <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-neutral-800 text-text/60 text-xs font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">{{ __('Clear') }}</a>
                </div>
            </div>
        </form>

        {{-- Audit Log Table --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Time') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('User') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Event') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Model') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('Description') }}</th>
                            <th class="px-4 py-3 text-left text-[11px] font-semibold text-text/40 uppercase tracking-wider">{{ __('IP') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-neutral-800/50">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-800/30 transition-colors" x-data="{ open: false }">
                                <td class="px-4 py-3 text-[11px] text-text/50 whitespace-nowrap">{{ $log->created_at->format('M d, Y') }}<br>{{ $log->created_at->format('h:i A') }}</td>
                                <td class="px-4 py-3">
                                    @if($log->user)
                                        <p class="text-xs font-medium text-text">{{ $log->user->name }}</p>
                                        <p class="text-[10px] text-text/40">{{ '@'.$log->user->username }}</p>
                                    @else
                                        <p class="text-[11px] text-text/30">System</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($log->event === 'created')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('Created') }}</span>
                                    @elseif($log->event === 'updated')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ __('Updated') }}</span>
                                    @elseif($log->event === 'deleted')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ __('Deleted') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-[11px] text-text/60 font-mono">{{ class_basename($log->auditable_type) }}</td>
                                <td class="px-4 py-3 max-w-xs">
                                    <button @click="open = !open" class="text-left text-xs text-text/70 hover:text-text transition-colors cursor-pointer truncate block max-w-[300px]">
                                        {{ $log->description }}
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-[10px] text-text/30 font-mono">{{ $log->ip_address ?? '—' }}</td>
                            </tr>
                            <tr x-show="open" x-cloak>
                                <td colspan="6" class="px-4 py-3 bg-gray-50 dark:bg-neutral-800/50">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @if(!empty($log->old_values))
                                            <div>
                                                <p class="text-[10px] font-semibold text-text/40 uppercase mb-1">{{ __('Old Values') }}</p>
                                                <pre class="text-[11px] text-text/60 bg-white dark:bg-neutral-900 rounded-lg p-2 overflow-x-auto border border-gray-100 dark:border-neutral-700">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        @endif
                                        @if(!empty($log->new_values))
                                            <div>
                                                <p class="text-[10px] font-semibold text-text/40 uppercase mb-1">{{ __('New Values') }}</p>
                                                <pre class="text-[11px] text-text/60 bg-white dark:bg-neutral-900 rounded-lg p-2 overflow-x-auto border border-gray-100 dark:border-neutral-700">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        @endif
                                    </div>
                                    @if($log->user_agent)
                                        <div class="mt-2">
                                            <p class="text-[10px] font-semibold text-text/40 uppercase mb-1">{{ __('User Agent') }}</p>
                                            <p class="text-[10px] text-text/30 truncate">{{ $log->user_agent }}</p>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-xs text-text/40">{{ __('No audit log entries found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-100 dark:border-neutral-800">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>
