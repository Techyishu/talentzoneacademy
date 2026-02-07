@props(['type' => 'button', 'icon' => null])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105']) }}
>
    @if($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</button>
