@props(['title' => '', 'icon' => null, 'headerColor' => 'primary'])

<div class="card-premium overflow-hidden rounded-xl border border-slate-200 shadow-sm">
    @if($title || $icon)
        <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-{{ $headerColor }}-50 to-white">
            <div class="flex items-center space-x-3">
                @if($icon)
                    <div class="rounded-lg bg-{{ $headerColor }}-100 p-2">
                        {!! $icon !!}
                    </div>
                @endif
                <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
            </div>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
