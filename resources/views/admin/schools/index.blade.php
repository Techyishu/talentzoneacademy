<x-layouts.admin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Schools Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage all schools in the system</p>
            </div>
            <a href="{{ route('admin.schools.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add School
            </a>
        </div>

        <!-- Schools Grid -->
        @if($schools->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schools as $school)
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Header with Logo -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                @if($school->logo)
                                    <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }}" class="w-16 h-16 object-contain bg-white rounded-lg p-2 shadow-sm">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-2xl shadow-sm">
                                        {{ substr($school->code, 0, 2) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-900 truncate">{{ $school->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $school->code }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-indigo-600">{{ $school->students_count }}</div>
                                    <div class="text-xs text-gray-600">Students</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-emerald-600">{{ $school->staff_count }}</div>
                                    <div class="text-xs text-gray-600">Staff</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-amber-600">{{ $school->users_count }}</div>
                                    <div class="text-xs text-gray-600">Users</div>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="px-6 py-4 space-y-2 text-sm">
                            @if($school->email)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate">{{ $school->email }}</span>
                                </div>
                            @endif
                            @if($school->phone)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $school->phone }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-2 pt-2">
                                <span class="text-xs font-medium text-gray-600">Receipt Prefix:</span>
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono">{{ $school->receipt_prefix }}</code>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-2">
                            <a href="{{ route('admin.schools.show', $school) }}" class="flex-1 text-center px-3 py-2 bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-150">
                                View
                            </a>
                            <a href="{{ route('admin.schools.edit', $school) }}" class="flex-1 text-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                Edit
                            </a>
                            <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will delete ALL data for this school including students, staff, and receipts. This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">No schools yet</h3>
                <p class="mt-2 text-sm text-gray-600">Get started by adding your first school to the system.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.schools.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add School
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin>
