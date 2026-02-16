{{-- Sticky Navbar with blur on scroll --}}
<nav x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'bg-white/95 backdrop-blur-xl shadow-lg shadow-slate-900/5 border-b border-slate-100' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="container-custom">
        <div class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                    class="w-16 h-16 rounded-xl shadow-lg group-hover:scale-105 transition-transform bg-white object-contain p-1">
                <div class="hidden sm:block">
                    <span class="font-display font-bold text-xl text-slate-900 block leading-tight">Talent Zone</span>
                    <span class="text-xs text-slate-500">Academy</span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-orange-coral hover:bg-orange-50 rounded-lg transition-all duration-200">
                    Home
                </a>

                {{-- Schools Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center px-4 py-2 text-sm font-medium text-slate-700 hover:bg-orange-50 rounded-lg transition-all duration-200">
                        Schools
                        <svg class="ml-1.5 w-4 h-4 transition-transform duration-200" :class="open && 'rotate-180'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute left-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">

                        <div class="p-2">
                            <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Our
                                Campuses</div>
                            @foreach(config('schools.schools') as $school)
                                @php
                                    $colorDot = match ($school['color']) {
                                        'primary' => 'bg-primary-500',
                                        'accent' => 'bg-accent-500',
                                        'warm' => 'bg-warm-500',
                                        default => 'bg-primary-500',
                                    };
                                @endphp
                                <a href="{{ route('schools.show', $school['slug']) }}"
                                    class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-slate-50 transition-colors group">
                                    <div
                                        class="w-10 h-10 rounded-lg {{ $colorDot }}/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <div class="w-2.5 h-2.5 rounded-full {{ $colorDot }}"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span
                                            class="block text-sm font-semibold text-slate-900 group-hover:text-orange-coral transition-colors">
                                            {{ Str::after($school['name'], 'TalentZone Academy ') }}
                                        </span>
                                        <span class="block text-xs text-slate-500 truncate">{{ $school['tagline'] }}</span>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-orange-coral group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-100 p-2">
                            <a href="{{ route('schools') }}"
                                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-orange-50 text-sm font-semibold text-orange-coral hover:bg-orange-100 transition-colors">
                                <span>View All Schools</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('gallery') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-orange-coral hover:bg-orange-50 rounded-lg transition-all duration-200">
                    Gallery
                </a>
                <a href="{{ route('staff') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-orange-coral hover:bg-orange-50 rounded-lg transition-all duration-200">
                    Staff
                </a>
                <a href="{{ route('contact') }}"
                    class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-orange-coral hover:bg-orange-50 rounded-lg transition-all duration-200">
                    Contact
                </a>
            </div>

            {{-- CTA Button --}}
            <div class="hidden lg:block">
                <a href="{{ route('contact') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Enquire Now
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="open = !open" class="lg:hidden p-2.5 rounded-xl hover:bg-slate-100 transition-colors">
                <svg x-show="!open" class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu Backdrop --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
        @click="open = false">
    </div>

    {{-- Mobile Menu Slide-over --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-white shadow-2xl z-50 lg:hidden overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                        class="w-14 h-14 rounded-xl bg-white object-contain p-1 shadow-sm">
                    <span class="font-display font-bold text-lg">Menu</span>
                </div>
                <button @click="open = false" class="p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-coral font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Home
                </a>

                <div class="px-4 py-3">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Our Schools</span>
                </div>

                @foreach(config('schools.schools') as $school)
                    @php
                        $colorDot = match ($school['color']) {
                            'primary' => 'bg-primary-500',
                            'accent' => 'bg-accent-500',
                            'warm' => 'bg-warm-500',
                            default => 'bg-primary-500',
                        };
                    @endphp
                    <a href="{{ route('schools.show', $school['slug']) }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
                        <div class="w-2 h-2 rounded-full {{ $colorDot }}"></div>
                        {{ Str::after($school['name'], 'TalentZone Academy ') }}
                    </a>
                @endforeach

                <a href="{{ route('schools') }}"
                    class="flex items-center gap-3 px-4 py-3 ml-4 rounded-xl text-orange-coral font-medium hover:bg-orange-50 transition-colors">
                    View All Schools →
                </a>

                <div class="my-4 border-t border-slate-100"></div>

                <a href="{{ route('gallery') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-coral font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Gallery
                </a>
                <a href="{{ route('staff') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-coral font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Staff
                </a>
                <a href="{{ route('contact') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-orange-50 hover:text-orange-coral font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact
                </a>
            </nav>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('contact') }}" class="btn-primary w-full text-center py-4">
                    Enquire Now
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer for fixed navbar --}}
<div class="h-20"></div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>