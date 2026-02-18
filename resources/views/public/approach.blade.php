<x-public-layout>

    {{-- ============================================ --}}
    {{-- HERO --}}
    {{-- ============================================ --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(160deg, #003B71 0%, #00264d 60%, #111 100%);">
        <div class="h-20"></div>

        {{-- Background decoration --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-10 right-0 w-[400px] h-[400px] rounded-full opacity-30" style="background: radial-gradient(circle, rgba(227,30,36,0.25) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 left-10 w-[300px] h-[300px] rounded-full opacity-20" style="background: radial-gradient(circle, rgba(0,102,204,0.3) 0%, transparent 70%);"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 48px 48px;"></div>
        </div>

        <div class="container-custom relative z-10 py-20 md:py-28 lg:py-36">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-sm font-bold tracking-[0.2em] uppercase mb-6" style="color: #FFD700;">Talent Zone Academy</p>
                <h1 class="font-display font-bold text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-white leading-tight mb-6">
                    Where We Don't Just Teach Subjects —
                    <span class="block mt-2" style="background: linear-gradient(135deg, #FFD700, #FFA500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">We Build Winners</span>
                </h1>
                <div class="max-w-2xl mx-auto mb-10">
                    <p class="text-white/80 text-base md:text-lg leading-relaxed mb-4">
                        Most schools focus only on completing the syllabus. At Talent Zone Academy, we go beyond syllabus completion.
                    </p>
                    <p class="text-white/80 text-base md:text-lg leading-relaxed mb-4">
                        We don't teach students just to pass exams — we train them to <strong class="text-yellow-300">excel, compete, and secure top ranks</strong>.
                    </p>
                    <p class="text-white/70 text-sm md:text-base leading-relaxed mb-6">
                        Through structured preparation, smart teaching methods, visual learning, and continuous practice, we help students become confident, disciplined, and high-performing learners ready for competitive success.
                    </p>
                    <p class="text-yellow-300/90 italic font-semibold text-base md:text-lg">
                        "Success is not by chance; it is by preparation."
                    </p>
                </div>
                <a href="tel:7206061212" class="btn-primary px-8 py-4 text-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Contact Now: 7206061212
                </a>
            </div>
        </div>

        {{-- Bottom curve --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" fill="none" class="w-full"><path d="M0 60V30Q360 0 720 15T1440 30V60H0Z" fill="white"/></svg>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- ABOUT TALENT ZONE ACADEMY --}}
    {{-- ============================================ --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">About Talent Zone Academy</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-5">
                    Result-Oriented <span class="text-gradient-orange">Education</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto leading-relaxed">
                    Talent Zone Academy is a result-oriented institute focused on building strong academic foundations and preparing students for competitive exams.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
                {{-- Exams We Prepare For --}}
                <div class="card-premium p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #E31E24 0%, #FF4444 100%);">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900">Exams We Prepare For</h3>
                    </div>
                    <div class="space-y-2.5">
                        @foreach(['Sainik School', 'Rashtriya Military School (RMS)', 'RIMC', 'Gurukul Entrance Exams', 'National-Level Olympiads'] as $exam)
                            <div class="flex items-center gap-3 rounded-xl px-4 py-3" style="background: #FFF5F5;">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #E31E24;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                                <span class="text-slate-800 font-medium text-sm">{{ $exam }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Our Teaching Focus --}}
                <div class="card-premium p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #003B71 0%, #0066CC 100%);">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900">Our Teaching Focus</h3>
                    </div>
                    <div class="space-y-2.5">
                        @foreach(['Strong concept clarity', 'Logical thinking development', 'Regular practice and revision', 'Personal attention', 'Competitive exam readiness'] as $focus)
                            <div class="flex items-center gap-3 rounded-xl px-4 py-3" style="background: #E6F2FF;">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #003B71;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span class="text-slate-800 font-medium text-sm">{{ $focus }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <p class="text-slate-600 text-center text-base mt-8 max-w-2xl mx-auto">
                We prepare students not only for exams, but for long-term academic success and real-life problem-solving.
            </p>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- 3-PILLAR LEARNING SYSTEM --}}
    {{-- ============================================ --}}
    <section class="section-padding" style="background: #F0F8FF;">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">Our Unique Learning System</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-4">
                    Our Powerful <span class="text-gradient-orange">3-Pillar</span> System
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">

                {{-- Pillar 1: Visual Mastery --}}
                <div class="card-premium p-6 md:p-8 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background: linear-gradient(135deg, #003B71, #0066CC);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-1">Visual Mastery</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-3">Smart Learning</p>
                    <p class="text-slate-600 text-sm mb-5 leading-relaxed">We use Smart Panels and digital teaching methods to make learning easy and effective.</p>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Teaching through Smart Panels & visual explanation', 'Diagrams, animations & real-life examples', 'Easy understanding of difficult concepts', 'Long-term memory retention', 'Faster and deeper learning'] as $item)
                            <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #003B71;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-xs mt-4 italic">Students remember better when they see and understand concepts clearly.</p>
                </div>

                {{-- Pillar 2: Plus-One Strategy --}}
                <div class="card-premium p-6 md:p-8 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background: linear-gradient(135deg, #E31E24, #FF4444);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-1">The Plus-One Strategy</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-3">Advanced Learning Approach</p>
                    <p class="text-slate-600 text-sm mb-5 leading-relaxed">We always prepare students one level ahead of their school syllabus.</p>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Complete school syllabus coverage', 'Extra worksheets for strong practice', 'Olympiad-level questions', 'Entrance exam-level preparation', 'Higher-level logical thinking questions'] as $item)
                            <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #E31E24;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-xs mt-4 italic">Students stay ahead academically and perform better in school and competitive exams.</p>
                </div>

                {{-- Pillar 3: Small Batch Focus --}}
                <div class="card-premium p-6 md:p-8 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background: linear-gradient(135deg, #059669, #10b981);">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-900 mb-1">Small Batch Focus</h3>
                    <p class="text-orange-coral text-sm font-semibold mb-3">Personal Attention System</p>
                    <p class="text-slate-600 text-sm mb-5 leading-relaxed">We maintain small batch sizes to ensure personal attention to every student.</p>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Personal attention to each student', 'Quick doubt solving', 'Regular performance monitoring', 'Individual improvement support', 'Better teacher-student interaction'] as $item)
                            <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #059669;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-500 text-xs mt-4 italic">No child gets lost in the crowd.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- OLYMPIAD PREPARATION --}}
    {{-- ============================================ --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <span class="badge badge-primary mb-4">All Classes</span>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-4">
                    Olympiad <span class="text-gradient-orange">Preparation</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-3xl mx-auto">
                    We prepare students for national-level Olympiad exams along with their regular studies.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto items-start">
                {{-- Subjects --}}
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-900 mb-5">Subjects We Cover</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $subjects = [
                                ['Mathematics Olympiad', 'linear-gradient(135deg, #E31E24, #FF4444)', 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                                ['Reasoning / Mental Ability', 'linear-gradient(135deg, #7c3aed, #a855f7)', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                                ['English Olympiad', 'linear-gradient(135deg, #003B71, #0066CC)', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                ['General Knowledge', 'linear-gradient(135deg, #059669, #10b981)', 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ];
                        @endphp
                        @foreach($subjects as $s)
                            <div class="card-premium p-4 text-center">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: {{ $s[1] }};">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s[2] }}"/></svg>
                                </div>
                                <span class="text-slate-800 font-semibold text-sm">{{ $s[0] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Benefits --}}
                <div class="rounded-3xl p-6 md:p-8 border" style="background: linear-gradient(135deg, #FFF5F5, #FFE4E6); border-color: #fecaca;">
                    <h3 class="font-display font-bold text-lg text-slate-900 mb-5">Benefits</h3>
                    <ul class="space-y-3.5">
                        @foreach([
                            'Improves IQ and logical thinking',
                            'Develops fast problem-solving skills',
                            'Builds confidence',
                            'Strengthens concepts',
                            'Helps in Sainik School, RMS, and RIMC exams',
                            'Makes students mentally strong and competitive',
                        ] as $b)
                            <li class="flex items-start gap-3 text-slate-800">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #E31E24;">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-medium text-sm">{{ $b }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-slate-600 text-sm mt-5 italic">Our goal is to make students competition-ready from an early age.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- ENTRANCE EXAM PREPARATION --}}
    {{-- ============================================ --}}
    <section class="section-padding relative overflow-hidden" style="background: #2B2826;">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(227,30,36,0.08) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(0,59,113,0.1) 0%, transparent 70%);"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-sm font-bold tracking-widest uppercase mb-3" style="color: #FFD700;">Entrance Exam Preparation</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-white mb-4">
                    Structured <span style="background: linear-gradient(135deg, #FFD700, #FFA500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Competitive</span> Prep
                </h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    We provide structured preparation for major competitive entrance exams.
                </p>
            </div>

            {{-- Exam cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
                @php
                    $exams = [
                        ['Sainik School Entrance Exam', 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                        ['Rashtriya Military School Entrance Exam', 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                        ['RIMC Entrance Exam', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                        ['Gurukul Entrance Exam', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ];
                @endphp
                @foreach($exams as $exam)
                    <div class="rounded-2xl p-5 border text-center transition-all duration-300 hover:border-yellow-400/30" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: rgba(255,255,255,0.1);">
                            <svg class="w-6 h-6" style="color: #FFD700;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $exam[1] }}"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xs md:text-sm text-white leading-snug">{{ $exam[0] }}</h3>
                    </div>
                @endforeach
            </div>

            {{-- Training skills --}}
            <div class="rounded-3xl p-6 md:p-8 border max-w-3xl mx-auto" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                <h3 class="font-display font-bold text-lg text-white mb-5 text-center">Students Are Trained In</h3>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach(['Speed-solving techniques', 'Time management', 'Accuracy improvement', 'Mock tests like real exams', 'Exam pressure handling', 'Smart exam strategies'] as $skill)
                        <div class="flex items-center gap-3 rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.07);">
                            <svg class="w-5 h-5 flex-shrink-0" style="color: #FFD700;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-white/90 text-sm font-medium">{{ $skill }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="text-white/60 text-sm text-center mt-5 italic">This ensures students perform confidently in real exams.</p>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- CLASS-WISE PREPARATION --}}
    {{-- ============================================ --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">Class-Wise Preparation Structure</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-4">
                    Structured Learning <span class="text-gradient-orange">Journey</span>
                </h2>
            </div>

            @php
                $stages = [
                    [
                        'num' => '1',
                        'title' => 'Foundation Stage',
                        'classes' => 'Classes 2nd & 3rd',
                        'gradient' => 'linear-gradient(135deg, #003B71, #0066CC)',
                        'bg' => '#E6F2FF',
                        'border' => '#bfdbfe',
                        'accent' => '#003B71',
                        'desc' => 'This stage focuses on building strong academic basics.',
                        'items' => ['Reading, writing, and calculation skills', 'Activity-based and visual learning', 'Fun worksheets and regular practice', 'Discipline and study habits', 'Basic Olympiad preparation'],
                        'note' => 'Most academic work is completed during academy hours so students are not overburdened with excessive homework.',
                        'goal' => 'Strong foundation and confidence.',
                    ],
                    [
                        'num' => '2',
                        'title' => 'Advantage Stage',
                        'classes' => 'Class 4th',
                        'gradient' => 'linear-gradient(135deg, #7c3aed, #a855f7)',
                        'bg' => '#f3e8ff',
                        'border' => '#d8b4fe',
                        'accent' => '#7c3aed',
                        'desc' => 'This stage introduces early competitive preparation.',
                        'items' => ['Introduction to Sainik School level questions', 'Special focus on Mathematics and Reasoning', 'Advanced worksheets beyond textbooks', 'Olympiad preparation', 'Regular testing system'],
                        'note' => null,
                        'goal' => 'Give students an early advantage.',
                    ],
                    [
                        'num' => '3',
                        'title' => 'Target-Based Preparation',
                        'classes' => 'Classes 5th & 6th',
                        'gradient' => 'linear-gradient(135deg, #E31E24, #FF4444)',
                        'bg' => '#FFF5F5',
                        'border' => '#fecaca',
                        'accent' => '#E31E24',
                        'desc' => 'This is a critical stage for entrance exam preparation.',
                        'items' => ['Complete full syllabus by October', 'Structured revision notes', 'RMS Test Series in November', 'Rashtriya Military School Exam in December', 'Full syllabus revision after RMS exam', 'Sainik School Test Series in Dec & Jan', 'Sainik School Entrance Exam in January', 'Prep for Gurukul & school final exams'],
                        'note' => 'Extra Academic Support: Daily practice worksheets, weekly tests (topic-wise, chapter-wise & mixed tests), structured revision system, and time-bound mock tests.',
                        'goal' => 'Maximum practice and revision for success.',
                    ],
                    [
                        'num' => '4',
                        'title' => 'Advanced Preparation Stage',
                        'classes' => 'Class 7th',
                        'gradient' => 'linear-gradient(135deg, #059669, #10b981)',
                        'bg' => '#ecfdf5',
                        'border' => '#a7f3d0',
                        'accent' => '#059669',
                        'desc' => 'Focus on higher-level academic and logical development.',
                        'items' => ['Advanced Mathematics and Reasoning', 'General Knowledge (Science and SST)', 'Olympiad preparation', 'RIMC preparation', 'Logical and analytical thinking development'],
                        'note' => null,
                        'goal' => 'Develop intelligent and confident students.',
                    ],
                    [
                        'num' => '5',
                        'title' => 'Final Selection Stage',
                        'classes' => 'Class 8th',
                        'gradient' => 'linear-gradient(135deg, #dc2626, #f43f5e)',
                        'bg' => '#fff1f2',
                        'border' => '#fecdd3',
                        'accent' => '#dc2626',
                        'desc' => 'This is the most important stage for entrance exam success.',
                        'items' => ['Complete syllabus early', 'Revision notes provided', 'RMS Test Series in November', 'RMS Exam in December', 'Full syllabus revision', 'Sainik School Test Series in Dec & Jan', 'Sainik School Entrance Exam in January', 'Prep for Gurukul & school final exams'],
                        'note' => 'Special Focus: Full-length mock tests, speed and accuracy training, exam strategy, and confidence building.',
                        'goal' => 'Secure top ranks and final selection.',
                    ],
                ];
            @endphp

            <div class="max-w-4xl mx-auto space-y-6">
                @foreach($stages as $s)
                    <div class="rounded-2xl md:rounded-3xl p-5 md:p-8 border" style="background: {{ $s['bg'] }}; border-color: {{ $s['border'] }};">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-11 h-11 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-bold text-lg shadow-lg" style="background: {{ $s['gradient'] }};">
                                {{ $s['num'] }}
                            </div>
                            <div>
                                <h3 class="font-display font-bold text-lg md:text-xl text-slate-900">{{ $s['title'] }}</h3>
                                <span class="inline-block px-3 py-0.5 text-white text-xs font-bold rounded-full mt-1" style="background: {{ $s['gradient'] }};">{{ $s['classes'] }}</span>
                            </div>
                        </div>
                        <p class="text-slate-700 text-sm md:text-base mb-4">{{ $s['desc'] }}</p>
                        <div class="grid sm:grid-cols-2 gap-2 mb-4">
                            @foreach($s['items'] as $item)
                                <div class="flex items-start gap-2 text-sm text-slate-700">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color: {{ $s['accent'] }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    {{ $item }}
                                </div>
                            @endforeach
                        </div>
                        @if($s['note'])
                            <p class="text-xs text-slate-500 italic mb-3">{{ $s['note'] }}</p>
                        @endif
                        <div class="bg-white/80 rounded-xl px-4 py-2.5 border border-white inline-flex items-center gap-2">
                            <svg class="w-4 h-4" style="color: {{ $s['accent'] }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <p class="text-sm font-bold text-slate-800">Goal: <span class="text-slate-600 font-medium">{{ $s['goal'] }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- EXTRA-CURRICULAR ACTIVITIES --}}
    {{-- ============================================ --}}
    <section class="section-padding" style="background: #F0F8FF;">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">Extra-Curricular Activities & Overall Development</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-4">
                    Beyond <span class="text-gradient-orange">Academics</span>
                </h2>
                <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                    We focus on overall personality development. We develop students academically, mentally, and physically.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-5 max-w-4xl mx-auto">
                @php
                    $activities = [
                        ['Inter-Class Quizzes', 'Thinking speed', 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'linear-gradient(135deg, #E31E24, #FF4444)'],
                        ['Drawing & Painting', 'Creative skills', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'linear-gradient(135deg, #7c3aed, #a855f7)'],
                        ['Sports & Physical', 'Physical fitness', 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'linear-gradient(135deg, #059669, #10b981)'],
                        ['Speech Skills', 'Communication', 'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z', 'linear-gradient(135deg, #003B71, #0066CC)'],
                        ['Personality Dev', 'Confidence', 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'linear-gradient(135deg, #d97706, #f59e0b)'],
                    ];
                @endphp
                @foreach($activities as $a)
                    <div class="card-premium p-4 md:p-5 text-center">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: {{ $a[3] }};">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $a[2] }}"/></svg>
                        </div>
                        <h3 class="font-display font-bold text-xs md:text-sm text-slate-900 mb-0.5">{{ $a[0] }}</h3>
                        <p class="text-slate-500 text-xs">{{ $a[1] }}</p>
                    </div>
                @endforeach
            </div>

            <p class="text-slate-600 text-center text-sm mt-8 italic max-w-lg mx-auto">
                Goal: Make students confident and capable in real life.
            </p>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- WHAT MAKES US DIFFERENT --}}
    {{-- ============================================ --}}
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">Why Choose Us</p>
                <h2 class="font-display font-bold text-3xl md:text-5xl text-slate-900 mb-4">
                    What Makes Talent Zone Academy <span class="text-gradient-orange">Different</span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto mb-12">
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
                    <div class="flex items-start gap-3 rounded-xl px-4 py-3.5 border" style="background: #F0F8FF; border-color: #e2e8f0;">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #E31E24;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-slate-700 text-sm font-medium">{{ $point }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Winning Formula --}}
            <div class="gradient-warm rounded-3xl p-8 md:p-10 text-center max-w-2xl mx-auto">
                <h3 class="font-display font-bold text-2xl text-black mb-6">Our Winning Formula</h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 text-base md:text-lg font-bold">
                    <span class="bg-white/20 rounded-xl px-5 py-2.5 text-black">Smart Teaching</span>
                    <span class="text-xl text-black">+</span>
                    <span class="bg-white/20 rounded-xl px-5 py-2.5 text-black">Extra Practice</span>
                    <span class="text-xl text-black">+</span>
                    <span class="bg-white/20 rounded-xl px-5 py-2.5 text-   black">Personal Attention</span>
                </div>
                <p class="mt-6 text-black text-xl font-bold">= Big Results</p>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- PARENT COMMUNICATION --}}
    {{-- ============================================ --}}
    <section class="section-padding" style="background: #F0F8FF;">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-orange-coral text-sm font-bold tracking-widest uppercase mb-3">Parent Communication & Student Monitoring</p>
                <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-4">
                    Parents Are Important <span class="text-gradient-orange">Partners</span>
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
                        <div class="card-premium p-4 text-left flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: #059669;">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 text-sm font-medium">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="rounded-2xl p-6 border" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-color: #a7f3d0;">
                    <p class="font-display font-bold text-lg" style="color: #065f46;">Our Promise</p>
                    <p class="mt-1" style="color: #047857;">No child is left behind. Every student receives proper care and guidance.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- FINAL CTA --}}
    {{-- ============================================ --}}
    <section class="section-padding relative overflow-hidden" style="background: linear-gradient(160deg, #003B71 0%, #00264d 60%, #111 100%);">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(255,215,0,0.08) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full" style="background: radial-gradient(circle, rgba(227,30,36,0.08) 0%, transparent 70%);"></div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <h2 class="font-display font-bold text-3xl md:text-5xl text-white mb-5">
                Ready to See Your Child
                <span class="block mt-2" style="background: linear-gradient(135deg, #FFD700, #FFA500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Lead the Rank List?</span>
            </h2>
            <p class="text-white/70 text-lg max-w-xl mx-auto mb-2">
                Don't settle for average education.
            </p>
            <p class="text-white font-bold text-xl mb-10">
                Choose smart preparation. Choose success.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                <a href="tel:7206061212" class="btn-primary px-8 py-4 text-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Contact: 7206061212
                </a>
                <a href="{{ route('contact') }}" class="btn-white px-8 py-4 text-lg">
                    Enquire Online
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div>
                <p class="text-white/70 text-lg font-semibold">Talent Zone Academy</p>
                <p class="text-white/50 text-base mt-1">Success to Everyone</p>
            </div>
        </div>
    </section>

</x-public-layout>
