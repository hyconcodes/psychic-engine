@props(['wire' => false])

<button
    type="button"
    @if($wire) wire:click="$refresh" @else onclick="window.location.reload()" @endif
    title="{{ __('Refresh') }}"
    {{ $attributes->merge(['class' => 'w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 dark:bg-neutral-800 text-text/50 hover:text-primary hover:bg-gray-200 dark:hover:bg-neutral-700 transition-colors cursor-pointer shrink-0']) }}
>
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
</button>
