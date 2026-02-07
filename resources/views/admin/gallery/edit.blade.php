<x-layouts.admin>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.gallery.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Gallery Image</h1>
                <p class="mt-1 text-sm text-gray-600">Update image metadata and display settings</p>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <!-- Image Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <div class="max-w-md bg-gray-100 rounded-lg overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $gallery->image_path) }}"
                            alt="{{ $gallery->title }}"
                            class="w-full h-auto"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500">To replace this image, please delete it and upload a new one.</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $gallery->title) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="category"
                        id="category"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror"
                    >
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $gallery->category) == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Order
                    </label>
                    <input
                        type="number"
                        name="display_order"
                        id="display_order"
                        value="{{ old('display_order', $gallery->display_order) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('display_order') border-red-500 @enderror"
                    >
                    @error('display_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first in the gallery</p>
                </div>

                <!-- Metadata -->
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Uploaded:</span> {{ $gallery->created_at->format('M d, Y \a\t g:i A') }}</p>
                    <p><span class="font-medium">Last Updated:</span> {{ $gallery->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between">
                <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-150">
                        Delete Image
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('admin.gallery.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                        Update Image
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
