<x-layouts.admin>
    <x-slot name="title">{{ $staff->name }}</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Staff Details</h1>
                <p class="mt-1 text-sm text-slate-600">View complete staff member information</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.id-cards.staff', $staff) }}" class="inline-flex items-center px-4 py-2 border-2 border-primary-300 rounded-xl text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    Generate ID Card
                </a>
                <a href="{{ route('admin.staff.edit', $staff) }}" class="inline-flex items-center px-4 py-2 border-2 border-accent-300 rounded-xl text-sm font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Staff
                </a>
                <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Staff
                </a>
            </div>
        </div>

        <!-- Staff Profile Card -->
        <div class="card-premium p-8">
            <div class="flex flex-col md:flex-row md:items-start md:space-x-8">
                <!-- Photo -->
                <div class="flex-shrink-0 mb-6 md:mb-0">
                    @if($staff->photo)
                        <img src="{{ asset('storage/' . $staff->photo) }}" alt="{{ $staff->name }}" class="h-32 w-32 rounded-2xl object-cover border-4 border-accent-100 shadow-lg">
                    @else
                        <div class="h-32 w-32 rounded-2xl bg-gradient-to-br from-accent-400 to-accent-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                            {{ strtoupper(substr($staff->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <!-- Basic Info -->
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $staff->name }}</h2>
                            <p class="text-sm text-slate-600 mt-1">{{ $staff->staff_code }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $staff->status === 'active' ? 'bg-accent-100 text-accent-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Designation</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $staff->designation }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $staff->phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Joining Date</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ \Carbon\Carbon::parse($staff->joining_date)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($staff->joining_date)->diffForHumans() }})</p>
                        </div>
                        @if($staff->salary)
                            <div>
                                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Monthly Salary</p>
                                <p class="text-sm font-medium text-slate-900 mt-1">₹{{ number_format($staff->salary, 2) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Employment Details -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Employment Details
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Years of Service</p>
                            <p class="text-lg font-bold text-slate-900 mt-0.5">
                                {{ \Carbon\Carbon::parse($staff->joining_date)->diffInYears(now()) }} years
                            </p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-accent-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Employment Status</p>
                            <p class="text-lg font-bold text-slate-900 mt-0.5">{{ ucfirst($staff->status) }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg {{ $staff->status === 'active' ? 'bg-accent-100' : 'bg-slate-200' }} flex items-center justify-center">
                            <svg class="h-6 w-6 {{ $staff->status === 'active' ? 'text-accent-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Quick Stats
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Staff Code</p>
                            <p class="text-lg font-bold text-slate-900 mt-0.5">{{ $staff->staff_code }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-primary-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50">
                        <div>
                            <p class="text-xs font-medium text-slate-500">Contact</p>
                            <p class="text-lg font-bold text-slate-900 mt-0.5">{{ $staff->phone }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-warm-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
