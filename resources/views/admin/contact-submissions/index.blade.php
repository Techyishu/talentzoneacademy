<x-layouts.admin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Contact Submissions</h1>
                <p class="mt-1 text-sm text-gray-600">Manage inquiries and messages from your website</p>
            </div>
            @if($unreadCount > 0)
                <div class="px-4 py-2 bg-amber-100 border border-amber-300 text-amber-800 rounded-lg">
                    <span class="font-semibold">{{ $unreadCount }}</span> unread {{ Str::plural('message', $unreadCount) }}
                </div>
            @endif
        </div>

        <!-- Filters -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name, email, or subject..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>

                <div class="w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">All Messages</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors duration-150">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.contact-submissions.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-150">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Submissions List -->
        @if($submissions->count() > 0)
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 {{ !$submission->is_read ? 'bg-blue-50/30' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if(!$submission->is_read)
                                            <div class="w-2 h-2 bg-blue-600 rounded-full mr-3"></div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $submission->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $submission->email }}</div>
                                            @if($submission->phone)
                                                <div class="text-sm text-gray-500">{{ $submission->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $submission->subject }}</div>
                                    <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($submission->message, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $submission->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">{{ $submission->created_at->format('g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Read
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Unread
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View
                                    </a>
                                    <form action="{{ route('admin.contact-submissions.destroy', $submission) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">No contact submissions</h3>
                <p class="mt-2 text-sm text-gray-600">
                    @if(request()->hasAny(['search', 'status']))
                        No submissions match your filters. Try adjusting your search criteria.
                    @else
                        Contact form submissions from your website will appear here.
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-layouts.admin>
