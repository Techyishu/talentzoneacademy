<x-layouts.admin>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Page</h1>
                <p class="mt-1 text-sm text-gray-600">Update page content and settings</p>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Page Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title', $page->title) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Slug
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            /
                        </span>
                        <input
                            type="text"
                            name="slug"
                            id="slug"
                            value="{{ old('slug', $page->slug) }}"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror"
                        >
                    </div>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Only lowercase letters, numbers, and hyphens. Changing this will break existing links.</p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Page Content <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="content"
                        id="content"
                        rows="16"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm @error('content') border-red-500 @enderror"
                    >{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">HTML and markdown supported. Use standard HTML tags for formatting.</p>
                </div>

                <!-- Meta Description -->
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Description (SEO)
                    </label>
                    <textarea
                        name="meta_description"
                        id="meta_description"
                        rows="2"
                        maxlength="160"
                        x-data="{ count: {{ strlen(old('meta_description', $page->meta_description ?? '')) }} }"
                        x-init="$watch('count', value => count = value)"
                        @input="count = $event.target.value.length"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('meta_description') border-red-500 @enderror"
                    >{{ old('meta_description', $page->meta_description) }}</textarea>
                    <div class="flex justify-between mt-1">
                        <p class="text-xs text-gray-500">Brief description for search engines</p>
                        <p class="text-xs text-gray-500" x-text="count + '/160'"></p>
                    </div>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        id="status"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror"
                    >
                        <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Only published pages are visible on your public website</p>
                </div>

                <!-- Metadata -->
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600 space-y-1">
                    <p><span class="font-medium">Created:</span> {{ $page->created_at->format('M d, Y \a\t g:i A') }}</p>
                    <p><span class="font-medium">Last Updated:</span> {{ $page->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between">
                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-150">
                        Delete Page
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('admin.pages.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                        Update Page
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
