<?php

use App\Models\EarningSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Earn')] class extends Component {
    public array $voice = [];

    public array $word = [];

    public bool $hasPlan = false;

    public function mount(): void
    {
        $user = Auth::user();
        $plan = $user->currentPlan();
        $this->hasPlan = (bool) $plan;

        if (! $plan) {
            return;
        }

        $this->voice = $this->summary($user, 'sentence', (int) $plan->daily_voice_tasks, (float) $plan->voice_earn_per_session);
        $this->word = $this->summary($user, 'word', (int) $plan->daily_word_tasks, (float) $plan->word_game_per_word);
    }

    private function summary($user, string $type, int $limit, float $rate): array
    {
        $done = EarningSubmission::where('user_id', $user->id)
            ->where('type', $type)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        return [
            'rate' => $rate,
            'limit' => $limit,
            'done' => $done,
            'remaining' => max(0, $limit - $done),
        ];
    }
}; ?>

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
            <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Earn') }}</h2>
            <p class="text-xs text-text/50">{{ __('Your available earning tasks for today') }}</p>
        </div>
        <x-refresh-button class="ml-auto" />
    </div>

    @if (! $hasPlan)
        <a href="{{ route('plans.index') }}" class="flex items-center gap-4 bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-2xl p-4 hover:bg-primary/10 transition-colors group">
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-text">Activate a plan to start earning</p>
                <p class="text-xs text-text/40">Unlock Voice Earn and Word Game with a plan</p>
            </div>
            <svg class="w-5 h-5 text-text/30 group-hover:text-primary transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </a>
    @else
        <div class="grid sm:grid-cols-2 gap-4">
            {{-- Voice Earn --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center shrink-0 shadow-md shadow-primary/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-text leading-tight">{{ __('Voice Earn') }}</h3>
                        <p class="text-xs text-text/50">{{ __('Read sentences aloud') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-semibold text-primary">₦{{ number_format($voice['rate']) }} / session</span>
                    <span class="text-xs text-text/50">{{ $voice['remaining'] }} {{ __('left today') }}</span>
                </div>

                <div class="h-1.5 bg-gray-100 dark:bg-neutral-800 rounded-full overflow-hidden mb-4">
                    @php
                        $voicePct = $voice['limit'] > 0 ? min(100, round(($voice['done'] / $voice['limit']) * 100)) : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-primary to-secondary rounded-full" style="width: {{ $voicePct }}%"></div>
                </div>

                @if ($voice['remaining'] > 0)
                    <a href="{{ route('earn.voice') }}" wire:navigate class="w-full py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary text-white shadow-md shadow-primary/20 hover:from-primary/90 hover:to-secondary/90">
                        {{ __('Start earning') }}
                    </a>
                @else
                    <button type="button" disabled class="w-full py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 bg-gray-100 dark:bg-neutral-800 text-text/40 cursor-not-allowed">
                        {{ __('Done for today') }}
                    </button>
                @endif
            </div>

            {{-- Word Game --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-text leading-tight">{{ __('Word Game') }}</h3>
                        <p class="text-xs text-text/50">{{ __('Read single words aloud') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-semibold text-blue-500">₦{{ number_format($word['rate']) }} / word</span>
                    <span class="text-xs text-text/50">{{ $word['remaining'] }} {{ __('left today') }}</span>
                </div>

                <div class="h-1.5 bg-gray-100 dark:bg-neutral-800 rounded-full overflow-hidden mb-4">
                    @php
                        $wordPct = $word['limit'] > 0 ? min(100, round(($word['done'] / $word['limit']) * 100)) : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full" style="width: {{ $wordPct }}%"></div>
                </div>

                @if ($word['remaining'] > 0)
                    <a href="{{ route('earn.word-game') }}" wire:navigate class="w-full py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md shadow-blue-500/20 hover:from-blue-600 hover:to-cyan-600">
                        {{ __('Start earning') }}
                    </a>
                @else
                    <button type="button" disabled class="w-full py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 bg-gray-100 dark:bg-neutral-800 text-text/40 cursor-not-allowed">
                        {{ __('Done for today') }}
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
