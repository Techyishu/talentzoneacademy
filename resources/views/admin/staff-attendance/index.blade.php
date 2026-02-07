<x-layouts.admin>
    <x-slot name="title">Staff Attendance</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Staff Attendance</h1>
                <p class="mt-1 text-sm text-slate-600">View and manage staff attendance records</p>
            </div>
            <div>
                <a href="{{ route('admin.staff-attendance.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all duration-200 shadow-lg shadow-primary-500/25">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Mark Attendance
                </a>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.staff-attendance.index') }}"
                class="flex flex-wrap items-end gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                    <input type="date" name="date" id="date" value="{{ $date }}"
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Present</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['present'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-red-100">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Absent</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-yellow-100">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Late</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Leave</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['leave'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-xl bg-orange-100">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Half Day</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $stats['half_day'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Staff</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Designation</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Check In</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Check Out</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($attendance->staff->name, 0, 2)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $attendance->staff->name }}
                                            </div>
                                            <div class="text-sm text-slate-500">{{ $attendance->staff->staff_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    {{ $attendance->staff->designation ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($attendance->status === 'present') bg-green-100 text-green-800
                                            @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                            @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                            @elseif($attendance->status === 'half_day') bg-orange-100 text-orange-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.staff-attendance.history', $attendance->staff) }}"
                                        class="text-primary-600 hover:text-primary-900">
                                        View History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-slate-500 text-lg font-medium">No attendance records found</p>
                                        <p class="text-slate-400 text-sm mt-1">Mark attendance to see records here</p>
                                        <a href="{{ route('admin.staff-attendance.create', ['date' => $date]) }}"
                                            class="mt-4 inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-primary">
                                            Mark Attendance
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $attendances->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>