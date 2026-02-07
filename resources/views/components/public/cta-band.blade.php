{{-- CTA Band Component --}}
@props([
    'title',
    'subtitle' => null,
    'primaryText' => 'Get Started',
    'primaryUrl' => '#',
    'secondaryText' => null,
    'secondaryUrl' => '#',
    'variant' => 'red', // red, blue
])

@php
    $bgStyle = match($variant) {
        'blue' => 'background: linear-gradient(135deg, #003B71 0%, #0066CC 100%);',
        default => 'background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%);',
    };
    $textColor = 'white';
@endphp

<section class="relative py-20 overflow-hidden" style="{{ $bgStyle }}">
    {{-- Decorative Doodles --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
        {{-- Stars --}}
        <svg class="absolute top-10 left-10 w-12 h-12" viewBox="0 0 100 100" fill="{{ $textColor }}">
            <path d="M50 10 L61 39 L92 39 L67 57 L78 86 L50 68 L22 86 L33 57 L8 39 L39 39 Z"/>
        </svg>
        <svg class="absolute bottom-20 right-20 w-10 h-10" viewBox="0 0 100 100" fill="{{ $textColor }}">
            <path d="M50 10 L61 39 L92 39 L67 57 L78 86 L50 68 L22 86 L33 57 L8 39 L39 39 Z"/>
        </svg>

        {{-- Arrows --}}
        <svg class="absolute top-1/3 right-1/4 w-16 h-16" viewBox="0 0 100 100" fill="none">
            <path d="M20 50 L80 50 M80 50 L60 30 M80 50 L60 70" stroke="{{ $textColor }}" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        {{-- Circles --}}
        <div class="absolute bottom-10 left-1/4 w-20 h-20 rounded-full border-4" style="border-color: {{ $textColor }};"></div>
        <div class="absolute top-20 right-1/3 w-16 h-16 rounded-full border-4" style="border-color: {{ $textColor }};"></div>

        {{-- Zigzag --}}
        <svg class="absolute bottom-1/3 left-10 w-24 h-24" viewBox="0 0 100 100" fill="none">
            <path d="M10 20 L30 40 L10 60 L30 80" stroke="{{ $textColor }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="container-custom relative z-10 text-center">
        <h2 class="font-display font-bold text-3xl md:text-4xl mb-4" style="color: {{ $textColor }};">
            {{ $title }}
        </h2>

        @if($subtitle)
            <p class="text-lg mb-8 max-w-2xl mx-auto text-white/90">
                {{ $subtitle }}
            </p>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ $primaryUrl }}"
               class="inline-flex items-center px-8 py-4 font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1"
               style="background-color: white; color: {{ $variant === 'blue' ? '#003B71' : '#E31E24' }};">
                {{ $primaryText }}
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>

            @if($secondaryText)
                <a href="{{ $secondaryUrl }}"
                   class="inline-flex items-center px-8 py-4 font-semibold border-2 rounded-xl transition-all duration-300 hover:-translate-y-1"
                   style="border-color: {{ $textColor }}; color: {{ $textColor }}; background: transparent;">
                    {{ $secondaryText }}
                </a>
            @endif
        </div>
    </div>
</section>
