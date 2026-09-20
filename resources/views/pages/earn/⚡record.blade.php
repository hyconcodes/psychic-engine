<?php

use App\Actions\CompleteEarning;
use App\Models\EarningPrompt;
use App\Models\EarningSubmission;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

new #[Title('Earn')] class extends Component {
    use WithFileUploads;

    public string $type = 'sentence';

    public array $languages = [];

    public string $language = '';

    public ?int $promptId = null;

    public string $promptText = '';

    public array $promptWords = [];

    public $audio = null;

    public int $duration = 0;

    public bool $celebrating = false;

    public string $earnedAmount = '';

    public function mount(?string $type = null): void
    {
        $this->type = $type ?? 'sentence';
        $this->languages = config('earning.languages', []);
    }

    public function selectLanguage(): void
    {
        $this->resetRecording();
        $this->loadPrompt();
    }

    public function loadPrompt(): void
    {
        $this->promptId = null;
        $this->promptText = '';
        $this->promptWords = [];

        if ($this->language === '') {
            return;
        }

        $user = Auth::user();

        $submittedIds = EarningSubmission::where('user_id', $user->id)
            ->where('type', $this->type)
            ->where('created_at', '>=', now()->startOfDay())
            ->pluck('prompt_id');

        $prompt = EarningPrompt::active()
            ->where('type', $this->type)
            ->where('language', $this->language)
            ->when($submittedIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $submittedIds))
            ->inRandomOrder()
            ->first();

        $this->promptId = $prompt?->id;
        $this->promptText = $prompt?->text ?? '';
        $this->promptWords = $prompt ? preg_split('/\s+/', $prompt->text) : [];
    }

    public function submit(CompleteEarning $complete): void
    {
        $this->validate([
            'audio' => 'required|file|max:20480',
            'promptId' => 'required|integer',
        ]);

        $user = Auth::user();

        try {
            $path = $this->audio->store(
                config('earning.audio_path').'/'.$user->id,
                config('earning.disk'),
            );

            $submission = $complete->handle(
                $user,
                $this->type,
                EarningPrompt::findOrFail($this->promptId),
                $path,
                $this->duration ?: null,
            );
        } catch (RuntimeException $e) {
            Flux::toast(variant: 'error', text: $e->getMessage());

            return;
        }

        $this->earnedAmount = '₦'.number_format((float) $submission->amount, 2);
        $this->celebrating = true;
    }

    public function continue(): void
    {
        $this->celebrating = false;
        $this->earnedAmount = '';
        $this->resetRecording();
        $this->loadPrompt();
    }

    public function resetRecording(): void
    {
        $this->audio = null;
        $this->duration = 0;
    }

    public function title(): string
    {
        return $this->type === 'sentence' ? __('Voice Earn') : __('Word Game');
    }

    public function rateLabel(): string
    {
        $plan = Auth::user()->currentPlan();

        if (! $plan) {
            return '—';
        }

        return $this->type === 'sentence'
            ? '₦'.number_format((float) $plan->voice_earn_per_session).' / session'
            : '₦'.number_format((float) $plan->word_game_per_word).' / word';
    }
}; ?>

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('earn.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
            <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ $this->title() }}</h2>
            <p class="text-xs text-text/50">{{ $this->rateLabel() }} &middot; earn by reading aloud</p>
        </div>
    </div>

    @if (! Auth::user()->hasActivePlan())
        <a href="{{ route('plans.index') }}" class="flex items-center gap-4 bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-2xl p-4 hover:bg-primary/10 transition-colors group">
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-text">Activate a plan to start earning</p>
                <p class="text-xs text-text/40">You need an active plan to complete earning tasks</p>
            </div>
            <svg class="w-5 h-5 text-text/30 group-hover:text-primary transition-colors shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        </a>
    @else
        {{-- Language selector --}}
        <div>
            <label for="earn-language" class="block text-sm font-medium text-text mb-1.5">{{ __('Choose your language') }}</label>
            <select
                wire:model="language"
                wire:change="selectLanguage"
                id="earn-language"
                class="w-full sm:w-64 rounded-xl border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-4 py-2.5 text-sm text-text focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
            >
                <option value="">{{ __('Select your language') }}</option>
                @foreach ($languages as $code => $label)
                    <option value="{{ $code }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Prompt card --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-gray-100 dark:border-neutral-800 p-6 shadow-sm">
            @if ($language === '')
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"/></svg>
                    </div>
                    <p class="text-sm font-medium text-text/60">{{ __('Select your language to see your task') }}</p>
                </div>
            @else
                <div wire:loading wire:target="selectLanguage" class="flex flex-col items-center justify-center py-12">
                    <x-spinner class="w-12 h-12" />
                    <p class="text-sm text-text/50 mt-4">{{ __('Loading your task…') }}</p>
                </div>

                <div wire:loading.remove wire:target="selectLanguage">
                    @if ($promptId)
                        <div>
                            <p class="text-xs text-text/40 uppercase tracking-wider mb-3">
                                {{ $type === 'sentence' ? __('Read this sentence aloud') : __('Read this word aloud') }}
                            </p>

                            <div
                                x-data="{
                                    recording: false,
                                    recorded: false,
                                    seconds: 0,
                                    activeWord: 0,
                                    timer: null,
                                    recorder: null,
                                    chunks: [],
                                    stream: null,
                                    words: @js($promptWords),

                                    toggle() { this.recording ? this.stop() : this.start(); },

                                    async start() {
                                        try {
                                            this.stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                                        } catch (e) {
                                            alert('Microphone access is required to record.');
                                            return;
                                        }
                                        this.chunks = [];
                                        this.recorder = new MediaRecorder(this.stream);
                                        this.recorder.ondataavailable = (e) => { if (e.data.size > 0) this.chunks.push(e.data); };
                                        this.recorder.onstop = () => {
                                            this.stream.getTracks().forEach((t) => t.stop());
                                            const mime = this.recorder.mimeType || 'audio/webm';
                                            const ext = mime.includes('ogg') ? 'ogg' : 'webm';
                                            const blob = new Blob(this.chunks, { type: mime });
                                            const file = new File([blob], 'recording.' + ext, { type: mime });
                                            this.$wire.set('duration', Math.round(this.seconds));
                                            this.$wire.upload('audio', file, () => { this.recorded = true; }, () => { alert('Upload failed. Please try again.'); });
                                            this.stopTimer();
                                        };
                                        this.recorder.start();
                                        this.recording = true;
                                        this.recorded = false;
                                        this.seconds = 0;
                                        this.activeWord = 0;
                                        this.startTimer();
                                    },

                                    stop() {
                                        if (this.recorder && this.recorder.state !== 'inactive') this.recorder.stop();
                                        this.recording = false;
                                    },

                                    startTimer() {
                                        this.timer = setInterval(() => {
                                            this.seconds++;
                                            if (this.words.length > 0) {
                                                this.activeWord = Math.min(Math.floor(this.seconds / 1.5), this.words.length - 1);
                                            }
                                        }, 1000);
                                    },

                                    stopTimer() {
                                        if (this.timer) clearInterval(this.timer);
                                        this.timer = null;
                                    },

                                    formatTime(s) {
                                        const m = String(Math.floor(s / 60)).padStart(2, '0');
                                        const sec = String(s % 60).padStart(2, '0');
                                        return m + ':' + sec;
                                    },

                                    replayPreview() {
                                        const mime = this.recorder ? this.recorder.mimeType : 'audio/webm';
                                        const ext = mime && mime.includes('ogg') ? 'ogg' : 'webm';
                                        const blob = new Blob(this.chunks, { type: mime || 'audio/webm' });
                                        const url = URL.createObjectURL(blob);
                                        this.$refs.preview.src = url;
                                        this.$refs.preview.play();
                                    },

                                    resetAudio() {
                                        this.recorded = false;
                                        this.seconds = 0;
                                        this.activeWord = 0;
                                        this.chunks = [];
                                        this.$wire.set('duration', 0);
                                        this.$wire.set('audio', null);
                                    },
                                }"
                                class="space-y-6"
                            >
                                {{-- Prompt text with word-by-word highlight --}}
                                <div class="flex flex-wrap gap-x-2 gap-y-1.5">
                                    <template x-for="(word, i) in words" :key="i">
                                        <span
                                            class="rounded-md px-2 py-1 text-lg font-semibold transition-colors duration-200"
                                            style="font-family: 'DM Serif Display', Georgia, serif;"
                                            :class="recording && i === activeWord ? 'bg-primary text-white' : 'text-text'"
                                            x-text="word"
                                        ></span>
                                    </template>
                                </div>

                                {{-- Recording controls --}}
                                <div class="flex flex-col items-center gap-3">
                                    <button
                                        type="button"
                                        @click="toggle()"
                                        class="w-20 h-20 rounded-full flex items-center justify-center transition-all duration-200"
                                        :class="recording ? 'bg-red-500 shadow-lg shadow-red-500/30 scale-105' : 'bg-gradient-to-br from-primary to-secondary shadow-lg shadow-primary/30'"
                                    >
                                        <template x-if="!recording">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14a3 3 0 003-3V6a3 3 0 10-6 0v5a3 3 0 003 3zm5-3a1 1 0 10-2 0v1a3 3 0 01-6 0v-1a1 1 0 10-2 0v1a5 5 0 004 4.9V19H9a1 1 0 100 2h6a1 1 0 100-2h-2v-2.1a5 5 0 004-4.9v-1z"/></svg>
                                        </template>
                                        <template x-if="recording">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6h12v12H6z"/></svg>
                                        </template>
                                    </button>

                                    <p class="text-sm font-medium text-text/60" x-text="recording ? 'Recording… ' + formatTime(seconds) : (recorded ? 'Recording ready' : 'Tap to record')"></p>

                                    <template x-if="!recording && recorded">
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="replayPreview()" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                                                {{ __('Replay') }}
                                            </button>
                                            <button type="button" @click="resetAudio()" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium text-text/70 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer">
                                                {{ __('Re-record') }}
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <audio x-ref="preview" class="hidden"></audio>

                                <div class="pt-2">
                                    <button
                                        type="button"
                                        wire:click="submit"
                                        :disabled="!recorded"
                                        class="w-full py-3.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2"
                                        :class="recorded ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-lg shadow-primary/20 cursor-pointer hover:from-primary/90 hover:to-secondary/90' : 'bg-gray-100 dark:bg-neutral-800 text-text/40 cursor-not-allowed'"
                                    >
                                        <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ __('Submit & earn') }}
                                        </span>
                                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                            <x-spinner class="w-5 h-5" />
                                            {{ __('Submitting…') }}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-sm text-text/40">{{ __('No prompts available for this language yet. Try another language.') }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{-- Congratulations overlay --}}
    @if ($celebrating)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            <div class="relative bg-white dark:bg-neutral-900 rounded-3xl p-8 text-center shadow-2xl max-w-sm w-full overflow-visible">
                {{-- Confetti dots --}}
                <div class="absolute -top-2 left-10 w-3 h-3 rounded-full bg-primary animate-bounce"></div>
                <div class="absolute -top-3 right-12 w-2.5 h-2.5 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.15s"></div>
                <div class="absolute top-6 -left-2 w-2 h-2 rounded-full bg-amber-400 animate-bounce" style="animation-delay: 0.3s"></div>
                <div class="absolute top-10 -right-2 w-2.5 h-2.5 rounded-full bg-green-500 animate-bounce" style="animation-delay: 0.45s"></div>
                <div class="absolute -bottom-2 left-16 w-2 h-2 rounded-full bg-pink-500 animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="absolute -bottom-3 right-14 w-3 h-3 rounded-full bg-blue-500 animate-bounce" style="animation-delay: 0.35s"></div>

                {{-- Trophy --}}
                <div class="relative inline-flex mb-5">
                    <div class="absolute -inset-1.5 bg-gradient-to-br from-primary to-blue-500 rounded-full blur-md opacity-60"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-primary to-blue-500 rounded-full flex items-center justify-center shadow-xl ring-4 ring-white dark:ring-neutral-900">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"/></svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-text mb-1" style="font-family: 'DM Serif Display', Georgia, serif;">{{ __('Congratulations!') }}</h3>
                <p class="text-sm text-text/50 mb-4">{{ __('You just earned') }}</p>
                <p class="text-3xl font-bold bg-gradient-to-r from-primary to-blue-500 bg-clip-text text-transparent mb-6" style="font-family: 'DM Serif Display', Georgia, serif;">{{ $earnedAmount }}</p>

                <button
                    type="button"
                    wire:click="continue"
                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-semibold text-sm transition-all shadow-lg shadow-primary/20 cursor-pointer"
                >
                    {{ __('Continue earning') }}
                </button>
            </div>
        </div>
    @endif
</div>
