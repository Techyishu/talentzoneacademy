<x-public-layout>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 overflow-hidden">
        {{-- Spacer for fixed navbar --}}
        <div class="h-20"></div>

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 right-0 w-72 md:w-[500px] h-72 md:h-[500px] bg-orange-500/15 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 md:w-[400px] h-72 md:h-[400px] bg-primary-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div class="container-custom relative z-10 text-center py-16 md:py-24 lg:py-32">
            <span class="badge badge-glass mb-6">Result-Oriented Teaching</span>
            <h1 class="font-display font-bold text-3xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight max-w-4xl mx-auto">
                We Don't Just Teach Subjects — <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">We Build Winners</span>
            </h1>
            <p class="text-white/80 text-base md:text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
                We go beyond syllabus completion. We train students to <strong class="text-yellow-300">excel, compete, and secure top ranks</strong> through structured preparation, smart methods, and continuous practice.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="tel:7206061212" class="btn-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Call: 7206061212
                </a>
                <a href="{{ route('contact') }}" class="btn-secondary border-white/30 text-white bg-transparent hover:bg-white/10">
                    Enquire Online
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- About / What We Do --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">About Talent Zone Academy</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4" style="color: #2B2826;">
                    Result-Oriented <span class="text-gradient-orange">Education</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto">
                    A result-oriented institute focused on building strong academic foundations and preparing students for competitive exams.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 lg:gap-10">
                {{-- Exams We Prepare For --}}
                <div class="card-premium p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl md:text-2xl text-slate-900">Exams We Prepare For</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Sainik School', 'Rashtriya Military School (RMS)', 'RIMC', 'Gurukul Entrance Exams', 'National-Level Olympiads'] as $exam)
                            <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3">
                                <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">{{ $exam }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Our Teaching Focus --}}
                <div class="card-premium p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-xl md:text-2xl text-slate-900">Our Teaching Focus</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Strong concept clarity', 'Logical thinking development', 'Regular practice and revision', 'Personal attention to every student', 'Competitive exam readiness'] as $focus)
                            <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3">
                                <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">{{ $focus }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3-Pillar Learning System --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">Our Unique Learning System</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4" style="color: #2B2826;">
                    Our Powerful <span class="text-gradient-orange">3-Pillar</span> System
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                @php
                    $pillars = [
                        [
                            'title' => 'Visual Mastery',
                            'subtitle' => 'Smart Learning',
                            'gradient' => 'from-blue-500 to-cyan-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                            'desc' => 'We use Smart Panels and digital teaching to make learning easy and effective.',
                            'items' => ['Smart Panels & visual explanation', 'Diagrams, animations & real examples', 'Easy understanding of tough concepts', 'Long-term memory retention', 'Faster and deeper learning'],
                            'color' => 'text-blue-500',
                        ],
                        [
                            'title' => 'The Plus-One Strategy',
                            'subtitle' => 'Advanced Learning',
                            'gradient' => 'from-orange-500 to-red-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>',
                            'desc' => 'We always prepare students one level ahead of their school syllabus.',
                            'items' => ['Complete school syllabus coverage', 'Extra worksheets for strong practice', 'Olympiad-level questions', 'Entrance exam-level preparation', 'Higher-level logical thinking'],
                            'color' => 'text-orange-500',
                        ],
                        [
                            'title' => 'Small Batch Focus',
                            'subtitle' => 'Personal Attention',
                            'gradient' => 'from-emerald-500 to-teal-500',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                            'desc' => 'Small batch sizes ensure personal attention to every student.',
                            'items' => ['Personal attention to each student', 'Quick doubt solving', 'Regular performance monitoring', 'Individual improvement support', 'Better teacher-student interaction'],
                            'color' => 'text-emerald-500',
                        ],
                    ];
                @endphp

                @foreach($pillars as $pillar)
                    <div class="card-premium p-6 md:p-8 flex flex-col">
                        <div class="w-14 h-14 bg-gradient-to-br {{ $pillar['gradient'] }} rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $pillar['icon'] !!}</svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900 mb-1">{{ $pillar['title'] }}</h3>
                        <p class="text-orange-coral text-sm font-semibold mb-3">{{ $pillar['subtitle'] }}</p>
                        <p class="text-slate-600 text-sm mb-5">{{ $pillar['desc'] }}</p>
                        <ul class="space-y-2.5 flex-1">
                            @foreach($pillar['items'] as $item)
                                <li class="flex items-start gap-2 text-sm text-slate-600">
                                    <svg class="w-5 h-5 {{ $pillar['color'] }} flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Olympiad Preparation --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                <div>
                    <span class="badge badge-primary mb-4">All Classes</span>
                    <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-4">
                        Olympiad <span class="text-gradient-orange">Preparation</span>
                    </h2>
                    <p class="text-slate-600 text-lg mb-8">
                        We prepare students for national-level Olympiad exams along with their regular studies.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            ['Mathematics Olympiad', 'from-amber-500 to-orange-500'],
                            ['Reasoning / Mental Ability', 'from-violet-500 to-purple-500'],
                            ['English Olympiad', 'from-blue-500 to-cyan-500'],
                            ['General Knowledge', 'from-emerald-500 to-teal-500'],
                        ] as $subject)
                            <div class="card-premium p-4 text-center">
                                <div class="w-10 h-10 bg-gradient-to-br {{ $subject[1] }} rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                </div>
                                <span class="text-slate-800 font-semibold text-sm">{{ $subject[0] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-6 md:p-8 border border-amber-200">
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-6">Benefits of Olympiad Prep</h3>
                    <ul class="space-y-4">
                        @foreach([
                            'Improves IQ and logical thinking',
                            'Develops fast problem-solving skills',
                            'Builds confidence',
                            'Strengthens concepts',
                            'Helps in Sainik School, RMS, and RIMC exams',
                            'Makes students mentally strong and competitive'
                        ] as $benefit)
                            <li class="flex items-start gap-3 text-slate-700">
                                <div class="w-6 h-6 bg-amber-400 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                {{ $benefit }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Entrance Exam Preparation --}}
    <section class="section-padding text-white relative overflow-hidden" style="background-color: #2B2826;">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-orange-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary-500/10 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-300 text-sm font-bold tracking-wide uppercase mb-3">Entrance Exam Preparation</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4 text-white">
                    Structured <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">Competitive</span> Prep
                </h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    Structured preparation for major competitive entrance exams.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10 md:mb-14">
                @foreach([
                    ['Sainik School', 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                    ['Rashtriya Military School', 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                    ['RIMC', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                    ['Gurukul Entrance', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ] as $exam)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 md:p-6 border border-white/10 text-center hover:bg-white/20 transition-all duration-300">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $exam[1] }}"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-sm md:text-base text-white">{{ $exam[0] }}</h3>
                    </div>
                @endforeach
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 md:p-10 border border-white/10 max-w-3xl mx-auto">
                <h3 class="font-display font-bold text-xl text-white mb-6 text-center">Students Are Trained In</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(['Speed-solving techniques', 'Time management', 'Accuracy improvement', 'Mock tests like real exams', 'Exam pressure handling', 'Smart exam strategies'] as $skill)
                        <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-white/90 text-sm font-medium">{{ $skill }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Class-Wise Preparation Structure --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">Class-Wise Preparation</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4" style="color: #2B2826;">
                    Structured Learning <span class="text-gradient-orange">Journey</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Each stage is carefully designed to build on the previous one.
                </p>
            </div>

            @php
                $stages = [
                    ['Foundation Stage', 'Classes 2nd & 3rd', 'from-blue-500 to-cyan-500', 'bg-blue-50', 'border-blue-200', 'text-blue-600',
                     'Building strong academic basics.',
                     ['Reading, writing & calculation skills', 'Activity-based & visual learning', 'Fun worksheets & regular practice', 'Discipline & study habits', 'Basic Olympiad preparation'],
                     'Most academic work is completed during academy hours so students are not overburdened.',
                     'Strong foundation and confidence.'],
                    ['Advantage Stage', 'Class 4th', 'from-violet-500 to-purple-500', 'bg-violet-50', 'border-violet-200', 'text-violet-600',
                     'Early competitive preparation.',
                     ['Sainik School level questions', 'Focus on Mathematics & Reasoning', 'Advanced worksheets beyond textbooks', 'Olympiad preparation', 'Regular testing system'],
                     null,
                     'Give students an early advantage.'],
                    ['Target-Based Preparation', 'Classes 5th & 6th', 'from-orange-500 to-red-500', 'bg-orange-50', 'border-orange-200', 'text-orange-600',
                     'Critical stage for entrance exam preparation.',
                     ['Complete full syllabus by October', 'Structured revision notes', 'RMS Test Series in November', 'Sainik School Test Series in Dec-Jan', 'Prep for Gurukul & school final exams'],
                     'Daily practice worksheets, weekly tests, structured revision, and time-bound mock tests.',
                     'Maximum practice and revision.'],
                    ['Advanced Preparation', 'Class 7th', 'from-emerald-500 to-teal-500', 'bg-emerald-50', 'border-emerald-200', 'text-emerald-600',
                     'Higher-level academic and logical development.',
                     ['Advanced Mathematics & Reasoning', 'General Knowledge (Science & SST)', 'Olympiad preparation', 'RIMC preparation', 'Analytical thinking development'],
                     null,
                     'Develop intelligent and confident students.'],
                    ['Final Selection Stage', 'Class 8th', 'from-rose-500 to-pink-500', 'bg-rose-50', 'border-rose-200', 'text-rose-600',
                     'Most important stage for entrance exam success.',
                     ['Complete syllabus early', 'RMS Test Series & Exam', 'Full syllabus revision', 'Sainik School Test Series & Exam', 'Prep for Gurukul & school finals'],
                     'Full-length mock tests, speed & accuracy training, exam strategy, and confidence building.',
                     'Secure top ranks and final selection.'],
                ];
            @endphp

            <div class="max-w-4xl mx-auto space-y-6">
                @foreach($stages as $i => $s)
                    <div class="{{ $s[3] }} rounded-2xl md:rounded-3xl p-5 md:p-8 border {{ $s[4] }}">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-11 h-11 md:w-12 md:h-12 bg-gradient-to-br {{ $s[2] }} rounded-xl flex items-center justify-center flex-shrink-0 text-white font-bold text-lg shadow-lg">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-display font-bold text-lg md:text-xl text-slate-900">{{ $s[0] }}</h3>
                                <span class="inline-block px-3 py-0.5 bg-gradient-to-r {{ $s[2] }} text-white text-xs font-bold rounded-full mt-1">{{ $s[1] }}</span>
                            </div>
                        </div>

                        <p class="text-slate-600 text-sm md:text-base mb-4">{{ $s[6] }}</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4">
                            @foreach($s[7] as $item)
                                <div class="flex items-start gap-2 text-sm text-slate-700">
                                    <svg class="w-4 h-4 {{ $s[5] }} flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    {{ $item }}
                                </div>
                            @endforeach
                        </div>

                        @if($s[8])
                            <p class="text-xs text-slate-500 italic mb-3">{{ $s[8] }}</p>
                        @endif

                        <div class="bg-white/80 rounded-xl px-4 py-2.5 border border-slate-100 inline-flex items-center gap-2">
                            <svg class="w-4 h-4 {{ $s[5] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <p class="text-sm font-bold text-slate-800">Goal: <span class="text-slate-600 font-medium">{{ $s[9] }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Extra-Curricular Activities --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">Overall Development</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4" style="color: #2B2826;">
                    Beyond <span class="text-gradient-orange">Academics</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    We develop students academically, mentally, and physically.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 md:gap-6 max-w-4xl mx-auto">
                @foreach([
                    ['Inter-Class Quizzes', 'Thinking speed', 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Drawing & Painting', 'Creative skills', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['Sports Day', 'Physical fitness', 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Speech Skills', 'Communication', 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z'],
                    ['Personality Dev', 'Confidence', 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ] as $activity)
                    <div class="card-premium p-4 md:p-5 text-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity[2] }}"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xs md:text-sm text-slate-900 mb-0.5">{{ $activity[0] }}</h3>
                        <p class="text-slate-500 text-xs">{{ $activity[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- What Makes Us Different --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">Why Choose Us</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl mb-4" style="color: #2B2826;">
                    What Makes Us <span class="text-gradient-orange">Different</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
                @foreach([
                    'Extra worksheets beyond textbooks',
                    'Topic-wise & advanced practice questions',
                    'Structured revision notes',
                    'Olympiad & Entrance preparation together',
                    'Small batches for personal attention',
                    'Individual student improvement support',
                    'Discipline and regular monitoring',
                    'Result-oriented teaching approach',
                ] as $point)
                    <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-100">
                        <svg class="w-5 h-5 text-orange-coral flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-slate-700 text-sm font-medium">{{ $point }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Winning Formula --}}
            <div class="gradient-warm rounded-3xl p-8 md:p-10 text-center text-white max-w-2xl mx-auto">
                <h3 class="font-display font-bold text-2xl mb-6">Our Winning Formula</h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 text-base md:text-lg font-bold">
                    <span class="bg-white/20 rounded-xl px-5 py-2.5">Smart Teaching</span>
                    <span class="text-xl">+</span>
                    <span class="bg-white/20 rounded-xl px-5 py-2.5">Extra Practice</span>
                    <span class="text-xl">+</span>
                    <span class="bg-white/20 rounded-xl px-5 py-2.5">Personal Attention</span>
                </div>
                <p class="mt-6 text-white/90 text-xl font-bold">= Big Results</p>
            </div>
        </div>
    </section>

    {{-- Parent Communication --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-3">Parent Partnership</p>
                <h2 class="font-display font-bold text-3xl md:text-4xl mb-4" style="color: #2B2826;">
                    Parent Communication & <span class="text-gradient-orange">Monitoring</span>
                </h2>
                <p class="text-slate-600 text-lg mb-10">
                    Parents are important partners in student success.
                </p>

                <div class="grid sm:grid-cols-2 gap-4 mb-10">
                    @foreach([
                        'Regular monitoring of student performance',
                        'Extra attention to weak students',
                        'Calls and messages to parents about progress',
                        'Special improvement support plans',
                    ] as $item)
                        <div class="card-premium p-4 text-left flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-slate-700 text-sm font-medium">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200">
                    <p class="text-emerald-800 font-display font-bold text-lg">Our Promise</p>
                    <p class="text-emerald-700 mt-1">No child is left behind. Every student receives proper care and guidance.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="section-padding bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-yellow-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-orange-500/10 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <h2 class="font-display font-bold text-3xl md:text-5xl text-white mb-4">
                Ready to See Your Child <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">Lead the Rank List?</span>
            </h2>
            <p class="text-white/70 text-lg max-w-xl mx-auto mb-3">
                Don't settle for average education.
            </p>
            <p class="text-white font-bold text-xl mb-10">
                Choose smart preparation. Choose success.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                <a href="tel:7206061212" class="btn-white text-lg px-8 py-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Contact: 7206061212
                </a>
                <a href="{{ route('contact') }}" class="btn-secondary border-white/30 text-white bg-transparent hover:bg-white/10 text-lg px-8 py-4">
                    Enquire Online
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div class="text-white/60">
                <p class="text-lg font-semibold">Talent Zone Academy</p>
                <p class="text-base mt-1">Success to Everyone</p>
            </div>
        </div>
    </section>

</x-public-layout>
