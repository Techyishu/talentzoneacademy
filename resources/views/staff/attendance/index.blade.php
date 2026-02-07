<x-layouts.staff>
    <x-slot name="title">My Attendance</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">My Attendance History</h1>
        </div>

        <!-- Month Filter -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('staff.attendance') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-slate-700 mb-1">Month</label>
                    <select name="month" id="month"
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-slate-700 mb-1">Year</label>
                    <select name="year" id="year"
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        @foreach(range(now()->year, now()->year - 2) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700">Filter</button>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Total</p>
                <p class="text-2xl font-bold text-slate-700">{{ $stats['total'] }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Present</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['present'] }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Absent</p>
                <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Late</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Leave</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['leave'] }}</p>
            </div>
            <div class="card-premium p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Half Day</p>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['half_day'] }}</p>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($attendances as $attendance)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                {{ $attendance->date->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $attendance->date->format('l') }}</td>
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
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $attendance->remarks ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">No attendance records for this
                                month.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.staff>