<x-layouts.admin>
    <x-slot name="title">Attendance History - {{ $staff->name }}</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center space-x-3">
                    <div
                        class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($staff->name, 0, 2)) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 font-heading">{{ $staff->name }}</h1>
                        <p class="text-sm text-slate-600">{{ $staff->staff_code }} •
                            {{ $staff->designation ?? 'Staff' }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.staff-attendance.index') }}"
                class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Attendance
            </a>
        </div>

        <!-- Month Filter -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.staff-attendance.history', $staff) }}"
                class="flex flex-wrap items-end gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-slate-700 mb-1">Month</label>
                    <select name="month" id="month"
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-slate-700 mb-1">Year</label>
                    <select name="year" id="year"
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                        @foreach(range(now()->year, now()->year - 2) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
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
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Total</p>
                <p class="text-2xl font-bold text-slate-700">{{ $totalDays }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Present</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['present'] ?? 0 }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Absent</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] ?? 0 }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Late</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] ?? 0 }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Leave</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['leave'] ?? 0 }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Half Day</p>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['half_day'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Attendance percentage -->
        @if($totalDays > 0)
            @php
                $presentCount = ($stats['present'] ?? 0) + ($stats['late'] ?? 0) + (($stats['half_day'] ?? 0) * 0.5);
                $percentage = round(($presentCount / $totalDays) * 100, 1);
            @endphp
            <div class="card-premium p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-slate-700">Attendance Rate</span>
                    <span
                        class="text-lg font-bold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $percentage }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3">
                    <div class="h-3 rounded-full {{ $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                        style="width: {{ min($percentage, 100) }}%"></div>
                </div>
            </div>
        @endif

        <!-- Attendance Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Day</th>
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
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    {{ $attendance->date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $attendance->date->format('l') }}
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
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $attendance->remarks ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-slate-500">No attendance records for this month.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>