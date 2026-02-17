<x-public-layout>

    {{-- Hero Section --}}
    <section class="relative py-28 md:py-36 bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/20 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-500/15 rounded-full filter blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-accent-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <div class="inline-block px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <span class="text-sm font-bold text-white">🏆 Result-Oriented Teaching</span>
            </div>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight">
                Where We Don't Just Teach Subjects —<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">We Build Winners</span>
            </h1>
            <p class="text-white/90 text-lg md:text-xl max-w-3xl mx-auto mb-8 leading-relaxed">
                Most schools focus only on completing the syllabus. At Talent Zone Academy, we go beyond syllabus completion.
                We don't teach students just to pass exams — we train them to <strong class="text-yellow-300">excel, compete, and secure top ranks</strong>.
            </p>
            <p class="text-white/70 text-base max-w-2xl mx-auto mb-10 italic">
                Through structured preparation, smart teaching methods, visual learning, and continuous practice, we help students become confident, disciplined, and high-performing learners ready for competitive success.
            </p>
            <div class="inline-block bg-white/10 backdrop-blur-sm rounded-2xl px-8 py-4 border border-white/20 mb-8">
                <p class="text-white font-display font-bold text-lg">"Success is not by chance; it is by preparation."</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:7206061212" class="group relative px-8 py-4 bg-white text-slate-900 font-bold rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1">
                    <span class="relative z-10 flex items-center gap-2">
                        📞 Contact Now: 7206061212
                    </span>
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 border-2 border-white/30 text-white font-bold rounded-xl hover:bg-white/10 transition-all hover:-translate-y-1">
                    Enquire Online
                </a>
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">About Talent Zone Academy</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Result-Oriented <span class="text-gradient-orange">Education</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto">
                    Talent Zone Academy is a result-oriented institute focused on building strong academic foundations and preparing students for competitive exams.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-start">
                {{-- Exams We Prepare For --}}
                <div class="bg-gradient-to-br from-slate-50 to-orange-50 rounded-3xl p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-orange-coral/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-2xl text-slate-900">Exams We Prepare For</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Sainik School', 'Rashtriya Military School (RMS)', 'RIMC', 'Gurukul Entrance Exams', 'National-Level Olympiads'] as $exam)
                            <div class="flex items-center gap-3 bg-white rounded-xl px-5 py-4 shadow-sm border border-slate-100">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 font-medium">{{ $exam }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Our Teaching Focus --}}
                <div class="bg-gradient-to-br from-primary-50 to-slate-50 rounded-3xl p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-primary-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-2xl text-slate-900">Our Teaching Focus</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Strong concept clarity', 'Logical thinking development', 'Regular practice and revision', 'Personal attention', 'Competitive exam readiness'] as $focus)
                            <div class="flex items-center gap-3 bg-white rounded-xl px-5 py-4 shadow-sm border border-slate-100">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 font-medium">{{ $focus }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <p class="text-center text-slate-600 text-lg mt-10 max-w-3xl mx-auto">
                We prepare students not only for exams, but for <strong>long-term academic success</strong> and real-life problem-solving.
            </p>
        </div>
    </section>

    {{-- 3-Pillar Learning System --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Our Unique Learning System</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Our Powerful <span class="text-gradient-orange">3-Pillar</span> System
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Pillar 1 --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-2">Visual Mastery</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-4">Smart Learning</p>
                    <p class="text-slate-600 mb-6">We use Smart Panels and digital teaching methods to make learning easy and effective.</p>
                    <ul class="space-y-3">
                        @foreach(['Teaching through Smart Panels and visual explanation', 'Diagrams, animations, and real-life examples', 'Easy understanding of difficult concepts', 'Long-term memory retention', 'Faster and deeper learning'] as $item)
                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-sm italic mt-6">Students remember better when they see and understand concepts clearly.</p>
                </div>

                {{-- Pillar 2 --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-2">The Plus-One Strategy</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-4">Advanced Learning Approach</p>
                    <p class="text-slate-600 mb-6">We always prepare students one level ahead of their school syllabus.</p>
                    <ul class="space-y-3">
                        @foreach(['Complete school syllabus coverage', 'Extra worksheets for strong practice', 'Olympiad-level questions', 'Entrance exam-level preparation', 'Higher-level logical thinking questions'] as $item)
                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-sm italic mt-6">Students stay ahead academically and perform better in school and competitive exams.</p>
                </div>

                {{-- Pillar 3 --}}
                <div class="group bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-2">Small Batch Focus</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-4">Personal Attention System</p>
                    <p class="text-slate-600 mb-6">We maintain small batch sizes to ensure personal attention to every student.</p>
                    <ul class="space-y-3">
                        @foreach(['Personal attention to each student', 'Quick doubt solving', 'Regular performance monitoring', 'Individual improvement support', 'Better teacher-student interaction'] as $item)
                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-sm italic mt-6">No child gets lost in the crowd.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Olympiad Preparation --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="badge badge-primary mb-4">All Classes</span>
                    <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-6">
                        Olympiad <span class="text-gradient-orange">Preparation</span>
                    </h2>
                    <p class="text-slate-600 text-lg mb-8">
                        We prepare students for national-level Olympiad exams along with their regular studies.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 mb-8">
                        @foreach(['Mathematics Olympiad', 'Reasoning / Mental Ability Olympiad', 'English Olympiad', 'General Knowledge Olympiad'] as $subject)
                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl px-5 py-4 border border-amber-100">
                                <span class="text-slate-800 font-semibold text-sm">🏅 {{ $subject }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-100">
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
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                {{ $benefit }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-600 text-sm italic mt-6 font-medium">Our goal is to make students competition-ready from an early age.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Entrance Exam Preparation --}}
    <section class="section-padding bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary-500/10 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="text-center mb-16">
                <p class="text-orange-300 text-sm font-bold tracking-wide uppercase mb-4">Entrance Exam Preparation</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6 text-white">
                    Structured <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">Competitive</span> Prep
                </h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">
                    We provide structured preparation for major competitive entrance exams.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach([
                    ['name' => 'Sainik School', 'icon' => '🎖️'],
                    ['name' => 'Rashtriya Military School', 'icon' => '⭐'],
                    ['name' => 'RIMC', 'icon' => '🏅'],
                    ['name' => 'Gurukul Entrance', 'icon' => '📚'],
                ] as $exam)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 text-center hover:bg-white/20 transition-all">
                        <span class="text-4xl mb-4 block">{{ $exam['icon'] }}</span>
                        <h3 class="font-display font-bold text-lg text-white">{{ $exam['name'] }}</h3>
                        <p class="text-white/70 text-sm mt-1">Entrance Exam</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 md:p-10 border border-white/10 max-w-3xl mx-auto">
                <h3 class="font-display font-bold text-xl text-white mb-6 text-center">Students Are Trained In</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach([
                        'Speed-solving techniques',
                        'Time management',
                        'Accuracy improvement',
                        'Mock tests like real exams',
                        'Exam pressure handling',
                        'Smart exam strategies'
                    ] as $skill)
                        <div class="flex items-center gap-3 bg-white/10 rounded-xl px-5 py-3">
                            <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-white/90 text-sm font-medium">{{ $skill }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="text-white/70 text-sm text-center italic mt-6">This ensures students perform confidently in real exams.</p>
            </div>
        </div>
    </section>

    {{-- Class-Wise Preparation Structure --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Class-Wise Preparation Structure</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Structured Learning <span class="text-gradient-orange">Journey</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    Each stage is carefully designed to build on the previous one, ensuring continuous growth.
                </p>
            </div>

            {{-- Timeline Layout --}}
            <div class="relative max-w-4xl mx-auto">
                {{-- Vertical line --}}
                <div class="absolute left-0 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-orange-coral via-primary-500 to-emerald-500 transform md:-translate-x-1/2 hidden md:block"></div>

                @php
                    $stages = [
                        [
                            'title' => 'Foundation Stage',
                            'classes' => 'Classes 2nd & 3rd',
                            'color' => 'from-blue-500 to-cyan-500',
                            'border' => 'border-blue-200',
                            'bg' => 'bg-blue-50',
                            'description' => 'This stage focuses on building strong academic basics.',
                            'items' => ['Reading, writing, and calculation skills', 'Activity-based and visual learning', 'Fun worksheets and regular practice', 'Discipline and study habits', 'Basic Olympiad preparation'],
                            'note' => 'Most academic work is completed during academy hours so students are not overburdened with excessive homework.',
                            'goal' => 'Strong foundation and confidence.',
                        ],
                        [
                            'title' => 'Advantage Stage',
                            'classes' => 'Class 4th',
                            'color' => 'from-violet-500 to-purple-500',
                            'border' => 'border-violet-200',
                            'bg' => 'bg-violet-50',
                            'description' => 'This stage introduces early competitive preparation.',
                            'items' => ['Introduction to Sainik School level questions', 'Special focus on Mathematics and Reasoning', 'Advanced worksheets beyond textbooks', 'Olympiad preparation', 'Regular testing system'],
                            'note' => null,
                            'goal' => 'Give students an early advantage.',
                        ],
                        [
                            'title' => 'Target-Based Preparation',
                            'classes' => 'Classes 5th & 6th',
                            'color' => 'from-orange-500 to-red-500',
                            'border' => 'border-orange-200',
                            'bg' => 'bg-orange-50',
                            'description' => 'This is a critical stage for entrance exam preparation.',
                            'items' => ['Complete full syllabus by October', 'Structured revision notes', 'RMS Test Series in November', 'Rashtriya Military School Exam in December', 'Sainik School Test Series in Dec–Jan', 'Sainik School Entrance Exam in January', 'Prep for Gurukul and school final exams'],
                            'note' => 'Includes daily practice worksheets, weekly tests (topic-wise, chapter-wise, and mixed), structured revision, and time-bound mock tests.',
                            'goal' => 'Maximum practice and revision for success.',
                        ],
                        [
                            'title' => 'Advanced Preparation Stage',
                            'classes' => 'Class 7th',
                            'color' => 'from-emerald-500 to-teal-500',
                            'border' => 'border-emerald-200',
                            'bg' => 'bg-emerald-50',
                            'description' => 'Focus on higher-level academic and logical development.',
                            'items' => ['Advanced Mathematics and Reasoning', 'General Knowledge (Science and SST)', 'Olympiad preparation', 'RIMC preparation', 'Logical and analytical thinking development'],
                            'note' => null,
                            'goal' => 'Develop intelligent and confident students.',
                        ],
                        [
                            'title' => 'Final Selection Stage',
                            'classes' => 'Class 8th',
                            'color' => 'from-rose-500 to-pink-500',
                            'border' => 'border-rose-200',
                            'bg' => 'bg-rose-50',
                            'description' => 'This is the most important stage for entrance exam success.',
                            'items' => ['Complete syllabus early', 'Revision notes provided', 'RMS Test Series in November', 'RMS Exam in December', 'Full syllabus revision', 'Sainik School Test Series in Dec–Jan', 'Sainik School Entrance Exam in January', 'Prep for Gurukul and school finals'],
                            'note' => 'Special focus on full-length mock tests, speed & accuracy training, exam strategy, and confidence building.',
                            'goal' => 'Secure top ranks and final selection.',
                        ],
                    ];
                @endphp

                <div class="space-y-12 md:space-y-16">
                    @foreach($stages as $index => $stage)
                        <div class="relative flex flex-col {{ $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} items-start gap-8 md:gap-12">
                            {{-- Timeline dot --}}
                            <div class="hidden md:flex absolute left-1/2 top-6 -translate-x-1/2 w-5 h-5 bg-gradient-to-br {{ $stage['color'] }} rounded-full ring-4 ring-white shadow-lg z-10"></div>

                            {{-- Content --}}
                            <div class="md:w-1/2 {{ $index % 2 === 0 ? 'md:pr-12 md:text-right' : 'md:pl-12' }}">
                                <div class="inline-block px-4 py-1.5 bg-gradient-to-r {{ $stage['color'] }} text-white text-xs font-bold rounded-full mb-3">
                                    {{ $stage['classes'] }}
                                </div>
                                <h3 class="font-display font-bold text-2xl text-slate-900 mb-2">{{ $stage['title'] }}</h3>
                                <p class="text-slate-600 mb-4">{{ $stage['description'] }}</p>
                            </div>

                            <div class="md:w-1/2 {{ $index % 2 === 0 ? 'md:pl-12' : 'md:pr-12' }}">
                                <div class="{{ $stage['bg'] }} rounded-2xl p-6 border {{ $stage['border'] }}">
                                    <ul class="space-y-2 mb-4">
                                        @foreach($stage['items'] as $item)
                                            <li class="flex items-start gap-2 text-sm text-slate-700">
                                                <svg class="w-4 h-4 text-slate-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($stage['note'])
                                        <p class="text-xs text-slate-500 italic mb-3">{{ $stage['note'] }}</p>
                                    @endif
                                    <div class="bg-white rounded-xl px-4 py-3 border border-slate-100">
                                        <p class="text-sm font-bold text-slate-800">🎯 Goal: <span class="text-slate-600 font-medium">{{ $stage['goal'] }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Extra-Curricular Activities --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Overall Development</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    Beyond <span class="text-gradient-orange">Academics</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    We focus on overall personality development. We develop students academically, mentally, and physically.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6 max-w-5xl mx-auto">
                @foreach([
                    ['icon' => '🧠', 'title' => 'Inter-Class Quizzes', 'desc' => 'Improve thinking speed'],
                    ['icon' => '🎨', 'title' => 'Drawing & Painting', 'desc' => 'Creative competitions'],
                    ['icon' => '⚽', 'title' => 'Sports Day', 'desc' => 'Physical activities'],
                    ['icon' => '🎤', 'title' => 'Speech Skills', 'desc' => 'Communication development'],
                    ['icon' => '🌟', 'title' => 'Personality Dev', 'desc' => 'Confidence building'],
                ] as $activity)
                    <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <span class="text-4xl block mb-4">{{ $activity['icon'] }}</span>
                        <h3 class="font-display font-bold text-sm text-slate-900 mb-1">{{ $activity['title'] }}</h3>
                        <p class="text-slate-500 text-xs">{{ $activity['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <p class="text-center text-slate-700 font-semibold mt-10">
                🎯 Goal: Make students confident and capable in real life.
            </p>
        </div>
    </section>

    {{-- What Makes Us Different --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Why Choose Us</p>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6" style="color: #2B2826;">
                    What Makes Us <span class="text-gradient-orange">Different</span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach([
                    'Extra worksheets beyond textbooks',
                    'Topic-wise and advanced practice questions',
                    'Structured revision notes',
                    'Olympiad and Entrance preparation together',
                    'Small batches for personal attention',
                    'Individual student improvement support',
                    'Discipline and regular monitoring',
                    'Result-oriented teaching approach',
                ] as $point)
                    <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-5 py-4 border border-slate-100">
                        <svg class="w-5 h-5 text-orange-coral flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-slate-700 text-sm font-medium">{{ $point }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Winning Formula --}}
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl p-8 md:p-10 text-center text-white max-w-2xl mx-auto">
                <h3 class="font-display font-bold text-2xl mb-4">Our Winning Formula</h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 text-lg font-bold">
                    <span class="bg-white/20 rounded-xl px-4 py-2">Smart Teaching</span>
                    <span class="text-2xl">+</span>
                    <span class="bg-white/20 rounded-xl px-4 py-2">Extra Practice</span>
                    <span class="text-2xl">+</span>
                    <span class="bg-white/20 rounded-xl px-4 py-2">Personal Attention</span>
                </div>
                <p class="mt-6 text-white/90 text-xl font-bold">= Big Results 🎯</p>
            </div>
        </div>
    </section>

    {{-- Parent Communication --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-orange-coral text-sm font-bold tracking-wide uppercase mb-4">Parent Partnership</p>
                <h2 class="font-display font-bold text-3xl md:text-4xl mb-6" style="color: #2B2826;">
                    Parent Communication & <span class="text-gradient-orange">Student Monitoring</span>
                </h2>
                <p class="text-slate-600 text-lg mb-10">
                    We believe parents are important partners in student success.
                </p>

                <div class="grid sm:grid-cols-2 gap-4 mb-10">
                    @foreach([
                        'Regular monitoring of student performance',
                        'Extra attention to weak students',
                        'Calls and messages to parents if a child does not show improvement',
                        'Special improvement support plans',
                    ] as $item)
                        <div class="flex items-start gap-3 bg-white rounded-xl px-5 py-4 shadow-sm border border-slate-100 text-left">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-slate-700 text-sm font-medium">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200 inline-block">
                    <p class="text-emerald-800 font-display font-bold text-lg">✨ Our Promise</p>
                    <p class="text-emerald-700 mt-1">No child is left behind. Every student receives proper care and guidance.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="section-padding bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500/10 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <h2 class="font-display font-bold text-4xl md:text-5xl text-white mb-6">
                Ready to See Your Child<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-yellow-400">Lead the Rank List?</span>
            </h2>
            <p class="text-white/80 text-lg max-w-xl mx-auto mb-4">
                Don't settle for average education.
            </p>
            <p class="text-white font-bold text-xl mb-10">
                Choose smart preparation. Choose success.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                <a href="tel:7206061212" class="group relative px-8 py-4 bg-white text-slate-900 font-bold rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1 text-lg">
                    <span class="relative z-10 flex items-center gap-2 justify-center">
                        📞 Contact: 7206061212
                    </span>
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 border-2 border-white/30 text-white font-bold rounded-xl hover:bg-white/10 transition-all hover:-translate-y-1 text-lg">
                    Enquire Online
                </a>
            </div>
            <div class="space-y-2 text-white/80">
                <p class="text-lg font-semibold">🏫 Talent Zone Academy</p>
                <p class="text-base">✨ Success to Everyone</p>
            </div>
        </div>
    </section>

</x-public-layout>
