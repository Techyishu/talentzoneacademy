<x-layouts.parent>
    <x-slot name="title">{{ $student->name }}</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <a href="{{ route('parent.dashboard') }}"
                class="inline-flex items-center text-slate-600 hover:text-slate-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Student Info -->
        <div class="card-premium p-6">
            <div class="flex items-center">
                @if($student->photo)
                    <img src="{{ asset('uploads/photos/' . $student->photo) }}" alt="{{ $student->name }}"
                        class="h-20 w-20 rounded-full object-cover">
                @else
                    <div
                        class="h-20 w-20 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                @endif
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-slate-900">{{ $student->name }}</h1>
                    <p class="text-slate-600">{{ $student->schoolClass?->name ?? $student->class }}
                        {{ $student->schoolSection ? '- ' . $student->schoolSection->name : '' }}</p>
                    <p class="text-slate-500 text-sm">Admission No: {{ $student->admission_no }} | Roll No:
                        {{ $student->roll_no ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Attendance Section -->
            <div>
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Attendance -
                    {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</h2>

                <!-- Month Filter -->
                <div class="card-premium p-4 mb-4">
                    <form method="GET" action="{{ route('parent.children.show', $student) }}"
                        class="flex flex-wrap items-end gap-3">
                        <div class="flex-1">
                            <select name="month" class="block w-full rounded-lg border-slate-300 shadow-sm text-sm">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="year" class="block w-full rounded-lg border-slate-300 shadow-sm text-sm">
                                @foreach(range(now()->year, now()->year - 2) as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700">Filter</button>
                    </form>
                </div>

                <!-- Attendance Stats -->
                <div class="grid grid-cols-4 gap-3 mb-4">
                    <div class="card-premium p-3 text-center">
                        <p class="text-xs text-slate-500">Present</p>
                        <p class="text-xl font-bold text-green-600">{{ $attendanceStats['present'] }}</p>
                    </div>
                    <div class="card-premium p-3 text-center">
                        <p class="text-xs text-slate-500">Absent</p>
                        <p class="text-xl font-bold text-red-600">{{ $attendanceStats['absent'] }}</p>
                    </div>
                    <div class="card-premium p-3 text-center">
                        <p class="text-xs text-slate-500">Late</p>
                        <p class="text-xl font-bold text-yellow-600">{{ $attendanceStats['late'] }}</p>
                    </div>
                    <div class="card-premium p-3 text-center">
                        <p class="text-xs text-slate-500">Leave</p>
                        <p class="text-xl font-bold text-blue-600">{{ $attendanceStats['leave'] }}</p>
                    </div>
                </div>

                <!-- Attendance List -->
                <div
                    class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm max-h-80 overflow-y-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-700">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-slate-900">{{ $attendance->date->format('d M') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($attendance->status === 'present') bg-green-100 text-green-800
                                                @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                                @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-6 text-center text-slate-500 text-sm">No records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Fee Section -->
            <div>
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Fee Receipts</h2>
                <div class="card-premium p-4 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Total Fee Paid</span>
                        <span class="text-xl font-bold text-green-600">₹{{ number_format($totalPaid, 2) }}</span>
                    </div>
                </div>

                <div
                    class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm max-h-80 overflow-y-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-700">Receipt</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-700">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-700">Amount</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-slate-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($receipts as $receipt)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-slate-900">{{ $receipt->receipt_number }}</td>
                                    <td class="px-4 py-2 text-sm text-slate-500">{{ $receipt->created_at->format('d M') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm font-medium text-green-600">
                                        ₹{{ number_format($receipt->amount) }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('parent.children.receipt', [$student, $receipt]) }}"
                                            class="text-purple-600 hover:text-purple-700 text-xs font-medium">Download</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-500 text-sm">No receipts</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.parent>