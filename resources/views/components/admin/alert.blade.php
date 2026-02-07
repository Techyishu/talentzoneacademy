@props(['type' => 'info', 'dismissible' => true])

@php
    $styles = [
        'success' => [
            'container' => 'bg-accent-50 border-accent-500',
            'icon' => 'text-accent-600',
            'text' => 'text-accent-800',
            'button' => 'text-accent-600 hover:text-accent-800',
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ],
        'error' => [
            'container' => 'bg-red-50 border-red-500',
            'icon' => 'text-red-600',
            'text' => 'text-red-800',
            'button' => 'text-red-600 hover:text-red-800',
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ],
        'warning' => [
            'container' => 'bg-warm-50 border-warm-500',
            'icon' => 'text-warm-600',
            'text' => 'text-warm-800',
            'button' => 'text-warm-600 hover:text-warm-800',
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
        ],
        'info' => [
            'container' => 'bg-primary-50 border-primary-500',
            'icon' => 'text-primary-600',
            'text' => 'text-primary-800',
            'button' => 'text-primary-600 hover:text-primary-800',
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ]
    ];

    $config = $styles[$type] ?? $styles['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="rounded-xl border-l-4 p-4 shadow-sm {{ $config['container'] }}"
    role="alert"
>
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 {{ $config['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $config['path'] !!}
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <div class="text-sm font-medium {{ $config['text'] }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <button
                    @click="show = false"
                    class="-mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 {{ $config['button'] }} transition-colors duration-200"
                >
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>
