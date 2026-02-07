<x-public-layout>
    @php
        $leadership = config('schools.leadership');
    @endphp

    {{-- Page Header --}}
    <section class="relative py-24 bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-500/15 rounded-full filter blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 50px 50px;">
            </div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span class="badge badge-glass mb-6">Our Team</span>
            <h1 class="font-display font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-4">Meet Our Educators</h1>
            <p class="text-slate-300 text-lg md:text-xl max-w-2xl mx-auto">
                Meet the dedicated educators and administrators who make our schools a center of excellence.
            </p>
        </div>
    </section>

    {{-- Leadership Section --}}
    <section class="section-padding">
        <div class="container-custom">
            <x-public.section-heading title="Leadership Team"
                subtitle="Visionaries guiding our mission of educational excellence." />

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($leadership as $leader)
                    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm text-center">
                        <div
                            class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <span class="text-primary-600 font-bold text-4xl">{{ substr($leader['name'], 0, 1) }}</span>
                        </div>
                        <h3 class="font-display font-bold text-xl text-slate-900 mb-1">{{ $leader['name'] }}</h3>
                        <p class="text-primary-600 font-medium mb-4">{{ $leader['role'] }}</p>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $leader['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Staff Section --}}
    <section class="section-padding bg-slate-50">
        <div class="container-custom">
            <x-public.section-heading title="Our Educators"
                subtitle="Meet the dedicated team working across our campuses." />

            @if($staffBySchool->count() > 0)
                @foreach($staffBySchool as $schoolId => $staffMembers)
                    @php
                        $school = $schools[$schoolId] ?? null;
                    @endphp

                    @if($school)
                        <div class="mb-12">
                            <h3 class="text-2xl font-bold text-slate-800 mb-6 pb-3 border-b-2 border-primary-500">
                                {{ $school->name }}
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                                @foreach($staffMembers as $staff)
                                    <div
                                        class="bg-white rounded-xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                                        <div
                                            class="aspect-square bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center overflow-hidden">
                                            @if($staff->photo)
                                                <img src="{{ asset('storage/' . $staff->photo) }}" alt="{{ $staff->name }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center shadow-sm">
                                                    <span class="text-3xl font-bold text-primary-600">
                                                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4 text-center">
                                            <h4 class="font-semibold text-slate-900 truncate">{{ $staff->name }}</h4>
                                            <p class="text-sm text-primary-600 font-medium">{{ $staff->designation }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-slate-500">Staff profiles coming soon.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Join Our Team CTA --}}
    <section class="section-padding">
        <div class="container-custom">
            <div class="text-center">
                <p class="text-slate-600 mb-4">Join our growing team of passionate educators.</p>
                <a href="{{ route('contact') }}" class="btn-secondary">
                    Career Opportunities
                </a>
            </div>
        </div>
    </section>
</x-public-layout>