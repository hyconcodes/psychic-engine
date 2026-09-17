<x-layouts::app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">
            {{ __('Plans & Upgrade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="font-display text-4xl md:text-5xl font-bold text-text dark:text-text mb-4">
                    Choose Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Voice Journey</span>
                </h1>
                <p class="text-lg text-text/70 dark:text-text/70 max-w-2xl mx-auto">
                    Unlock premium earning features with our lifetime packages. Pay once, earn forever.
                </p>
            </div>

            {{-- Current Plan Badge --}}
            @if($currentPlan)
                <div class="mb-8 p-4 bg-primary/5 dark:bg-primary/10 border border-primary/20 dark:border-primary/30 rounded-2xl">
                    <div class="flex items-center justify-center gap-3">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-primary to-secondary text-white font-semibold shadow-lg shadow-primary/25">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ $currentPlan->name }}
                        </span>
                        <span class="text-text/60 dark:text-text/60">Active Plan</span>
                    </div>
                </div>
            @endif

            {{-- Plan Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($plans as $plan)
                    <div class="relative group">
                        {{-- Popular Badge --}}
                        @if($plan->is_popular)
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                <span class="inline-flex items-center px-4 py-1 rounded-full bg-gradient-to-r from-primary to-secondary text-white text-sm font-semibold shadow-lg shadow-primary/30">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                    </svg>
                                    Most Popular
                                </span>
                            </div>
                        @endif

                        <div class="h-full bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-3xl shadow-xl shadow-black/5 dark:shadow-black/20 overflow-hidden border border-gray-100 dark:border-gray-700/50 transition-all duration-300 group-hover:shadow-2xl group-hover:shadow-primary/10 dark:group-hover:shadow-primary/20 group-hover:-translate-y-2">
                            {{-- Gradient Header --}}
                            <div class="relative h-32 bg-gradient-to-br {{ $plan->is_popular ? 'from-primary via-primary to-secondary' : 'from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-700/50' }} flex items-center justify-center overflow-hidden">
                                {{-- Decorative circles --}}
                                <div class="absolute -top-8 -right-8 w-32 h-32 {{ $plan->is_popular ? 'bg-white/10' : 'bg-primary/5 dark:bg-primary/10' }} rounded-full"></div>
                                <div class="absolute -bottom-12 -left-12 w-40 h-40 {{ $plan->is_popular ? 'bg-white/5' : 'bg-secondary/5 dark:bg-secondary/10' }} rounded-full"></div>
                                
                                {{-- Microphone Icon --}}
                                <div class="relative z-10">
                                    <div class="w-20 h-20 {{ $plan->is_popular ? 'bg-white/20' : 'bg-primary/10 dark:bg-primary/20' }} rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-10 h-10 {{ $plan->is_popular ? 'text-white' : 'text-primary dark:text-primary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                {{-- Plan Name --}}
                                <h3 class="font-display text-2xl font-bold text-text dark:text-text text-center mb-2">
                                    {{ $plan->name }}
                                </h3>

                                {{-- Price --}}
                                <div class="text-center mb-6">
                                    <div class="flex items-baseline justify-center gap-1">
                                        <span class="text-text/40 dark:text-text/40 text-lg">₦</span>
                                        <span class="font-display text-4xl font-bold {{ $plan->is_popular ? 'text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary' : 'text-text dark:text-text' }}">
                                            {{ number_format($plan->price) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-text/50 dark:text-text/50">One-time payment</span>
                                </div>

                                {{-- Earnings --}}
                                <div class="mb-6 p-4 rounded-2xl {{ $plan->is_popular ? 'bg-primary/5 dark:bg-primary/10' : 'bg-gray-50 dark:bg-gray-800' }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-text/60 dark:text-text/60">Voice Earn</span>
                                        <span class="font-bold {{ $plan->is_popular ? 'text-primary' : 'text-secondary dark:text-secondary' }}">₦{{ number_format($plan->voice_earn_per_session) }}/session</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-text/60 dark:text-text/60">Word Game</span>
                                        <span class="font-bold {{ $plan->is_popular ? 'text-primary' : 'text-secondary dark:text-secondary' }}">₦{{ number_format($plan->word_game_per_word) }}/word</span>
                                    </div>
                                </div>

                                {{-- Features --}}
                                <ul class="space-y-3 mb-8">
                                    @foreach($plan->features as $feature)
                                        <li class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-5 h-5 rounded-full {{ $plan->is_popular ? 'bg-primary/10 dark:bg-primary/20' : 'bg-secondary/10 dark:bg-secondary/20' }} flex items-center justify-center mt-0.5">
                                                <svg class="w-3 h-3 {{ $plan->is_popular ? 'text-primary' : 'text-secondary' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm text-text/70 dark:text-text/70">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- CTA Button --}}
                                @if($currentPlan && $currentPlan->id === $plan->id)
                                    <button disabled class="w-full py-3 px-4 rounded-xl bg-gray-200 dark:bg-gray-700 text-text/50 dark:text-text/50 font-semibold cursor-not-allowed">
                                        Current Plan
                                    </button>
                                @elseif($currentPlan && $currentPlan->id !== $plan->id)
                                    <button disabled class="w-full py-3 px-4 rounded-xl bg-gray-200 dark:bg-gray-700 text-text/50 dark:text-text/50 font-semibold cursor-not-allowed">
                                        Active Plan
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('plans.subscribe', $plan) }}">
                                        @csrf
                                        <button type="submit" class="w-full py-3 px-4 rounded-xl {{ $plan->is_popular ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30' : 'bg-text dark:bg-white text-white dark:text-text hover:bg-text/90 dark:hover:bg-white/90' }} font-semibold transition-all duration-300 transform hover:scale-[1.02]">
                                            Deposit ₦{{ number_format($plan->price) }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Info Section --}}
            <div class="mt-12 text-center">
                <div class="inline-flex items-center gap-2 px-6 py-3 bg-primary/5 dark:bg-primary/10 rounded-full">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-text/70 dark:text-text/70">All plans are lifetime access. Pay once, use forever.</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
