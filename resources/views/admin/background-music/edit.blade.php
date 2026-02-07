<x-layouts.admin>
    <x-slot name="title">Edit Music</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Music</h1>
                <p class="mt-1 text-sm text-slate-600">Update the music track details</p>
            </div>
            <a href="{{ route('admin.background-music.index') }}" class="text-slate-600 hover:text-slate-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <div class="card-premium p-6">
            <form action="{{ route('admin.background-music.update', $music) }}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $music->title) }}" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Enter track title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current File -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Current File</label>
                    <audio controls class="w-full">
                        <source src="{{ asset('uploads/music/' . $music->file_path) }}" type="audio/mpeg">
                    </audio>
                </div>

                <div>
                    <label for="audio_file" class="block text-sm font-medium text-slate-700 mb-2">Replace Audio
                        (Optional)</label>
                    <input type="file" name="audio_file" id="audio_file" accept="audio/mp3,audio/wav,audio/ogg"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <p class="mt-1 text-xs text-slate-500">Leave empty to keep current file. MP3, WAV, OGG up to 20MB
                    </p>
                    @error('audio_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('admin.background-music.index') }}"
                        class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl text-center hover:bg-slate-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-xl hover:bg-primary-700">
                        Update Music
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>