<x-layouts.admin>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.contact-submissions.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Contact Submission</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ $contactSubmission->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.contact-submissions.destroy', $contactSubmission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-150">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Submission Details -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $contactSubmission->subject }}</h2>
                    @if($contactSubmission->is_read)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            Read
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            Unread
                        </span>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Name</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $contactSubmission->name }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Email</div>
                            <a href="mailto:{{ $contactSubmission->email }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 mt-1 block">
                                {{ $contactSubmission->email }}
                            </a>
                        </div>
                    </div>

                    @if($contactSubmission->phone)
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">Phone</div>
                                <a href="tel:{{ $contactSubmission->phone }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 mt-1 block">
                                    {{ $contactSubmission->phone }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Received</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">
                                {{ $contactSubmission->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $contactSubmission->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="px-6 py-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Message</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $contactSubmission->message }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                <a
                    href="mailto:{{ $contactSubmission->email }}?subject=Re: {{ $contactSubmission->subject }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Reply via Email
                </a>

                @if($contactSubmission->phone)
                    <a
                        href="tel:{{ $contactSubmission->phone }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-150"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call {{ $contactSubmission->name }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
