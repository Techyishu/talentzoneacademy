<x-layouts.staff>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="card-premium p-6">
            <div class="flex items-center">
                <div
                    class="h-16 w-16 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($staff->name, 0, 2)) }}
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-slate-900">Welcome, {{ $staff->name }}</h1>
                    <p class="text-slate-600">{{ $staff->designation ?? 'Staff Member' }} • {{ $staff->staff_code }}</p>
                </div>
            </div>
        </div>

        <!-- Attendance Stats -->
        <div>
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Attendance -
                {{ date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Working Days</p>
                    <p class="text-2xl font-bold text-slate-700">{{ $attendanceStats['total'] }}</p>
                </div>
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
                <div class="card-premium p-4 text-center">
                    <p class="text-sm font-medium text-slate-500">Half Day</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $attendanceStats['half_day'] }}</p>
                </div>
            </div>
        </div>

        <!-- Attendance Percentage -->
        @if($attendanceStats['total'] > 0)
            <div class="card-premium p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-slate-700">Monthly Attendance Rate</span>
                    <span
                        class="text-lg font-bold {{ $attendancePercentage >= 75 ? 'text-green-600' : ($attendancePercentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $attendancePercentage }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3">
                    <div class="h-3 rounded-full {{ $attendancePercentage >= 75 ? 'bg-green-500' : ($attendancePercentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                        style="width: {{ min($attendancePercentage, 100) }}%"></div>
                </div>
            </div>
        @endif

        <!-- Recent Attendance -->
        <div>
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Recent Attendance</h2>
            <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Check In</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Check Out
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentAttendance as $attendance)
                            <tr>
                                <td class="px-6 py-4 text-sm text-slate-900">{{ $attendance->date->format('d M Y') }}</td>
                                <td class="px-6 py-4">
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
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">No attendance records yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('staff.attendance') }}"
                    class="text-emerald-600 hover:text-emerald-700 font-medium text-sm">View Full History →</a>
            </div>
        </div>
    </div>
</x-layouts.staff>