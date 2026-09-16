@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'Laravel')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-primary text-button-text">
            <x-app-logo-icon class="size-5 fill-current text-button-text" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'Laravel')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-primary text-button-text">
            <x-app-logo-icon class="size-5 fill-current text-button-text" />
        </x-slot>
    </flux:brand>
@endif
