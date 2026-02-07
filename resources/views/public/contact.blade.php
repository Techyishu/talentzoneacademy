<x-public-layout>
    @php
        $schools = config('schools.schools');
    @endphp

    {{-- Page Header --}}
    <section class="relative py-24 bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-500/15 rounded-full filter blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        
        <div class="container-custom relative z-10 text-center">
            <span class="badge badge-glass mb-6">We're Here to Help</span>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-4">Contact Us</h1>
            <p class="text-slate-300 text-lg md:text-xl max-w-2xl mx-auto">
                Have questions about admissions? Looking for more information? We'd love to hear from you.
            </p>
        </div>
    </section>

    {{-- Contact Content --}}
    <section class="section-padding">
        <div class="container-custom">
            <div class="grid lg:grid-cols-5 gap-12">
                {{-- Contact Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-xl border border-slate-100">
                        <div class="mb-10">
                            <span class="badge badge-primary mb-4">Send us a Message</span>
                            <h2 class="font-display font-bold text-3xl text-slate-900 mb-2">Enquiry Form</h2>
                            <p class="text-slate-500">Fill in the form below and we'll get back to you within 24 hours.</p>
                        </div>
                        
                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Parent's Name *</label>
                                    <input type="text" placeholder="John Doe" 
                                        class="input-premium">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number *</label>
                                    <input type="tel" placeholder="+91 98765 43210" 
                                        class="input-premium">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address *</label>
                                <input type="email" placeholder="parent@example.com" 
                                    class="input-premium">
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Student's Name</label>
                                    <input type="text" placeholder="Jane Doe" 
                                        class="input-premium">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Grade Seeking *</label>
                                    <select class="input-premium appearance-none">
                                        <option value="">Select Grade</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">Grade {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Preferred Campus *</label>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach($schools as $school)
                                        @php
                                            $colorClass = match($school['color']) {
                                                'primary' => 'peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-700',
                                                'accent' => 'peer-checked:border-accent-500 peer-checked:bg-accent-50 peer-checked:text-accent-700',
                                                'warm' => 'peer-checked:border-warm-500 peer-checked:bg-warm-50 peer-checked:text-warm-700',
                                                default => 'peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-700',
                                            };
                                        @endphp
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="school" value="{{ $school['slug'] }}" class="peer sr-only">
                                            <div class="p-4 text-center rounded-xl border-2 border-slate-200 {{ $colorClass }} transition-all hover:border-slate-300">
                                                <span class="font-medium text-sm">{{ Str::after($school['name'], 'SchoolSuite ') }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
                                <textarea rows="4" placeholder="Tell us how we can help you..." 
                                    class="input-premium resize-none"></textarea>
                            </div>
                            
                            <button type="submit" class="btn-primary w-full py-4 text-base">
                                Send Enquiry
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Quick Contact --}}
                    <div class="bg-gradient-to-br from-primary-600 to-primary-700 p-8 rounded-3xl text-white">
                        <h3 class="font-display font-bold text-xl mb-6">Quick Contact</h3>
                        <div class="space-y-4">
                            <a href="tel:{{ config('schools.organization.phone') }}" 
                               class="flex items-center gap-4 p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors group">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white/70 text-sm">Call Us</div>
                                    <div class="font-semibold">{{ config('schools.organization.phone') }}</div>
                                </div>
                            </a>
                            <a href="mailto:{{ config('schools.organization.email') }}" 
                               class="flex items-center gap-4 p-4 bg-white/10 rounded-xl hover:bg-white/20 transition-colors group">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-white/70 text-sm">Email Us</div>
                                    <div class="font-semibold">{{ config('schools.organization.email') }}</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Campus Locations --}}
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                        <h3 class="font-display font-bold text-xl text-slate-900 mb-6">Our Campuses</h3>
                        <div class="space-y-4">
                            @foreach($schools as $school)
                                @php
                                    $dotColor = match($school['color']) {
                                        'primary' => 'bg-primary-500',
                                        'accent' => 'bg-accent-500',
                                        'warm' => 'bg-warm-500',
                                        default => 'bg-primary-500',
                                    };
                                @endphp
                                <a href="{{ route('schools.show', $school['slug']) }}" 
                                   class="block p-4 rounded-xl hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-start gap-4">
                                        <div class="w-3 h-3 {{ $dotColor }} rounded-full mt-1.5 flex-shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-slate-900 group-hover:text-primary-600 transition-colors">
                                                {{ Str::after($school['name'], 'SchoolSuite ') }}
                                            </div>
                                            <div class="text-slate-500 text-sm mt-1">{{ $school['address'] }}</div>
                                            <div class="flex items-center gap-4 mt-2 text-sm">
                                                <span class="text-slate-600">{{ $school['phone'] }}</span>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Office Hours --}}
                    <div class="bg-slate-50 p-8 rounded-3xl">
                        <h3 class="font-display font-bold text-xl text-slate-900 mb-4">Office Hours</h3>
                        <div class="space-y-3 text-slate-600">
                            <div class="flex justify-between">
                                <span>Monday - Friday</span>
                                <span class="font-semibold text-slate-900">8:00 AM - 4:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Saturday</span>
                                <span class="font-semibold text-slate-900">9:00 AM - 1:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sunday</span>
                                <span class="text-slate-400">Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Section --}}
    <section class="py-16 bg-slate-50">
        <div class="container-custom">
            <div class="text-center mb-12">
                <span class="badge badge-primary mb-4">Find Us</span>
                <h2 class="font-display font-bold text-3xl text-slate-900">Visit Our Campuses</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                @foreach($schools as $school)
                    @php
                        $borderColor = match($school['color']) {
                            'primary' => 'border-primary-300 hover:border-primary-400',
                            'accent' => 'border-accent-300 hover:border-accent-400',
                            'warm' => 'border-warm-300 hover:border-warm-400',
                            default => 'border-primary-300 hover:border-primary-400',
                        };
                        $textColor = match($school['color']) {
                            'primary' => 'text-primary-600',
                            'accent' => 'text-accent-600',
                            'warm' => 'text-warm-600',
                            default => 'text-primary-600',
                        };
                    @endphp
                    <div class="bg-white p-6 rounded-2xl border-2 {{ $borderColor }} transition-colors">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-3 h-3 rounded-full {{ str_replace('text', 'bg', $textColor) }}"></div>
                            <h3 class="font-semibold text-slate-900">{{ Str::after($school['name'], 'SchoolSuite ') }}</h3>
                        </div>
                        <p class="text-slate-600 text-sm mb-4">{{ $school['address'] }}</p>
                        <a href="#" class="inline-flex items-center gap-2 {{ $textColor }} font-medium text-sm hover:underline">
                            Get Directions
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="aspect-video bg-slate-200 rounded-3xl flex items-center justify-center">
                <div class="text-center text-slate-400">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <p class="text-lg font-medium">Interactive Map Coming Soon</p>
                    <p class="text-sm">All three campus locations</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section-padding">
        <div class="container-custom max-w-4xl">
            <x-public.section-heading 
                eyebrow="FAQ"
                title="Frequently Asked Questions"
                subtitle="Quick answers to common questions about admissions and our schools."
            />

            <div class="space-y-4" x-data="{ openFaq: null }">
                @foreach([
                    ['q' => 'What is the admission process?', 'a' => 'Our admission process includes registration, entrance assessment, parent interview, and document verification. The process typically takes 2-3 weeks from application to confirmation.'],
                    ['q' => 'What curriculum do you follow?', 'a' => 'We follow the CBSE curriculum across all our campuses, supplemented with innovative teaching methodologies and holistic development programs.'],
                    ['q' => 'Is transportation available?', 'a' => 'Yes, we provide GPS-enabled bus transport across the city with trained drivers and attendants. Routes cover most major residential areas.'],
                    ['q' => 'What extra-curricular activities are offered?', 'a' => 'We offer a wide range including sports, music, dance, drama, art, debate, robotics, yoga, and more. Students can choose activities based on their interests.'],
                ] as $index => $faq)
                    <div class="border border-slate-200 rounded-2xl overflow-hidden">
                        <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between p-6 text-left bg-white hover:bg-slate-50 transition-colors">
                            <span class="font-semibold text-slate-900">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" 
                                 :class="openFaq === {{ $index }} && 'rotate-180'"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaq === {{ $index }}" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="px-6 pb-6 text-slate-600">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-public-layout>