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
</head>

<body class="font-sans antialiased text-slate-900" style="background-color: #F0F8FF;">
    {{-- Navbar --}}
    @include('components.public.navbar')

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('components.public.footer')

    {{-- Background Music Player --}}
    @php
        $activeMusic = \App\Models\BackgroundMusic::active()->first();
    @endphp
    @if($activeMusic)
        <div x-data="{ isPlaying: false, showPlayer: true, volume: 0.3 }" class="fixed bottom-4 left-4 z-50" x-cloak>
            <div x-show="showPlayer" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div
                    class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-xl border border-slate-200 p-4 flex items-center gap-3 min-w-[200px]">
                    {{-- Play/Pause Button --}}
                    <button @click="
                        const audio = $refs.bgAudio;
                        if (isPlaying) {
                            audio.pause();
                        } else {
                            audio.volume = volume;
                            audio.play();
                        }
                        isPlaying = !isPlaying;
                    " class="w-10 h-10 rounded-full flex items-center justify-center transition-all"
                        :class="isPlaying ? 'bg-primary-100 text-primary-600' : 'bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-600'">
                        <template x-if="!isPlaying">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                            </svg>
                        </template>
                        <template x-if="isPlaying">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zm7 0a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z" />
                            </svg>
                        </template>
                    </button>

                    {{-- Track Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-500">Now Playing</p>
                        <p class="text-sm font-medium text-slate-900 truncate">{{ $activeMusic->title }}</p>
                    </div>

                    {{-- Close Button --}}
                    <button @click="
                        $refs.bgAudio.pause();
                        isPlaying = false;
                        showPlayer = false;
                    " class="text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Hidden Audio Element --}}
                    <audio x-ref="bgAudio" loop preload="metadata">
                        <source src="{{ $activeMusic->file_url }}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
        </div>
    @endif
</body>

</html>