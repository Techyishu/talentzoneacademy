<x-layouts.admin>
    <x-slot name="title">Background Music</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Background Music</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage music that plays on the public website</p>
            </div>
            <a href="{{ route('admin.background-music.create') }}"
                class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Add Music</span>
            </a>
        </div>

        <!-- Music List -->
        @if($music->count() > 0)
            <div class="card-premium overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Preview</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($music as $track)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-primary-100 rounded-lg">
                                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-slate-900">{{ $track->title }}</div>
                                                <div class="text-xs text-slate-500">{{ $track->file_path }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <audio controls class="h-8 w-48">
                                            <source src="{{ asset('uploads/music/' . $track->file_path) }}" type="audio/mpeg">
                                        </audio>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.background-music.toggle-active', $track) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $track->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                                @if($track->is_active)
                                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                                    Active
                                                @else
                                                    <span class="w-2 h-2 bg-slate-400 rounded-full mr-2"></span>
                                                    Inactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.background-music.edit', $track) }}"
                                                class="px-3 py-1.5 bg-primary-50 text-primary-700 text-xs font-medium rounded-lg hover:bg-primary-100">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.background-music.destroy', $track) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Delete this track?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card-premium p-8 sm:p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-slate-900">No music added</h3>
                <p class="mt-1 text-xs text-slate-600">Add background music for the public website</p>
                <a href="{{ route('admin.background-music.create') }}"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg">
                    Add Music
                </a>
            </div>
        @endif
    </div>
</x-layouts.admin>