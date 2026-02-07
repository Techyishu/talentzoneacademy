<x-public-layout>
    @php
        $schools = config('schools.schools');
        $metrics = config('schools.metrics');
        $features = config('schools.features');
        $testimonials = config('schools.testimonials');
    @endphp

    {{-- Hero Slider Section --}}
    <section class="relative min-h-[85vh] overflow-hidden"
             x-data="{
                 currentSlide: 0,
                 slides: [0, 1, 2, 3],
                 autoplayInterval: null,
                 init() {
                     this.startAutoplay();
                 },
                 startAutoplay() {
                     this.autoplayInterval = setInterval(() => {
                         this.nextSlide();
                     }, 5000);
                 },
                 stopAutoplay() {
                     clearInterval(this.autoplayInterval);
                 },
                 nextSlide() {
                     this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                 },
                 prevSlide() {
                     this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                 },
                 goToSlide(index) {
                     this.currentSlide = index;
                     this.stopAutoplay();
                     this.startAutoplay();
                 }
             }"
             @mouseenter="stopAutoplay()"
             @mouseleave="startAutoplay()">

        {{-- Slide 1: Red Background with Torch Theme --}}
        <div x-show="currentSlide === 0"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex items-center"
             style="background: linear-gradient(135deg, #E31E24 0%, #FF4444 50%, #E31E24 100%);">

            <div class="container-custom relative z-10 py-16">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-white">
                        <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                            <span class="text-sm font-bold">🔥 Success to Everyone</span>
                        </div>
                        <h1 class="font-display font-bold text-5xl md:text-6xl lg:text-7xl leading-tight mb-6">
                            Ignite Your Child's
                            <span class="block text-yellow-300">Potential Today</span>
                        </h1>
                        <p class="text-xl text-white/90 mb-8 max-w-xl">
                            At Talent Zone Academy, we light the flame of knowledge that burns bright for a lifetime.
                        </p>
                        <a href="{{ route('schools') }}" class="btn-white text-lg px-10 py-5 inline-flex items-center gap-3">
                            Explore Programs
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                    <div class="relative h-96 hidden lg:flex items-center justify-center">
                        {{-- Torch Flame Illustration --}}
                        <div class="relative">
                            <svg class="w-64 h-64 animate-pulse" viewBox="0 0 200 200" fill="none">
                                <path d="M100 20 Q110 60 100 100 Q90 60 100 20 Z" fill="#FFD23F" opacity="0.9"/>
                                <path d="M100 40 Q105 65 100 90 Q95 65 100 40 Z" fill="#FFF" opacity="0.7"/>
                                <rect x="90" y="100" width="20" height="80" rx="2" fill="#2B2826"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Slide 2: Blue Background with Knowledge Theme --}}
        <div x-show="currentSlide === 1"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex items-center"
             style="background: linear-gradient(135deg, #003B71 0%, #0066CC 50%, #003B71 100%);">

            <div class="container-custom relative z-10 py-16">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="relative h-96 hidden lg:flex items-center justify-center order-2 lg:order-1">
                        {{-- Books Stack Illustration --}}
                        <div class="relative">
                            <div class="absolute inset-0 flex flex-col items-center justify-center space-y-4">
                                <div class="w-48 h-12 rounded-lg shadow-2xl" style="background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%); transform: rotate(-5deg);"></div>
                                <div class="w-48 h-12 rounded-lg shadow-2xl" style="background: linear-gradient(135deg, #87CEEB 0%, #ADD8E6 100%); transform: rotate(3deg);"></div>
                                <div class="w-48 h-12 rounded-lg shadow-2xl" style="background: linear-gradient(135deg, #FFD23F 0%, #FFC107 100%); transform: rotate(-2deg);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-white order-1 lg:order-2">
                        <div class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                            <span class="text-sm font-bold">📚 Excellence in Education</span>
                        </div>
                        <h1 class="font-display font-bold text-5xl md:text-6xl lg:text-7xl leading-tight mb-6">
                            Building Tomorrow's
                            <span class="block text-yellow-300">Leaders Today</span>
                        </h1>
                        <p class="text-xl text-white/90 mb-8 max-w-xl">
                            29 years of educational excellence with 5,500+ successful students across 3 premium campuses.
                        </p>
                        <a href="{{ route('contact') }}" class="btn-white text-lg px-10 py-5 inline-flex items-center gap-3">
                            Book Campus Tour
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Slide 3: Light Blue Background with Student Success --}}
        <div x-show="currentSlide === 2"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex items-center"
             style="background: linear-gradient(135deg, #87CEEB 0%, #ADD8E6 50%, #B0E0E6 100%);">

            <div class="container-custom relative z-10 py-16">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div style="color: #003B71;">
                        <div class="inline-block px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full mb-6">
                            <span class="text-sm font-bold">🎓 Holistic Development</span>
                        </div>
                        <h1 class="font-display font-bold text-5xl md:text-6xl lg:text-7xl leading-tight mb-6">
                            Where Dreams Take
                            <span class="block" style="color: #E31E24;">Flight</span>
                        </h1>
                        <p class="text-xl mb-8 max-w-xl" style="color: #003B71;">
                            World-class facilities, expert teachers, and a nurturing environment for your child's success.
                        </p>
                        <div class="flex flex-wrap gap-6 mb-8">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 flex-shrink-0" style="color: #E31E24;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-lg font-semibold" style="color: #003B71;">Smart Classrooms</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 flex-shrink-0" style="color: #E31E24;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-lg font-semibold" style="color: #003B71;">Sports Excellence</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 flex-shrink-0" style="color: #E31E24;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-lg font-semibold" style="color: #003B71;">Creative Arts</span>
                            </div>
                        </div>
                        <a href="{{ route('schools') }}" class="btn-primary text-lg px-10 py-5 inline-flex items-center gap-3">
                            View Our Campuses
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                    <div class="relative h-96 hidden lg:flex items-center justify-center">
                        {{-- Trophy Illustration --}}
                        <div class="relative">
                            <svg class="w-64 h-64" viewBox="0 0 200 200" fill="none">
                                <path d="M100 40 L120 100 L180 110 L130 150 L145 210 L100 180 L55 210 L70 150 L20 110 L80 100 Z" fill="#FFD23F"/>
                                <circle cx="100" cy="100" r="40" fill="#E31E24"/>
                                <text x="100" y="115" text-anchor="middle" fill="white" font-size="40" font-weight="bold">1</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Slide 4: White Background with CTA Focus --}}
        <div x-show="currentSlide === 3"
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex items-center bg-white">

            <div class="container-custom relative z-10 py-16">
                <div class="text-center max-w-4xl mx-auto">
                    <div class="inline-block px-6 py-3 rounded-full mb-8" style="background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%);">
                        <span class="text-sm font-bold text-white">🎯 Admissions Open 2026-27</span>
                    </div>
                    <h1 class="font-display font-bold text-5xl md:text-6xl lg:text-7xl leading-tight mb-8" style="color: #2B2826;">
                        Join 5,500+ Students
                        <span class="block mt-2">
                            <span style="color: #E31E24;">Achieving</span>
                            <span style="color: #003B71;">Excellence</span>
                        </span>
                    </h1>
                    <p class="text-2xl text-slate-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Experience education that goes beyond textbooks. Join the Talent Zone Academy family today!
                    </p>

                    {{-- Stats Row --}}
                    <div class="grid grid-cols-3 gap-8 mb-12 max-w-2xl mx-auto">
                        <div>
                            <div class="text-5xl font-bold mb-2" style="color: #E31E24;">3</div>
                            <div class="text-sm text-slate-600">Premium Campuses</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold mb-2" style="color: #003B71;">29+</div>
                            <div class="text-sm text-slate-600">Years Excellence</div>
                        </div>
                        <div>
                            <div class="text-5xl font-bold mb-2" style="color: #E31E24;">98%</div>
                            <div class="text-sm text-slate-600">Success Rate</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}" class="btn-primary text-lg px-10 py-5 inline-flex items-center gap-3">
                            Apply Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('schools') }}" class="btn-secondary text-lg px-10 py-5 inline-flex items-center gap-3">
                            Virtual Tour
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Arrows --}}
        <button @click="prevSlide()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/30 backdrop-blur-md hover:bg-white/50 flex items-center justify-center transition-all duration-300 group">
            <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button @click="nextSlide()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/30 backdrop-blur-md hover:bg-white/50 flex items-center justify-center transition-all duration-300 group">
            <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </section>

    {{-- 3 Schools, One Vision --}}
    <section class="section-padding relative overflow-hidden" style="background-color: #FFF8F0;">
        {{-- Background Decoration --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-10 right-20 w-24 h-24 rounded-full opacity-20" style="background-color: #FFD23F;"></div>
            <div class="absolute bottom-20 left-10 w-32 h-32 rounded-full opacity-20" style="background-color: #60A5FA;"></div>
        </div>

        <div class="container-custom relative">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Our Campuses</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Smart and clever kids<br>
                    ready to <span class="text-gradient-orange">fly high!</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Learn anytime with us. We teach One Smart Lesson at a time!
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($schools as $index => $school)
                    <x-public.school-card :school="$school" :index="$index" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Video Section --}}
    @if($activeVideo)
    <section class="section-padding bg-white relative overflow-hidden">
        <div class="container-custom">
            <x-public.section-heading 
                eyebrow="Featured Video"
                title="{{ $activeVideo->title }}" 
                subtitle="Experience our vibrant campus life and academic excellence."
            />

            <div class="max-w-4xl mx-auto">
                <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl bg-slate-900">
                    @if($activeVideo->video_type === 'local')
                        <video controls class="w-full h-full object-cover" poster="{{ $activeVideo->thumbnail_url }}">
                            <source src="{{ asset('storage/' . $activeVideo->video_url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <iframe 
                            src="{{ $activeVideo->embed_url }}" 
                            class="w-full h-full" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Metrics Strip --}}
    <section class="py-16 relative overflow-hidden" style="background-color: #2B2826;">
        <div class="container-custom relative">
            <div class="grid md:grid-cols-3 gap-12">
                {{-- Schools Stat --}}
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-5xl text-white mb-1">3</div>
                        <div class="text-white/80 text-base leading-tight">Premium Campuses<br>across Mumbai</div>
                    </div>
                </div>

                {{-- Students Stat --}}
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #FFD23F 0%, #FFC107 100%);">
                        <svg class="w-10 h-10" style="color: #2B2826;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-5xl text-white mb-1">5,500+</div>
                        <div class="text-white/80 text-base leading-tight">Happy Students<br>learning with us</div>
                    </div>
                </div>

                {{-- Teachers Stat --}}
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-display font-bold text-5xl text-white mb-1">355+</div>
                        <div class="text-white/80 text-base leading-tight">Expert Teachers<br>and Staff</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Programs & Learning Areas --}}
    <section class="section-padding relative overflow-hidden bg-white">
        <div class="container-custom relative">
            <div class="text-center mb-16">
                <p class="text-sm tracking-wide uppercase mb-3" style="color: #2B2826;">We focus on one impactful lesson at a time</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl" style="color: #2B2826;">
                    Shaping the <span class="text-gradient-orange">future</span> of students
                </h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                {{-- Letter Identification --}}
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full flex items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #60A5FA 0%, #93C5FD 100%);">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        {{-- Decorative elements --}}
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full opacity-70" style="background-color: #FFD23F;"></div>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2" style="color: #2B2826;">
                        Letter Identification
                    </h3>
                    <p class="text-sm text-slate-600 mb-3">Learn every letter of the alphabet</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium" style="background-color: #FFF8F0; color: #FF6B35;">
                        Pre School
                    </span>
                </div>

                {{-- General Knowledge --}}
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full flex items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        {{-- Decorative elements --}}
                        <div class="absolute -bottom-2 -left-2 w-6 h-6 rounded-full opacity-70" style="background-color: #10B981;"></div>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2" style="color: #2B2826;">
                        General Knowledge
                    </h3>
                    <p class="text-sm text-slate-600 mb-3">Expanding horizons every day</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium" style="background-color: #FFF8F0; color: #FF6B35;">
                        Fourth Grade
                    </span>
                </div>

                {{-- Geography Quiz --}}
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full flex items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #10B981 0%, #34D399 100%);">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        {{-- Decorative elements --}}
                        <div class="absolute -top-2 -left-2 w-7 h-7 rounded-full opacity-70" style="background-color: #60A5FA;"></div>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2" style="color: #2B2826;">
                        Geography Quiz
                    </h3>
                    <p class="text-sm text-slate-600 mb-3">Discover the world around us</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium" style="background-color: #FFF8F0; color: #FF6B35;">
                        First Grade
                    </span>
                </div>

                {{-- Visual Arts Training --}}
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 mx-auto rounded-full flex items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #FFD23F 0%, #FFC107 100%);">
                            <svg class="w-20 h-20" style="color: #2B2826;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        {{-- Decorative elements --}}
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full opacity-70" style="background-color: #FF6B35;"></div>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2" style="color: #2B2826;">
                        Visual Arts Training
                    </h3>
                    <p class="text-sm text-slate-600 mb-3">Express creativity through art</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium" style="background-color: #FFF8F0; color: #FF6B35;">
                        Sketching Class
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Confidence & Dreams CTA Cards --}}
    <section class="section-padding" style="background-color: #FFF8F0;">
        <div class="container-custom">
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Left Card - Yellow --}}
                <div class="relative rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: linear-gradient(135deg, #FFD23F 0%, #FFC107 100%);">
                    <div class="relative p-10 min-h-[380px] flex flex-col justify-between">
                        {{-- Decorative Arrow --}}
                        <div class="absolute bottom-10 right-10 opacity-20">
                            <svg class="w-32 h-32" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 50 L80 50 M80 50 L60 30 M80 50 L60 70" stroke="#2B2826" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        {{-- Book Icon --}}
                        <div class="mb-6">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background-color: rgba(43, 40, 38, 0.1);">
                                <svg class="w-8 h-8" style="color: #2B2826;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="mb-8">
                            <h3 class="font-display font-bold text-3xl md:text-4xl mb-4 leading-tight" style="color: #2B2826;">
                                Confidence that builds a brighter future.
                            </h3>
                            <p class="text-lg leading-relaxed" style="color: rgba(43, 40, 38, 0.8);">
                                Empowering kids with the confidence to dream big and achieve more.
                            </p>
                        </div>

                        {{-- CTA Button --}}
                        <div>
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="background-color: #FF6B35; color: white;">
                                Book Now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right Card - Orange --}}
                <div class="relative rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" style="background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);">
                    <div class="relative p-10 min-h-[380px] flex flex-col justify-between">
                        {{-- Decorative Paper Plane & Stars --}}
                        <div class="absolute top-10 right-10 opacity-20">
                            <svg class="w-24 h-24" viewBox="0 0 100 100" fill="white">
                                <path d="M10 50 L90 10 L60 60 L40 70 Z"/>
                                <circle cx="20" cy="20" r="3"/>
                                <circle cx="80" cy="70" r="4"/>
                                <circle cx="30" cy="80" r="2"/>
                            </svg>
                        </div>

                        {{-- Target Icon --}}
                        <div class="mb-6">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background-color: rgba(255, 255, 255, 0.2);">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="mb-8">
                            <h3 class="font-display font-bold text-3xl md:text-4xl text-white mb-4 leading-tight">
                                Helping kids to shoot their dreams.
                            </h3>
                            <p class="text-lg text-white/90 leading-relaxed">
                                Nurturing students to aim high and achieve their goals with excellence.
                            </p>
                        </div>

                        {{-- CTA Button --}}
                        <div>
                            <a href="{{ route('schools') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white rounded-xl font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="color: #FF6B35;">
                                Learn More
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Preview --}}
    <section class="section-padding relative overflow-hidden" style="background-color: #FFFBF7;">
        {{-- Background Decorative Shapes --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-10 right-10 w-20 h-20 rounded-full opacity-10" style="background-color: #FF6B35;"></div>
            <div class="absolute bottom-20 left-20 w-16 h-16 rounded-full opacity-10" style="background-color: #60A5FA;"></div>
        </div>

        <div class="container-custom relative">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Life at SchoolSuite</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Campus <span class="text-gradient-orange">Life</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Explore moments of learning, achievement, and joy across our campuses.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-12">
                @forelse($galleryImages as $image)
                    <div class="aspect-square rounded-2xl bg-gradient-to-br from-slate-200 to-slate-300 overflow-hidden group cursor-pointer relative">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        {{-- Colorful Overlay --}}
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(135deg, rgba(255, 107, 53, 0.7) 0%, rgba(255, 210, 63, 0.7) 100%);"></div>

                        {{-- Content --}}
                        <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-medium" style="color: #FF6B35;">
                                {{ $image->category ?? 'Campus Life' }}
                            </span>
                            @if($image->title)
                                <p class="text-white text-sm mt-2 font-medium">{{ $image->title }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 6; $i++)
                        <div class="aspect-square rounded-2xl overflow-hidden group cursor-pointer relative" style="background: linear-gradient(135deg, #E2E8F0 0%, #CBD5E1 100%);">
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>

            <div class="text-center">
                <a href="{{ route('gallery') }}" class="btn-primary text-base px-8 py-4 inline-flex items-center gap-2">
                    View Full Gallery
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="section-padding relative overflow-hidden" style="background-color: #FFF8F0;">
        <div class="container-custom relative">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Testimonials</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    What <span class="text-gradient-orange">Parents</span> Say
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Hear from families who have experienced the SchoolSuite difference.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @php
                    $avatarColors = [
                        ['bg' => 'linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%)', 'text' => 'white'],
                        ['bg' => 'linear-gradient(135deg, #10B981 0%, #34D399 100%)', 'text' => 'white'],
                        ['bg' => 'linear-gradient(135deg, #60A5FA 0%, #93C5FD 100%)', 'text' => 'white'],
                    ];
                @endphp

                @forelse($approvedReviews->take(3) as $index => $review)
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 hover:shadow-lg transition-shadow duration-300">
                        {{-- Stars --}}
                        <div class="flex items-center gap-1 mb-6">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5" style="color: {{ $i <= $review->rating ? '#FF6B35' : '#E2E8F0' }};" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        {{-- Content --}}
                        <p class="text-slate-600 leading-relaxed mb-8">"{{ $review->content }}"</p>

                        {{-- Author --}}
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background: {{ $avatarColors[$index % 3]['bg'] }};">
                                <span class="font-bold text-lg" style="color: {{ $avatarColors[$index % 3]['text'] }};">
                                    {{ substr($review->reviewer_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ $review->reviewer_name }}</div>
                                <div class="text-slate-500 text-sm">Parent</div>
                            </div>
                        </div>
                    </div>
                @empty
                    @foreach($testimonials as $index => $testimonial)
                        <div class="bg-white p-8 rounded-3xl border border-slate-200 hover:shadow-lg transition-shadow duration-300">
                            {{-- Stars --}}
                            <div class="flex items-center gap-1 mb-6">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" style="color: #FF6B35;" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            {{-- Content --}}
                            <p class="text-slate-600 leading-relaxed mb-8">"{{ $testimonial['content'] }}"</p>

                            {{-- Author --}}
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background: {{ $avatarColors[$index % 3]['bg'] }};">
                                    <span class="font-bold text-lg" style="color: {{ $avatarColors[$index % 3]['text'] }};">
                                        {{ substr($testimonial['name'], 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $testimonial['name'] }}</div>
                                    <div class="text-slate-500 text-sm">{{ $testimonial['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA Band --}}
    <x-public.cta-band 
        title="Ready to Start Your Child's Journey?"
        subtitle="Book a campus tour or submit an enquiry today. Our admissions team will guide you through the process."
        primaryText="Book Campus Tour"
        primaryUrl="{{ route('contact') }}"
        secondaryText="Enquire Now"
        secondaryUrl="{{ route('contact') }}"
    />
</x-public-layout>
