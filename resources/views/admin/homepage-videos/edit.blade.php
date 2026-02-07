<x-layouts.admin>
    <x-slot name="title">Edit Video</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Video</h1>
                <p class="mt-1 text-sm text-slate-600">Update video details</p>
            </div>
            <a href="{{ route('admin.homepage-videos.index') }}" class="text-slate-600 hover:text-slate-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <div class="card-premium p-6">
            <!-- Current Video Preview -->
            @if($video->video_type !== 'local' && $video->embed_url)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Current Video</label>
                    <div class="aspect-video rounded-xl overflow-hidden bg-slate-100">
                        <iframe src="{{ $video->embed_url }}" class="w-full h-full" frameborder="0"
                            allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.homepage-videos.update', $video) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6"
                x-data="{ videoType: '{{ old('video_type', $video->video_type) }}' }">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter video title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Video Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="video_type" value="youtube" x-model="videoType"
                                class="text-primary-600">
                            <span class="ml-2 text-sm text-slate-700">YouTube</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="video_type" value="vimeo" x-model="videoType"
                                class="text-primary-600">
                            <span class="ml-2 text-sm text-slate-700">Vimeo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="video_type" value="local" x-model="videoType"
                                class="text-primary-600">
                            <span class="ml-2 text-sm text-slate-700">Local File</span>
                        </label>
                    </div>
                </div>

                <!-- URL Input (for YouTube/Vimeo) -->
                <div x-show="videoType !== 'local'">
                    <label for="video_url" class="block text-sm font-medium text-slate-700 mb-2">Video URL</label>
                    <input type="url" name="video_url" id="video_url"
                        value="{{ old('video_url', $video->video_type !== 'local' ? $video->video_url : '') }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="https://www.youtube.com/watch?v=...">
                    @error('video_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Input (for Local) -->
                <div x-show="videoType === 'local'">
                    <label for="video_file" class="block text-sm font-medium text-slate-700 mb-2">Replace Video
                        File</label>
                    <input type="file" name="video_file" id="video_file" accept="video/mp4,video/webm,video/mov"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <p class="mt-1 text-xs text-slate-500">Leave empty to keep current file</p>
                    @error('video_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-slate-700 mb-2">Custom Thumbnail
                        (Optional)</label>
                    @if($video->thumbnail_path)
                        <div class="mb-2">
                            <img src="{{ $video->thumbnail_url }}" alt="Current thumbnail" class="h-20 w-auto rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('admin.homepage-videos.index') }}"
                        class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl text-center hover:bg-slate-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-xl hover:bg-primary-700">
                        Update Video
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>