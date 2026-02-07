<x-layouts.admin>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Welcome Section -->
    <div class="mb-4 sm:mb-8">
        <h1 class="text-xl sm:text-3xl font-bold text-slate-900 font-heading">
            Welcome back, {{ auth()->user()->name }}! 👋
        </h1>
        <p class="mt-1 sm:mt-2 text-sm text-slate-600">
            @if($activeSchool)
                Managing <span class="font-semibold text-primary-600">{{ $activeSchool->name }}</span>
            @else
                Here's what's happening with your schools today.
            @endif
        </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4 mb-4 sm:mb-8">
        <!-- Total Students -->
        <div class="card-premium p-3 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600">Students</p>
                    <p class="mt-1 sm:mt-2 text-xl sm:text-3xl font-bold text-slate-900">{{ number_format($totalStudents) }}</p>
                </div>
                <div class="rounded-lg sm:rounded-xl bg-primary-100 p-2 sm:p-3">
                    <svg class="h-5 w-5 sm:h-8 sm:w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="card-premium p-3 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600">Staff</p>
                    <p class="mt-1 sm:mt-2 text-xl sm:text-3xl font-bold text-slate-900">{{ number_format($totalStaff) }}</p>
                </div>
                <div class="rounded-lg sm:rounded-xl bg-accent-100 p-2 sm:p-3">
                    <svg class="h-5 w-5 sm:h-8 sm:w-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Monthly Receipts -->
        <div class="card-premium p-3 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-600">This Month</p>
                    <p class="mt-1 sm:mt-2 text-xl sm:text-3xl font-bold text-slate-900">{{ number_format($pendingReceipts) }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 sm:mt-1">Receipts</p>
                </div>
                <div class="rounded-lg sm:rounded-xl bg-warm-100 p-2 sm:p-3">
                    <svg class="h-5 w-5 sm:h-8 sm:w-8 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Schools (Super Admin Only) -->
        @if($totalSchools !== null)
            <div class="card-premium p-3 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-slate-600">Schools</p>
                        <p class="mt-1 sm:mt-2 text-xl sm:text-3xl font-bold text-slate-900">{{ $totalSchools }}</p>
                    </div>
                    <div class="rounded-lg sm:rounded-xl bg-purple-100 p-2 sm:p-3">
                        <svg class="h-5 w-5 sm:h-8 sm:w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @else
            <!-- Quick Actions for School Admin -->
            <div class="card-premium p-3 sm:p-6 flex items-center justify-center">
                <a href="{{ route('admin.students.create') }}" class="inline-flex items-center px-3 py-1.5 text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 rounded-lg shadow-lg">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Student
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2">
        <!-- Quick Actions -->
        <div class="card-premium p-4 sm:p-6">
            <h2 class="text-sm sm:text-lg font-semibold text-slate-900 mb-3 sm:mb-4">Quick Actions</h2>
            <div class="space-y-2 sm:space-y-3">
                <a href="{{ route('admin.students.create') }}" class="flex items-center justify-between p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50 hover:bg-primary-50 hover:border-primary-200 border border-transparent transition-all group">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="rounded-lg bg-primary-100 p-1.5 sm:p-2 group-hover:bg-primary-200 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Add New Student</p>
                            <p class="text-xs text-slate-500 hidden sm:block">Register a new student</p>
                        </div>
                    </div>
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.fee-receipts.create') }}" class="flex items-center justify-between p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50 hover:bg-accent-50 hover:border-accent-200 border border-transparent transition-all group">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="rounded-lg bg-accent-100 p-1.5 sm:p-2 group-hover:bg-accent-200 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Create Fee Receipt</p>
                            <p class="text-xs text-slate-500 hidden sm:block">Generate new receipt</p>
                        </div>
                    </div>
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400 group-hover:text-accent-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="{{ route('admin.gallery.create') }}" class="flex items-center justify-between p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50 hover:bg-warm-50 hover:border-warm-200 border border-transparent transition-all group">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="rounded-lg bg-warm-100 p-1.5 sm:p-2 group-hover:bg-warm-200 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Upload Gallery</p>
                            <p class="text-xs text-slate-500 hidden sm:block">Add to school gallery</p>
                        </div>
                    </div>
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400 group-hover:text-warm-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Fee Receipts -->
        <div class="card-premium p-4 sm:p-6">
            <h2 class="text-sm sm:text-lg font-semibold text-slate-900 mb-3 sm:mb-4">Recent Fee Receipts</h2>
            @if($recentReceipts->count() > 0)
                <div class="space-y-2 sm:space-y-3">
                    @foreach($recentReceipts as $receipt)
                        <div class="flex items-center justify-between p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50">
                            <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                                <div class="rounded-lg bg-{{ $receipt->cancelled ? 'red' : 'green' }}-100 p-1.5 sm:p-2 flex-shrink-0">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-{{ $receipt->cancelled ? 'red' : 'green' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $receipt->student->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $receipt->receipt_no }} • ₹{{ number_format($receipt->amount, 0) }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-2">
                                <p class="text-xs sm:text-sm font-medium text-slate-900">{{ $receipt->created_at->format('M d') }}</p>
                                @if($receipt->cancelled)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 sm:mt-4">
                    <a href="{{ route('admin.fee-receipts.index') }}" class="text-xs sm:text-sm font-medium text-primary-600 hover:text-primary-700">
                        View all receipts →
                    </a>
                </div>
            @else
                <div class="text-center py-6 sm:py-8">
                    <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-slate-500">No recent receipts</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
