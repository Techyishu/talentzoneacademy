<x-layouts.admin>
    <x-slot name="title">Homepage Videos</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Homepage Videos</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage videos displayed on the homepage</p>
            </div>
            <a href="{{ route('admin.homepage-videos.create') }}"
                class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Add Video</span>
            </a>
        </div>

        <!-- Videos Grid -->
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($videos as $video)
                    <div class="card-premium overflow-hidden group">
                        <!-- Thumbnail -->
                        <div class="relative aspect-video bg-slate-100">
                            @if($video->thumbnail_url)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-200">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Type Badge -->
                            <div class="absolute top-2 left-2">
                                <span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-white/90 text-slate-700 capitalize">
                                    {{ $video->video_type }}
                                </span>
                            </div>
                            <!-- Play Icon Overlay -->
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-16 h-16 text-white/80" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-slate-900 truncate">{{ $video->title }}</h3>
                            <p class="mt-1 text-xs text-slate-500 truncate">{{ $video->video_url }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <!-- Active Toggle -->
                                <form action="{{ route('admin.homepage-videos.toggle-active', $video) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $video->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                        @if($video->is_active)
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                            Active
                                        @else
                                            <span class="w-2 h-2 bg-slate-400 rounded-full mr-2"></span>
                                            Inactive
                                        @endif
                                    </button>
                                </form>

                                <!-- Actions -->
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.homepage-videos.edit', $video) }}"
                                        class="p-1.5 bg-primary-50 text-primary-700 rounded-lg hover:bg-primary-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.homepage-videos.destroy', $video) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Delete this video?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card-premium p-8 sm:p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-slate-900">No videos added</h3>
                <p class="mt-1 text-xs text-slate-600">Add videos to display on the homepage</p>
                <a href="{{ route('admin.homepage-videos.create') }}"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg">
                    Add Video
                </a>
            </div>
        @endif
    </div>
</x-layouts.admin>