<x-layouts.admin>
    <x-slot name="title">Academic Sessions</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Academic Sessions</h1>
                <p class="mt-1 text-sm text-slate-600">Manage academic years and sessions</p>
            </div>
            <a href="{{ route('admin.academic-sessions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Academic Session
            </a>
        </div>

        <!-- Sessions List -->
        @if($sessions->isEmpty())
            <div class="card-premium p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-slate-900">No Academic Sessions</h3>
                <p class="mt-2 text-sm text-slate-600">Get started by creating your first academic session.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.academic-sessions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-all">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Academic Session
                    </a>
                </div>
            </div>
        @else
            <div class="card-premium divide-y divide-slate-200">
                @foreach($sessions as $session)
                    <div class="p-6 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $session->name }}</h3>
                                    @if($session->is_current)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-100 text-accent-800">
                                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Current Session
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 flex items-center gap-4 text-sm text-slate-600">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $session->start_date->format('M d, Y') }} - {{ $session->end_date->format('M d, Y') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $session->start_date->diffInDays($session->end_date) }} days
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                @if(!$session->is_current)
                                    <form method="POST" action="{{ route('admin.academic-sessions.toggle-current', $session) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border-2 border-accent-300 rounded-lg text-xs font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Set as Current
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.academic-sessions.edit', $session) }}" class="inline-flex items-center px-3 py-2 border-2 border-primary-300 rounded-lg text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>

                                @if(!$session->is_current)
                                    <form method="POST" action="{{ route('admin.academic-sessions.destroy', $session) }}" onsubmit="return confirm('Are you sure you want to delete this academic session?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border-2 border-red-300 rounded-lg text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 transition-all">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($sessions->hasPages())
                <div class="card-premium p-4">
                    {{ $sessions->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.admin>
