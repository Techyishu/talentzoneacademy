{{-- Playful School Card Component --}}
@props([
    'school',
    'index' => 0,
])

@php
    // Assign vibrant solid colors based on Talent Zone Academy logo colors
    $colorMap = [
        'primary' => ['gradient' => 'linear-gradient(135deg, #E31E24 0%, #FF4444 100%)', 'icon' => '#ADD8E6'],
        'accent' => ['gradient' => 'linear-gradient(135deg, #003B71 0%, #0066CC 100%)', 'icon' => '#87CEEB'],
        'warm' => ['gradient' => 'linear-gradient(135deg, #87CEEB 0%, #ADD8E6 100%)', 'icon' => '#E31E24'],
    ];
    $colors = $colorMap[$school['color']] ?? $colorMap['primary'];
@endphp

<a href="{{ route('schools.show', $school['slug']) }}"
   class="group block rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1"
   style="background: {{ $colors['gradient'] }};">

    <div class="relative p-8 min-h-[420px] flex flex-col">
        {{-- Geometric Doodles --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
            {{-- Top Right Circle --}}
            <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full border-4 border-white"></div>

            {{-- Bottom Left Triangle --}}
            <svg class="absolute bottom-4 left-4 w-16 h-16" viewBox="0 0 100 100" fill="white">
                <polygon points="50,10 90,90 10,90"/>
            </svg>

            {{-- Middle Squiggle --}}
            <svg class="absolute top-1/2 left-1/3 w-20 h-20" viewBox="0 0 100 100" fill="none">
                <path d="M10 50 Q30 30 50 50 T90 50" stroke="white" stroke-width="4" stroke-linecap="round"/>
            </svg>
        </div>

        {{-- Content --}}
        <div class="relative z-10 flex-1 flex flex-col">
            {{-- Badge --}}
            <div class="mb-6">
                <span class="inline-block px-4 py-2 bg-white/90 backdrop-blur-sm rounded-full text-sm font-bold" style="color: {{ $colors['icon'] == '#ADD8E6' || $colors['icon'] == '#87CEEB' ? '#003B71' : '#E31E24' }};">
                    Est. {{ $school['established'] }}
                </span>
            </div>

            {{-- Icon Placeholder (Student Silhouette) --}}
            <div class="mb-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background-color: {{ $colors['icon'] }};">
                    <svg class="w-10 h-10" style="color: {{ $colors['icon'] == '#E31E24' ? 'white' : '#003B71' }};" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            {{-- School Name & Tagline --}}
            <div class="flex-1">
                <h3 class="font-display font-bold text-3xl text-white mb-3 leading-tight">
                    {{ $school['name'] }}
                </h3>
                <p class="text-white/90 text-base mb-6">{{ $school['tagline'] }}</p>
            </div>

            {{-- Stats --}}
            <div class="flex items-center gap-6 mb-6 text-white/90">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ $school['students'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ $school['teachers'] }} Teachers</span>
                </div>
            </div>

            {{-- CTA --}}
            <div class="flex items-center text-white font-semibold text-base group-hover:gap-3 transition-all duration-300 gap-2">
                Learn More
                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </div>
        </div>
    </div>
</a>
