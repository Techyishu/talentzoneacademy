<x-layouts.admin>
    <x-slot name="title">Public Reviews</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Public Reviews</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage reviews displayed on the public website</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="card-premium p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.public-reviews.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    All ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.public-reviews.index', ['status' => 'pending']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'pending' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    Pending ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.public-reviews.index', ['status' => 'approved']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'approved' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                    Approved ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.public-reviews.index', ['status' => 'rejected']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'rejected' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                    Rejected ({{ $counts['rejected'] }})
                </a>
            </div>
        </div>

        <!-- Reviews List -->
        @if($reviews->count() > 0)
            <div class="card-premium overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Reviewer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Review</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Rating</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Date</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($reviews as $review)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="font-medium text-slate-900">{{ $review->reviewer_name }}</div>
                                        @if($review->reviewer_email)
                                            <div class="text-xs text-slate-500">{{ $review->reviewer_email }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-slate-700 max-w-md truncate">{{ Str::limit($review->content, 100) }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($review->status === 'pending')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Pending</span>
                                        @elseif($review->status === 'approved')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Approved</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-500">
                                        {{ $review->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($review->status !== 'approved')
                                                <form action="{{ route('admin.public-reviews.approve', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded-lg hover:bg-green-100">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif
                                            @if($review->status !== 'rejected')
                                                <form action="{{ route('admin.public-reviews.reject', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.public-reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
            <div class="mt-4">{{ $reviews->links() }}</div>
        @else
            <div class="card-premium p-8 sm:p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-slate-900">No reviews found</h3>
                <p class="mt-1 text-xs text-slate-600">Reviews submitted by visitors will appear here</p>
            </div>
        @endif
    </div>
</x-layouts.admin>
