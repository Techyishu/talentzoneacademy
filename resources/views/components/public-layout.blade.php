<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>{{ $title ?? config('schools.organization.name') }}</title>
    <meta name="description" content="{{ $description ?? config('schools.organization.tagline') }}">

    {{-- OG Tags --}}
    <meta property="og:title" content="{{ $title ?? config('schools.organization.name') }}">
    <meta property="og:description" content="{{ $description ?? config('schools.organization.tagline') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .welcome-screen {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 30%, #0f3460 70%, #1a1a2e 100%);
        }

        .welcome-logo {
            animation: floatLogo 3s ease-in-out infinite;
        }

        @keyframes floatLogo {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .welcome-enter-btn {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C61 100%);
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.4), 0 0 60px rgba(255, 107, 53, 0.1);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 30px rgba(255, 107, 53, 0.4), 0 0 60px rgba(255, 107, 53, 0.1);
            }

            50% {
                box-shadow: 0 0 40px rgba(255, 107, 53, 0.6), 0 0 80px rgba(255, 107, 53, 0.2);
            }
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            animation: floatParticle linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.15;
            }

            90% {
                opacity: 0.15;
            }

            100% {
                transform: translateY(-10vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>

@php
    $activeMusic = \App\Models\BackgroundMusic::active()->first();
@endphp

<body class="font-sans antialiased text-slate-900" style="background-color: #F0F8FF;" x-data="{
        entered: false,
        musicPlaying: false,
        showPlayer: true,
        volume: 0.3,
        init() {
            if (sessionStorage.getItem('tz_entered')) {
                this.entered = true;
            }
        },
        enterSite() {
            this.entered = true;
            sessionStorage.setItem('tz_entered', '1');
            this.$nextTick(() => {
                @if($activeMusic)
                    const audio = this.$refs.bgAudio;
                    if (audio) {
                        audio.volume = this.volume;
                        audio.play().then(() => {
                            this.musicPlaying = true;
                        }).catch(() => {});
                    }
                @endif
            });
        }
    }">

    {{-- Welcome Splash Screen --}}
    <div x-show="!entered" x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="welcome-screen fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden">

        {{-- Floating Particles --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle w-2 h-2 bg-orange-400" style="left: 10%; animation-duration: 8s; animation-delay: 0s;">
            </div>
            <div class="particle w-3 h-3 bg-yellow-300"
                style="left: 25%; animation-duration: 12s; animation-delay: 2s;"></div>
            <div class="particle w-1.5 h-1.5 bg-blue-400"
                style="left: 40%; animation-duration: 10s; animation-delay: 4s;"></div>
            <div class="particle w-2.5 h-2.5 bg-red-400"
                style="left: 55%; animation-duration: 9s; animation-delay: 1s;"></div>
            <div class="particle w-2 h-2 bg-green-400" style="left: 70%; animation-duration: 11s; animation-delay: 3s;">
            </div>
            <div class="particle w-3 h-3 bg-orange-300" style="left: 85%; animation-duration: 7s; animation-delay: 5s;">
            </div>
            <div class="particle w-1.5 h-1.5 bg-yellow-400"
                style="left: 15%; animation-duration: 13s; animation-delay: 6s;"></div>
            <div class="particle w-2 h-2 bg-blue-300" style="left: 60%; animation-duration: 14s; animation-delay: 7s;">
            </div>
        </div>

        {{-- Decorative Blurred Circles --}}
        <div class="absolute top-20 left-20 w-64 h-64 rounded-full opacity-5 bg-orange-400 blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 rounded-full opacity-5 bg-blue-400 blur-3xl"></div>

        {{-- Content --}}
        <div class="text-center px-6 relative z-10">
            {{-- Logo --}}
            <div class="welcome-logo mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                    class="w-28 h-28 md:w-36 md:h-36 mx-auto rounded-3xl shadow-2xl shadow-black/30 object-contain bg-white/10 backdrop-blur-sm p-3">
            </div>

            {{-- School Name --}}
            <h1 class="font-display font-bold text-3xl sm:text-4xl md:text-5xl text-white mb-3 tracking-tight">
                Talent Zone
                <span
                    class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-orange-400">Academy</span>
            </h1>

            {{-- Tagline --}}
            <p class="text-white/60 text-base sm:text-lg mb-10 max-w-md mx-auto font-light tracking-wide">
                Success to Everyone
            </p>

            {{-- Enter Button --}}
            <button @click="enterSite()"
                class="welcome-enter-btn group relative px-10 py-4 sm:px-14 sm:py-5 rounded-2xl text-white font-bold text-base sm:text-lg tracking-wide transition-all duration-300 hover:scale-105 active:scale-95">
                <span class="relative z-10 flex items-center gap-3 justify-center">
                    @if($activeMusic)
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                        </svg>
                    @endif
                    Enter Website
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </button>

            @if($activeMusic)
                <p class="text-white/30 text-xs mt-6 flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
                            clip-rule="evenodd" />
                    </svg>
                    Click to enter with background music
                </p>
            @endif
        </div>
    </div>

    {{-- Main Site Content --}}
    <div x-show="entered" x-cloak x-transition:enter="transition ease-out duration-500 delay-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

        {{-- Navbar --}}
        @include('components.public.navbar')

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('components.public.footer')
    </div>

    {{-- Background Music Player --}}
    @if($activeMusic)
        <div x-show="entered && showPlayer" x-cloak x-transition:enter="transition ease-out duration-500 delay-700"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed bottom-4 left-4 z-50">
            <div
                class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200 p-4 flex items-center gap-3 min-w-[200px]">
                {{-- Play/Pause Button --}}
                <button @click="
                        const audio = $refs.bgAudio;
                        if (musicPlaying) {
                            audio.pause();
                        } else {
                            audio.volume = volume;
                            audio.play();
                        }
                        musicPlaying = !musicPlaying;
                    " class="w-10 h-10 rounded-full flex items-center justify-center transition-all"
                    :class="musicPlaying ? 'bg-primary-100 text-primary-600' : 'bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-600'">
                    <template x-if="!musicPlaying">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                        </svg>
                    </template>
                    <template x-if="musicPlaying">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zm7 0a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z" />
                        </svg>
                    </template>
                </button>

                {{-- Track Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-slate-500" x-text="musicPlaying ? 'Now Playing' : 'Paused'"></p>
                    <p class="text-sm font-medium text-slate-900 truncate">{{ $activeMusic->title }}</p>
                </div>

                {{-- Close Button --}}
                <button @click="
                        $refs.bgAudio.pause();
                        musicPlaying = false;
                        showPlayer = false;
                    " class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Hidden Audio Element --}}
        <audio x-ref="bgAudio" loop preload="metadata">
            <source src="{{ $activeMusic->file_url }}" type="audio/mpeg">
        </audio>
    @endif
</body>

</html>