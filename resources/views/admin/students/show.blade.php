<x-layouts.admin>
    <x-slot name="title">{{ $student->name }}</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Student Details</h1>
                <p class="mt-1 text-sm text-slate-600">View complete student information</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.id-cards.student', $student) }}" class="inline-flex items-center px-4 py-2 border-2 border-primary-300 rounded-xl text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    Generate ID Card
                </a>
                <a href="{{ route('admin.students.edit', $student) }}" class="inline-flex items-center px-4 py-2 border-2 border-accent-300 rounded-xl text-sm font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Student
                </a>
                <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Students
                </a>
            </div>
        </div>

        <!-- Student Profile Card -->
        <div class="card-premium p-8">
            <div class="flex flex-col md:flex-row md:items-start md:space-x-8">
                <!-- Photo -->
                <div class="flex-shrink-0 mb-6 md:mb-0">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}" class="h-32 w-32 rounded-2xl object-cover border-4 border-primary-100 shadow-lg">
                    @else
                        <div class="h-32 w-32 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <!-- Basic Info -->
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $student->name }}</h2>
                            <p class="text-sm text-slate-600 mt-1">{{ $student->admission_no }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $student->status === 'active' ? 'bg-accent-100 text-accent-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Gender</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ ucfirst($student->gender) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Date of Birth</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ \Carbon\Carbon::parse($student->dob)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($student->dob)->age }} years)</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Class</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">Class {{ $student->class }}{{ $student->section ? ' - Section ' . $student->section : '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Roll Number</p>
                            <p class="text-sm font-medium text-slate-900 mt-1">{{ $student->roll_no ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Guardian Information -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Guardian Information
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Name</p>
                        <p class="text-sm font-medium text-slate-900 mt-1">{{ $student->guardian_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</p>
                        <p class="text-sm font-medium text-slate-900 mt-1">{{ $student->guardian_phone }}</p>
                    </div>
                    @if($student->address)
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Address</p>
                            <p class="text-sm text-slate-700 mt-1">{{ $student->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Fee Receipts -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/>
                    </svg>
                    Recent Fee Receipts
                </h3>
                @if($student->feeReceipts && $student->feeReceipts->count() > 0)
                    <div class="space-y-3">
                        @foreach($student->feeReceipts as $receipt)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $receipt->receipt_no }}</p>
                                    <p class="text-xs text-slate-500">{{ $receipt->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900">₹{{ number_format($receipt->amount, 2) }}</p>
                                    @if($receipt->cancelled)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-accent-100 text-accent-800">
                                            Paid
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-slate-500">No fee receipts yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
