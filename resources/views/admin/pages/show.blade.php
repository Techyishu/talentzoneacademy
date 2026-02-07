<x-layouts.admin>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.pages.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Page preview and details</p>
                </div>
            </div>
            <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Page
            </a>
        </div>

        <!-- Page Info -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Slug</label>
                    <code class="text-sm bg-gray-100 px-3 py-2 rounded block text-gray-700">/{{ $page->slug }}</code>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div>
                        @if($page->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                Draft
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($page->meta_description)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <p class="text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded">{{ $page->meta_description }}</p>
                </div>
            @endif

            <div class="pt-4 border-t border-gray-200 text-sm text-gray-600 space-y-1">
                <p><span class="font-medium">Created:</span> {{ $page->created_at->format('M d, Y \a\t g:i A') }}</p>
                <p><span class="font-medium">Last Updated:</span> {{ $page->updated_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
        </div>

        <!-- Content Preview -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Content Preview</h2>
            <div class="prose prose-indigo max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-layouts.admin>
