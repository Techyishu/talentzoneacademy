<x-layouts.admin>
    <x-slot name="title">Gallery</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Gallery</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage school gallery images</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}"
                class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Upload</span>
            </a>
        </div>

        <!-- Filters -->
        <div class="card-premium p-4">
            <form method="GET" action="{{ route('admin.gallery.index') }}" class="flex flex-wrap gap-2 sm:gap-4">
                <div class="flex-1 min-w-[120px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                </div>
                <div class="w-32 sm:w-40">
                    <select name="category" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                        <option value="">All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-3 py-2 bg-slate-800 text-white text-xs font-medium rounded-lg">Filter</button>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('admin.gallery.index') }}"
                            class="px-3 py-2 bg-slate-200 text-slate-700 text-xs font-medium rounded-lg">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Gallery Grid -->
        @if($images->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($images as $image)
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden group hover:shadow-lg transition-shadow">
                        <div class="aspect-square bg-slate-100 relative overflow-hidden">
                            <img src="{{ asset('storage/' . $image->thumbnail_path) }}" alt="{{ $image->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-2 left-2">
                                <span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-white/90 text-slate-700">{{ $image->category }}</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $image->title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $image->created_at->format('M d, Y') }}</p>
                            <div class="flex gap-2 mt-2 sm:mt-3">
                                <a href="{{ route('admin.gallery.edit', $image) }}"
                                    class="flex-1 inline-flex items-center justify-center px-2 py-1.5 bg-primary-50 text-primary-700 text-xs font-medium rounded-lg">Edit</a>
                                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete image?');">@csrf @method('DELETE')<button
                                        class="px-2 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg"><svg
                                            class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg></button></form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $images->links() }}</div>
        @else
            <div class="bg-white rounded-xl border p-8 sm:p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-slate-900">No images found</h3>
                <p class="mt-1 text-xs text-slate-600">Get started by uploading images</p>
                <a href="{{ route('admin.gallery.create') }}"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg">Upload
                    Images</a>
            </div>
        @endif
    </div>
</x-layouts.admin>