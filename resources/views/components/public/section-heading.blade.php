{{-- Section Heading Component --}}
@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
    'light' => false,
    'centered' => true,
])

<div class="{{ $centered ? 'text-center' : '' }} mb-16">
    @if($eyebrow)
        <span class="badge {{ $light ? 'badge-glass' : 'badge-primary' }} mb-4">
            {{ $eyebrow }}
        </span>
    @endif
    
    <h2 class="font-display font-bold text-3xl md:text-4xl lg:text-5xl {{ $light ? 'text-white' : 'text-slate-900' }} mb-4">
        {{ $title }}
    </h2>
    
    <div class="section-divider mb-6"></div>
    
    @if($subtitle)
        <p class="text-lg {{ $light ? 'text-slate-300' : 'text-slate-600' }} max-w-3xl {{ $centered ? 'mx-auto' : '' }} leading-relaxed">
            {{ $subtitle }}
        </p>
    @endif
</div>
