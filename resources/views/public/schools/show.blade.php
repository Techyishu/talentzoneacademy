<x-public-layout>
    @php
        $colorMap = [
            'primary' => [
                'gradient' => 'from-primary-600 via-primary-700 to-primary-900',
                'light' => 'bg-primary-100',
                'text' => 'text-primary-600',
                'badge' => 'bg-primary-500',
                'tab' => 'bg-primary-600',
                'border' => 'border-primary-200',
            ],
            'accent' => [
                'gradient' => 'from-accent-600 via-accent-700 to-accent-900',
                'light' => 'bg-accent-100',
                'text' => 'text-accent-600',
                'badge' => 'bg-accent-500',
                'tab' => 'bg-accent-600',
                'border' => 'border-accent-200',
            ],
            'warm' => [
                'gradient' => 'from-warm-600 via-warm-700 to-warm-900',
                'light' => 'bg-warm-100',
                'text' => 'text-warm-600',
                'badge' => 'bg-warm-500',
                'tab' => 'bg-warm-600',
                'border' => 'border-warm-200',
            ],
        ];
        $colors = $colorMap[$school['color']] ?? $colorMap['primary'];
    @endphp

    {{-- Hero --}}
    <section class="relative py-32 bg-gradient-to-br {{ $colors['gradient'] }} overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-10 right-10 w-96 h-96 bg-white/10 rounded-full filter blur-3xl animate-float"></div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-white/5 rounded-full filter blur-3xl animate-float-delayed"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        
        <div class="container-custom relative z-10">
            {{-- Breadcrumb --}}
            <a href="{{ route('schools') }}"
                class="inline-flex items-center text-white/70 hover:text-white text-sm mb-8 transition-colors group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to All Schools
            </a>
            
            <div class="max-w-3xl">

                <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-4">
                    {{ $school['name'] }}
                </h1>
                <p class="text-xl text-white/80 mb-8">{{ $school['tagline'] }}</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="btn-primary">
                        Apply Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="tel:{{ $school['phone'] }}" class="btn-ghost">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Call Us
                    </a>
                </div>
            </div>
        </div>
    </section>



    {{-- Tabs Content --}}
    <section class="section-padding" x-data="{ activeTab: 'about' }">
        <div class="container-custom">
            {{-- Tab Navigation --}}
            <div class="flex overflow-x-auto gap-2 mb-16 pb-2 -mx-4 px-4 md:mx-0 md:px-0">
                @foreach(['about' => 'About', 'facilities' => 'Facilities', 'academics' => 'Academics', 'activities' => 'Activities', 'transport' => 'Transport', 'contact' => 'Contact'] as $key => $label)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}' ? '{{ $colors['tab'] }} text-white shadow-lg' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-6 py-3.5 rounded-xl font-medium text-sm whitespace-nowrap transition-all duration-300">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Tab Panels --}}
            <div>
                {{-- About --}}
                <div x-show="activeTab === 'about'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-16">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <span class="badge badge-primary mb-4">About Our School</span>
                            <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-6">A School Built for Excellence</h2>
                            <p class="text-slate-600 leading-relaxed mb-6 text-lg">
                                {{ $school['name'] }} stands as a beacon of educational excellence. Our school combines state-of-the-art infrastructure with time-tested teaching methodologies to create an environment where every student can thrive.
                            </p>
                            <p class="text-slate-600 leading-relaxed">
                                With a focus on holistic development, we nurture not just academic excellence but also character, creativity, and critical thinking skills that prepare students for success in the 21st century.
                            </p>
                        </div>
                        <div class="relative">
                            <div class="aspect-[4/3] bg-gradient-to-br {{ $colors['light'] }} rounded-3xl flex items-center justify-center overflow-hidden">
                                <svg class="w-24 h-24 {{ $colors['text'] }} opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            {{-- Floating Card --}}
                            <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 max-w-xs">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl {{ $colors['light'] }} flex items-center justify-center">
                                        <svg class="w-6 h-6 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">CBSE Affiliated</div>
                                        <div class="text-slate-500 text-sm">Recognized Excellence</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if(isset($school['md']))
                    {{-- Managing Director's Message --}}
                    <div class="relative bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl p-8 md:p-12 overflow-hidden mb-8">
                        {{-- Decorative --}}
                        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-200 rounded-full filter blur-3xl opacity-30"></div>
                        
                        <div class="relative flex flex-col md:flex-row gap-8 items-start">
                            <div class="w-32 h-32 rounded-2xl overflow-hidden shadow-lg border-4 border-white flex-shrink-0">
                                <img src="{{ asset($school['md']['image']) }}" alt="{{ $school['md']['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="badge badge-primary mb-4 bg-orange-500 text-white border-orange-600">Managing Director's Message</span>
                                <p class="text-slate-700 text-xl italic leading-relaxed mb-6">
                                    "{{ $school['md']['message'] }}"
                                </p>
                                <div>
                                    <div class="font-bold text-slate-900 text-lg">{{ $school['md']['name'] }}</div>
                                    <div class="text-slate-500">Managing Director</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Principal's Message --}}
                    <div class="relative bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl p-8 md:p-12 overflow-hidden">
                        {{-- Decorative --}}
                        <div class="absolute top-0 right-0 w-64 h-64 {{ $colors['light'] }} rounded-full filter blur-3xl opacity-50"></div>
                        
                        <div class="relative flex flex-col md:flex-row gap-8 items-start">
                            <div class="w-28 h-28 rounded-2xl bg-gradient-to-br {{ $colors['light'] }} flex-shrink-0 flex items-center justify-center shadow-lg">
                                <span class="{{ $colors['text'] }} font-bold text-3xl">{{ substr($school['principal']['name'], 0, 1) }}</span>
                            </div>
                            <div>
                                <span class="badge badge-primary mb-4">Principal's Message</span>
                                <p class="text-slate-700 text-xl italic leading-relaxed mb-6">
                                    "{{ $school['principal']['message'] }}"
                                </p>
                                <div>
                                    <div class="font-bold text-slate-900 text-lg">{{ $school['principal']['name'] }}</div>
                                    <div class="text-slate-500">Principal, {{ Str::after($school['name'], 'Talent Zone Academy ') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Facilities --}}
                <div x-show="activeTab === 'facilities'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-12">
                        <span class="badge badge-primary mb-4">World-Class Infrastructure</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900">Our Facilities</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($school['highlights'] as $highlight)
                            <div class="group bg-white p-8 rounded-2xl border border-slate-100 card-hover text-center">
                                <div class="w-16 h-16 mx-auto rounded-2xl {{ $colors['light'] }} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-slate-900 text-lg mb-2">{{ $highlight }}</h3>
                                <p class="text-slate-500 text-sm">World-class {{ strtolower($highlight) }} for comprehensive learning.</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Academics --}}
                <div x-show="activeTab === 'academics'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-12">
                        <span class="badge badge-primary mb-4">Academic Excellence</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900">Academic Programs</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                            <div class="w-14 h-14 rounded-2xl {{ $colors['light'] }} flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h3 class="font-display font-semibold text-2xl text-slate-900 mb-4">Primary School (Grades 1-5)</h3>
                            <p class="text-slate-600 mb-6">Foundation years focusing on literacy, numeracy, and discovery-based learning.</p>
                            <ul class="space-y-3 text-slate-600">
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Activity-based learning</li>
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Language development</li>
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Creative arts integration</li>
                            </ul>
                        </div>
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                            <div class="w-14 h-14 rounded-2xl {{ $colors['light'] }} flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <h3 class="font-display font-semibold text-2xl text-slate-900 mb-4">Secondary School (Grades 6-10)</h3>
                            <p class="text-slate-600 mb-6">Comprehensive curriculum aligned with CBSE/ICSE standards.</p>
                            <ul class="space-y-3 text-slate-600">
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Subject specialization</li>
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Lab-based sciences</li>
                                <li class="flex items-center gap-3"><span class="w-2 h-2 {{ $colors['badge'] }} rounded-full"></span> Board exam preparation</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Activities --}}
                <div x-show="activeTab === 'activities'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-12">
                        <span class="badge badge-primary mb-4">Beyond Academics</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900">Extra-curricular Activities</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['Sports', 'Music', 'Dance', 'Drama', 'Art', 'Debate', 'Robotics', 'Yoga'] as $activity)
                            <div class="group bg-white p-6 rounded-2xl border {{ $colors['border'] }} hover:shadow-lg transition-all text-center card-hover">
                                <div class="w-12 h-12 mx-auto rounded-xl {{ $colors['light'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="font-semibold text-slate-900">{{ $activity }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Transport --}}
                <div x-show="activeTab === 'transport'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-12">
                        <span class="badge badge-primary mb-4">Safe & Reliable</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900">Transport Services</h2>
                    </div>
                    
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-3xl p-8 md:p-12">
                        <div class="grid md:grid-cols-3 gap-8">
                            @foreach([
                                ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'title' => 'GPS Enabled', 'desc' => 'Real-time tracking for parents'],
                                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Trained Staff', 'desc' => 'Experienced drivers and attendants'],
                                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Wide Coverage', 'desc' => 'Multiple routes across the city'],
                            ] as $feature)
                                <div class="text-center">
                                    <div class="w-20 h-20 mx-auto {{ $colors['light'] }} rounded-2xl flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}" />
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $feature['title'] }}</h3>
                                    <p class="text-slate-600">{{ $feature['desc'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div x-show="activeTab === 'contact'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center mb-12">
                        <span class="badge badge-primary mb-4">Get In Touch</span>
                        <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900">Contact This School</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            @foreach([
                                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Address', 'value' => $school['address']],
                                ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title' => 'Phone', 'value' => $school['phone']],
                                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Email', 'value' => $school['email']],
                            ] as $contact)
                                <div class="flex items-start gap-5 p-6 bg-white rounded-2xl border border-slate-100">
                                    <div class="w-14 h-14 {{ $colors['light'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-7 h-7 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $contact['icon'] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-slate-900 text-lg mb-1">{{ $contact['title'] }}</h3>
                                        <p class="text-slate-600">{{ $contact['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="aspect-video bg-slate-200 rounded-3xl flex items-center justify-center">
                            <div class="text-center text-slate-400">
                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <p>Interactive Map Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Other Schools --}}
    <section class="py-16 bg-slate-50">
        <div class="container-custom">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-display font-bold text-2xl text-slate-900">Explore Other Schools</h2>
                <a href="{{ route('schools') }}" class="text-primary-600 font-semibold text-sm hover:text-primary-700 flex items-center gap-1">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($allSchools as $otherSchool)
                    @if($otherSchool['slug'] !== $school['slug'])
                        <a href="{{ route('schools.show', $otherSchool['slug']) }}" 
                           class="group flex items-center gap-6 p-6 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-primary-200 transition-all">
                            @php
                                $otherColor = match($otherSchool['color']) {
                                    'primary' => 'from-primary-100 to-primary-200 text-primary-600',
                                    'accent' => 'from-accent-100 to-accent-200 text-accent-600',
                                    'warm' => 'from-warm-100 to-warm-200 text-warm-600',
                                    default => 'from-primary-100 to-primary-200 text-primary-600',
                                };
                            @endphp
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $otherColor }} flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $otherSchool['name'] }}</h3>
                                <p class="text-slate-500 text-sm">{{ $otherSchool['tagline'] }}</p>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <x-public.cta-band 
        title="Ready to Join {{ Str::after($school['name'], 'Talent Zone Academy ') }}?"
        subtitle="Begin your application today or schedule a school visit."
        primaryText="Apply Now"
        primaryUrl="{{ route('contact') }}"
        secondaryText="Book a Tour"
        secondaryUrl="{{ route('contact') }}"
    />
</x-public-layout>