@props(['class' => 'w-12 h-12'])
@php
    $gradientId = 'spinner-'.uniqid();
@endphp
<svg {{ $attributes->merge(['class' => 'animate-spin '.$class]) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
    <defs>
        <linearGradient id="{{ $gradientId }}" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#FF5722" />
            <stop offset="100%" stop-color="#3B82F6" />
        </linearGradient>
    </defs>
    <circle cx="12" cy="12" r="10" stroke="#3B82F6" stroke-opacity="0.2" stroke-width="4" />
    <path d="M12 2a10 10 0 0 1 10 10" stroke="url(#{{ $gradientId }})" stroke-width="4" stroke-linecap="round" />
</svg>
