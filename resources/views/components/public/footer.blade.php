{{-- Premium Footer --}}
<footer class="relative bg-slate-900 text-white overflow-hidden">
    {{-- Decorative Background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary-500/5 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-500/5 rounded-full filter blur-3xl"></div>
    </div>

    {{-- Newsletter Section --}}
    <div class="relative border-b border-slate-800">
        <div class="container-custom py-12">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="text-center lg:text-left">
                    <h3 class="font-display font-bold text-2xl mb-2">Stay Updated</h3>
                    <p class="text-slate-400">Get the latest news about admissions and events.</p>
                </div>
                <div class="flex flex-col sm:flex-row w-full max-w-md gap-3">
                    <input type="email" placeholder="Enter your email"
                        class="flex-1 px-5 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all">
                    <button class="btn-primary px-6 w-full sm:w-auto">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="relative container-custom py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
            {{-- Brand Column --}}
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 mb-6 group">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" 
                    class="w-20 h-20 rounded-xl bg-white/10 p-1 object-contain">
                    <div>
                        <span class="font-display font-bold text-2xl block">Talent Zone Academy</span>
                        <span class="text-slate-400 text-sm">Education Group</span>
                    </div>
                </a>
                <p class="text-slate-400 leading-relaxed mb-6 max-w-sm">
                    {{ config('schools.organization.tagline') }}. Providing world-class education across our two campuses.
                </p>
                
                {{-- Social Links --}}
                <div class="flex space-x-3">
                    @foreach([
                        ['icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z', 'label' => 'Facebook'],
                        ['icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z', 'label' => 'Instagram'],
                        ['icon' => 'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z', 'label' => 'Twitter'],
                        ['icon' => 'M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z', 'label' => 'LinkedIn'],
                    ] as $social)
                        <a href="#" aria-label="{{ $social['label'] }}"
                           class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-primary-600 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-primary-500/25">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $social['icon'] }}"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="lg:col-span-2">
                <h4 class="font-display font-semibold text-lg mb-6">Quick Links</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['route' => 'home', 'label' => 'Home'],
                        ['route' => 'schools', 'label' => 'Our Schools'],
                        ['route' => 'gallery', 'label' => 'Gallery'],
                        ['route' => 'staff', 'label' => 'Staff'],
                        ['route' => 'contact', 'label' => 'Contact'],
                    ] as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" 
                               class="text-slate-400 hover:text-white text-sm transition-colors inline-flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-primary-500 transition-colors"></span>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Our Campuses --}}
            <div class="lg:col-span-6">
                <h4 class="font-display font-semibold text-lg mb-6">Our Campuses</h4>
                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach(config('schools.schools') as $school)
                        @php
                            $colorBorder = match($school['color']) {
                                'primary' => 'border-primary-500 from-primary-500/10',
                                'accent' => 'border-accent-500 from-accent-500/10',
                                'warm' => 'border-warm-500 from-warm-500/10',
                                default => 'border-primary-500 from-primary-500/10',
                            };
                        @endphp
                        <a href="{{ route('schools.show', $school['slug']) }}" 
                           class="group block p-4 rounded-xl bg-gradient-to-br {{ $colorBorder }} to-transparent border-l-2 hover:bg-slate-800/50 transition-all">
                            <h5 class="font-semibold text-white group-hover:text-primary-400 transition-colors mb-2">
                                {{ Str::after($school['name'], 'Talent Zone Academy ') }}
                            </h5>
                            <p class="text-slate-500 text-xs mb-2 line-clamp-2">{{ $school['address'] }}</p>
                            <p class="text-slate-400 text-sm">{{ $school['phone'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="relative border-t border-slate-800">
        <div class="container-custom py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-sm">
                © {{ date('Y') }} {{ config('schools.organization.name') }}. All rights reserved.
            </p>
            <div class="flex items-center space-x-6">
                <a href="#" class="text-slate-500 hover:text-white text-sm transition-colors">Privacy Policy</a>
                <a href="#" class="text-slate-500 hover:text-white text-sm transition-colors">Terms of Service</a>
                <a href="#" class="text-slate-500 hover:text-white text-sm transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>