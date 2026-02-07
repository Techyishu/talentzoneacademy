<x-public-layout>
    @php
        $schools = config('schools.schools');
    @endphp

    {{-- Page Header --}}
    <section class="relative py-24 overflow-hidden" style="background: linear-gradient(135deg, #E31E24 0%, #FF4444 50%, #E31E24 100%);">
        {{-- Decorative Doodles --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
            {{-- Stars --}}
            <svg class="absolute top-10 left-10 w-12 h-12" viewBox="0 0 100 100" fill="white">
                <path d="M50 10 L61 39 L92 39 L67 57 L78 86 L50 68 L22 86 L33 57 L8 39 L39 39 Z"/>
            </svg>
            <svg class="absolute bottom-20 right-20 w-10 h-10" viewBox="0 0 100 100" fill="white">
                <path d="M50 10 L61 39 L92 39 L67 57 L78 86 L50 68 L22 86 L33 57 L8 39 L39 39 Z"/>
            </svg>

            {{-- Circles --}}
            <div class="absolute top-1/3 right-1/4 w-20 h-20 rounded-full border-4 border-white"></div>
            <div class="absolute bottom-1/3 left-1/4 w-16 h-16 rounded-full border-4 border-white"></div>

            {{-- Zigzag --}}
            <svg class="absolute bottom-10 left-10 w-24 h-24" viewBox="0 0 100 100" fill="none">
                <path d="M10 20 L30 40 L10 60 L30 80" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="container-custom relative z-10 text-center text-white">
            <div class="inline-block px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <span class="text-sm font-bold">3 Campuses • 5,500+ Students</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl mb-4">Our Schools</h1>
            <p class="text-white/90 text-lg md:text-xl max-w-2xl mx-auto">
                Three uniquely positioned campuses, united by a shared commitment to educational excellence.
            </p>
        </div>
    </section>

    {{-- Schools Grid --}}
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
                    Discover our three modern campuses designed for excellence and growth.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($schools as $index => $school)
                    <x-public.school-card :school="$school" :index="$index" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Compare Campuses --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">At a Glance</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Compare <span class="text-gradient-orange">Campuses</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Find the perfect fit for your child's educational journey.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="px-8 py-6 text-left text-sm font-semibold text-slate-900" style="background-color: #FFF8F0;">Feature</th>
                            @foreach($schools as $school)
                                @php
                                    $colorMap = [
                                        'primary' => '#E31E24',
                                        'accent' => '#003B71',
                                        'warm' => '#87CEEB',
                                    ];
                                    $bgColorMap = [
                                        'primary' => '#FFF5F5',
                                        'accent' => '#E6F2FF',
                                        'warm' => '#F0F8FF',
                                    ];
                                    $color = $colorMap[$school['color']] ?? $colorMap['primary'];
                                    $bgColor = $bgColorMap[$school['color']] ?? $bgColorMap['primary'];
                                @endphp
                                <th class="px-8 py-6 text-center" style="background-color: #FFF8F0;">
                                    <span class="inline-block px-4 py-2 rounded-xl text-sm font-bold" style="background-color: {{ $bgColor }}; color: {{ $color }};">
                                        {{ Str::after($school['name'], 'SchoolSuite ') }}
                                    </span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 text-sm text-slate-600 font-medium">Established</td>
                            @foreach($schools as $school)
                                <td class="px-8 py-5 text-center text-sm font-semibold text-slate-900">
                                    {{ $school['established'] }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 text-sm text-slate-600 font-medium">Students</td>
                            @foreach($schools as $school)
                                <td class="px-8 py-5 text-center text-sm font-semibold text-slate-900">
                                    {{ $school['students'] }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 text-sm text-slate-600 font-medium">Teachers</td>
                            @foreach($schools as $school)
                                <td class="px-8 py-5 text-center text-sm font-semibold text-slate-900">
                                    {{ $school['teachers'] }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 text-sm text-slate-600 font-medium">Key Highlights</td>
                            @foreach($schools as $school)
                                <td class="px-8 py-5 text-center text-sm text-slate-600">
                                    {{ implode(', ', array_slice($school['highlights'], 0, 2)) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="px-8 py-5 text-sm text-slate-600 font-medium">Action</td>
                            @foreach($schools as $school)
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('schools.show', $school['slug']) }}"
                                        class="inline-flex items-center text-sm font-semibold text-orange-coral hover:underline">
                                        View Details
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <x-public.cta-band title="Can't Decide? Let Us Help!"
        subtitle="Schedule a campus tour and experience the Talent Zone Academy difference firsthand."
        primaryText="Book a Tour"
        primaryUrl="{{ route('contact') }}" />
</x-public-layout>
