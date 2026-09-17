<x-layouts::app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">
                {{ __('Plan Management') }}
            </h2>
            <span class="text-sm text-text/50 dark:text-text/50">Admin Panel</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Plans Table --}}
            <div class="bg-white dark:bg-gray-800/50 backdrop-blur-sm overflow-hidden shadow-xl shadow-black/5 dark:shadow-black/20 sm:rounded-3xl border border-gray-100 dark:border-gray-700/50">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700/50">
                    <h3 class="text-lg font-semibold text-text dark:text-text">All Plans</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Voice Earn</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Word Game</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Popular</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-text/50 dark:text-text/50 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @forelse($plans as $plan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl {{ $plan->is_popular ? 'bg-gradient-to-br from-primary to-secondary' : 'bg-gray-100 dark:bg-gray-700' }} flex items-center justify-center">
                                                <svg class="w-5 h-5 {{ $plan->is_popular ? 'text-white' : 'text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-text dark:text-text">{{ $plan->name }}</div>
                                                <div class="text-xs text-text/50 dark:text-text/50">{{ $plan->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-text dark:text-text">₦{{ number_format($plan->price) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-secondary dark:text-secondary font-medium">₦{{ number_format($plan->voice_earn_per_session) }}/session</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-secondary dark:text-secondary font-medium">₦{{ number_format($plan->word_game_per_word) }}/word</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($plan->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($plan->is_popular)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 dark:bg-primary/20 text-primary">
                                                Popular
                                            </span>
                                        @else
                                            <span class="text-text/30 dark:text-text/30">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.plans.edit', $plan) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-text/70 dark:text-text/70 hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium transition-colors">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.plans.toggle', $plan) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg {{ $plan->is_active ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30' : 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30' }} text-sm font-medium transition-colors">
                                                    {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="text-text/30 dark:text-text/30">
                                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p>No plans found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
