<?php

use App\Models\AffiliateCommission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Affiliate Earners')] class extends Component {
    public array $topThree = [];

    public array $barChart = [];

    public array $others = [];

    public function mount(): void
    {
        $totals = AffiliateCommission::selectRaw('referrer_id, SUM(amount) as total')
            ->groupBy('referrer_id')
            ->orderByDesc('total')
            ->get();

        $users = User::whereIn('id', $totals->pluck('referrer_id'))->get()->keyBy('id');

        $ranked = $totals
            ->map(function ($t) use ($users) {
                $user = $users->get($t->referrer_id);

                if (! $user) {
                    return null;
                }

                return [
                    'username' => $user->username,
                    'initials' => $user->initials(),
                    'total' => (float) $t->total,
                ];
            })
            ->filter()
            ->values();

        $this->topThree = $ranked->take(3)->values()->toArray();

        $this->others = $ranked->slice(3)->take(15)->values()->toArray();

        $this->buildBarChart();
    }

    private function buildBarChart(): void
    {
        $top = $this->topThree;

        if (empty($top)) {
            $this->barChart = [];

            return;
        }

        $max = $top[0]['total'] > 0 ? $top[0]['total'] : 1;

        $order = [1, 0, 2]; // second, first (highest), third

        $this->barChart = collect($order)
            ->map(function ($index) use ($top, $max) {
                if (! isset($top[$index])) {
                    return null;
                }

                $height = round(($top[$index]['total'] / $max) * 100);

                return [
                    'username' => $top[$index]['username'],
                    'initials' => $top[$index]['initials'],
                    'total' => $top[$index]['total'],
                    'height' => max($height, 20),
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
}; ?>

<div class="space-y-5">
    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors">
            <svg class="w-4 h-4 text-text/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h2 class="font-semibold text-xl text-text dark:text-text leading-tight">{{ __('Affiliate Earners') }}</h2>
            <p class="text-xs text-text/50">{{ __('Top affiliate earners on VocalPay') }}</p>
        </div>
        <x-refresh-button class="ml-auto" />
    </div>

    @if (empty($topThree))
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-10 text-center">
            <p class="text-sm text-text/40">{{ __('No affiliate earnings yet.') }}</p>
        </div>
    @else
        {{-- Top 3 --}}
        <div class="grid grid-cols-3 gap-2.5">
            @foreach ($topThree as $earner)
                <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-4 text-center shadow-sm">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold mx-auto mb-2">
                        {{ $earner['initials'] }}
                    </div>
                    <p class="text-xs font-semibold text-text truncate">{{ '@'.$earner['username'] }}</p>
                    <p class="text-[11px] text-green-600 font-semibold mt-0.5">₦{{ number_format($earner['total'], 0) }}</p>
                </div>
            @endforeach
        </div>

        {{-- 3-bar chart --}}
        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-5 shadow-sm">
            <h3 class="text-xs font-semibold text-text mb-4 text-center">{{ __('Top earners') }}</h3>
            <div class="flex items-end justify-center gap-4 h-44">
                @foreach ($barChart as $bar)
                    <div class="flex flex-col items-center gap-1.5 flex-1 max-w-[80px]">
                        <span class="text-[11px] font-bold text-green-600">₦{{ number_format($bar['total'], 0) }}</span>
                        <div class="w-full bg-gradient-to-t from-primary to-secondary rounded-t-lg" style="height: {{ $bar['height'] }}%"></div>
                        <span class="text-[10px] font-medium text-text/60 truncate w-full text-center">{{ '@'.$bar['username'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Next 15 --}}
        @if (count($others) > 0)
            <div>
                <h3 class="text-xs font-semibold text-text mb-2.5">{{ __('More earners') }}</h3>
                <div class="space-y-2">
                    @foreach ($others as $index => $earner)
                        <div class="flex items-center gap-3 bg-white dark:bg-neutral-900 rounded-xl border border-gray-100 dark:border-neutral-800 p-3 shadow-sm">
                            <span class="text-[11px] font-bold text-text/30 w-5 shrink-0">{{ $index + 4 }}</span>
                            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary text-[10px] font-bold shrink-0">
                                {{ $earner['initials'] }}
                            </div>
                            <p class="flex-1 text-xs font-semibold text-text truncate">{{ '@'.$earner['username'] }}</p>
                            <p class="text-[11px] font-semibold text-green-600">₦{{ number_format($earner['total'], 0) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
