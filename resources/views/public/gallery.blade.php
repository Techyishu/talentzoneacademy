<x-public-layout>
    {{-- Page Header --}}
    <section class="relative py-24 overflow-hidden" style="background: linear-gradient(135deg, #003B71 0%, #0066CC 50%, #003B71 100%);">
        {{-- Decorative Doodles --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
            {{-- Camera Icons --}}
            <svg class="absolute top-10 left-10 w-16 h-16" viewBox="0 0 100 100" fill="white">
                <rect x="20" y="30" width="60" height="45" rx="8"/>
                <circle cx="50" cy="52" r="12"/>
            </svg>

            {{-- Stars --}}
            <svg class="absolute bottom-20 right-20 w-12 h-12" viewBox="0 0 100 100" fill="white">
                <path d="M50 10 L61 39 L92 39 L67 57 L78 86 L50 68 L22 86 L33 57 L8 39 L39 39 Z"/>
            </svg>

            {{-- Circles --}}
            <div class="absolute top-1/3 right-1/4 w-20 h-20 rounded-full border-4 border-white"></div>
            <div class="absolute bottom-1/4 left-1/4 w-16 h-16 rounded-full border-4 border-white"></div>
        </div>

        <div class="container-custom relative z-10 text-center text-white">
            <div class="inline-block px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <span class="text-sm font-bold">📸 Campus Life</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl mb-4">Gallery</h1>
            <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto">
                Explore moments of learning, creativity, and achievement across our three campuses.
            </p>
        </div>
    </section>

    {{-- Gallery Filter --}}
    <section class="section-padding bg-white" x-data="{ activeCategory: 'all' }">
        <div class="container-custom">
            {{-- Category Filters --}}
            <div class="flex flex-wrap justify-center gap-3 mb-16">
                @foreach(['all' => 'All', 'academics' => 'Academics', 'sports' => 'Sports', 'events' => 'Events', 'campus' => 'Campus', 'arts' => 'Arts'] as $key => $label)
                    <button @click="activeCategory = '{{ $key }}'"
                        :class="activeCategory === '{{ $key }}' ? 'text-white shadow-xl' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        :style="activeCategory === '{{ $key }}' ? 'background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%);' : ''"
                        class="px-6 py-3 rounded-xl font-medium text-sm transition-all duration-300">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Gallery Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @php
                    $categories = ['academics', 'sports', 'events', 'campus', 'arts'];
                    $galleryItems = [];
                    for ($i = 1; $i <= 16; $i++) {
                        $galleryItems[] = [
                            'category' => $categories[($i - 1) % count($categories)],
                            'title' => 'Gallery Item ' . $i,
                        ];
                    }
                @endphp

                @foreach($galleryItems as $index => $item)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $item['category'] }}'"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer {{ $index % 5 === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                        {{-- Placeholder Background --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        {{-- Hover Overlay --}}
                        <div
                            class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                            style="background: linear-gradient(to top, rgba(227, 30, 36, 0.9) 0%, rgba(227, 30, 36, 0.5) 50%, transparent 100%);">
                        </div>

                        {{-- Content --}}
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-medium mb-2" style="color: #E31E24;">
                                {{ ucfirst($item['category']) }}
                            </span>
                            <h3 class="text-white font-semibold">{{ $item['title'] }}</h3>
                        </div>

                        {{-- Zoom Icon --}}
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-14 h-14 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 scale-50 group-hover:scale-100 transition-all duration-300">
                            <svg class="w-6 h-6" style="color: #E31E24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Load More --}}
            <div class="text-center mt-16">
                <button class="btn-secondary px-12 py-4">
                    Load More
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <x-public.cta-band title="Want to Visit Our Campuses?"
        subtitle="Experience the vibrant atmosphere of Talent Zone Academy firsthand."
        primaryText="Schedule a Tour"
        primaryUrl="{{ route('contact') }}"
        variant="blue" />
</x-public-layout>
