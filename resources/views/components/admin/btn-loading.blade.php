@props([
    'type' => 'submit',
    'color' => 'primary',
    'loadingText' => 'Processing...',
])

@php
$colors = [
    'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-700',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
];
$colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<button
    type="{{ $type }}"
    x-data="{ loading: false }"
    x-on:click="loading = true"
    x-bind:disabled="loading"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-6 py-2 {$colorClass} font-medium rounded-lg transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed"]) }}
>
    <span x-show="!loading">{{ $slot }}</span>
    <span x-show="loading" class="flex items-center">
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        {{ $loadingText }}
    </span>
</button>
