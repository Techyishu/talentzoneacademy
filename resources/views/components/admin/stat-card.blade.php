@props(['title' => '', 'value' => 0, 'icon' => null, 'color' => 'primary', 'trend' => null, 'trendUp' => true])

@php
    $colorClasses = [
        'primary' => 'bg-primary-100 text-primary-600',
        'accent' => 'bg-accent-100 text-accent-600',
        'warm' => 'bg-warm-100 text-warm-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'blue' => 'bg-blue-100 text-blue-600',
    ];

    $iconBgClass = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="card-premium p-6 hover:shadow-xl transition-shadow duration-300">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-600 uppercase tracking-wide">{{ $title }}</p>
            <div class="mt-2 flex items-baseline space-x-2">
                <p class="text-3xl font-bold text-slate-900">{{ $value }}</p>
                @if($trend)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $trendUp ? 'bg-accent-100 text-accent-800' : 'bg-red-100 text-red-800' }}">
                        @if($trendUp)
                            <svg class="h-3 w-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="h-3 w-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ $trend }}
                    </span>
                @endif
            </div>
        </div>
        @if($icon)
            <div class="rounded-xl {{ $iconBgClass }} p-3 ml-4">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
