<x-layouts::app>
    <div class="space-y-5">
        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Plan Management') }}</h2>
                <p class="text-xs text-text/50">{{ __('Manage subscription plans and earning rates') }}</p>
            </div>
            <x-refresh-button />
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-neutral-800">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Plan') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Price') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Voice') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Word') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Daily') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-text/40 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-neutral-800">
                        @forelse ($plans as $plan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg {{ $plan->is_popular ? 'bg-gradient-to-br from-primary to-secondary' : 'bg-gray-100 dark:bg-neutral-800' }} flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 {{ $plan->is_popular ? 'text-white' : 'text-primary' }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-text truncate">{{ $plan->name }}</p>
                                            @if ($plan->is_popular)
                                                <span class="text-[10px] font-semibold text-primary">{{ __('Popular') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-semibold text-text">₦{{ number_format((float) $plan->price) }}</td>
                                <td class="px-4 py-3 text-text/70">₦{{ number_format((float) $plan->voice_earn_per_session) }}</td>
                                <td class="px-4 py-3 text-text/70">₦{{ number_format((float) $plan->word_game_per_word) }}</td>
                                <td class="px-4 py-3 text-xs text-text/60">{{ $plan->daily_voice_tasks }}/{{ $plan->daily_word_tasks }}</td>
                                <td class="px-4 py-3">
                                    @if ($plan->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-500/10 text-green-600 dark:text-green-400">{{ __('Active') }}</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-600 dark:text-red-400">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-gray-100 dark:bg-neutral-800 text-text/70 text-xs font-medium hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('admin.plans.toggle', $plan) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $plan->is_active ? 'bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20' : 'bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-500/20' }}">
                                                {{ $plan->is_active ? __('Deactivate') : __('Activate') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-text/40">
                                    {{ __('No plans found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
