<x-layouts.student>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="card-premium p-6">
            <div class="flex items-center">
                @if($student->photo)
                    <img src="{{ asset('uploads/photos/' . $student->photo) }}" alt="{{ $student->name }}"
                        class="h-16 w-16 rounded-full object-cover">
                @else
                    <div
                        class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                @endif
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-slate-900">Welcome, {{ $student->name }}</h1>
                    <p class="text-slate-600">{{ $student->schoolClass?->name ?? $student->class }}
                        {{ $student->schoolSection ? '- ' . $student->schoolSection->name : '' }} •
                        {{ $student->admission_no }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card-premium p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Fee Paid</p>
                        <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalPaid, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-100">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Attendance Rate</p>
                        <p
                            class="text-2xl font-bold {{ $attendancePercentage >= 75 ? 'text-green-600' : ($attendancePercentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $attendancePercentage }}%</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-100">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Receipts</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $recentReceipts->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats -->
        <div>
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Attendance -
                {{ date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Present</p>
                    <p class="text-2xl font-bold text-green-600">{{ $attendanceStats['present'] }}</p>
                </div>
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Absent</p>
                    <p class="text-2xl font-bold text-red-600">{{ $attendanceStats['absent'] }}</p>
                </div>
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Late</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $attendanceStats['late'] }}</p>
                </div>
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Leave</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $attendanceStats['leave'] }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Receipts -->
        <div>
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Recent Fee Receipts</h2>
            <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Receipt #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Amount</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentReceipts as $receipt)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $receipt->receipt_number }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $receipt->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-green-600">
                                    ₹{{ number_format($receipt->amount, 2) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('student.fees.download', $receipt) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">No fee receipts yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recentReceipts->count() > 0)
                <div class="mt-4 text-right">
                    <a href="{{ route('student.fees') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View
                        All Receipts →</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.student>