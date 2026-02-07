<x-layouts.admin>
    <x-slot name="title">Mark Staff Attendance</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Mark Staff Attendance</h1>
                <p class="mt-1 text-sm text-slate-600">Mark attendance for all staff members</p>
            </div>
            <a href="{{ route('admin.staff-attendance.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Date Selection -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.staff-attendance.create') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ $date }}" required
                        class="block rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Load Staff
                </button>
            </form>
        </div>

        @if($staff->count() > 0)
            <!-- Attendance Form -->
            <form method="POST" action="{{ route('admin.staff-attendance.store') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <!-- Quick Actions -->
                <div class="card-premium p-4 mb-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-sm font-medium text-slate-700">Quick Actions:</span>
                        <button type="button" onclick="markAll('present')" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-green-100 text-green-700 hover:bg-green-200 transition-colors">
                            Mark All Present
                        </button>
                        <button type="button" onclick="markAll('absent')" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                            Mark All Absent
                        </button>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Staff</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Designation</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Check Out</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($staff as $index => $member)
                                    @php
                                        $existing = $existingAttendance->get($member->id);
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="attendance[{{ $index }}][staff_id]" value="{{ $member->id }}">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-slate-900">{{ $member->name }}</div>
                                                    <div class="text-sm text-slate-500">{{ $member->staff_code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                            {{ $member->designation ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center space-x-1">
                                                @foreach(['present' => 'P', 'absent' => 'A', 'late' => 'L', 'leave' => 'Le', 'half_day' => 'H'] as $status => $label)
                                                    <label class="relative">
                                                        <input type="radio" 
                                                            name="attendance[{{ $index }}][status]" 
                                                            value="{{ $status }}" 
                                                            class="peer sr-only status-radio"
                                                            data-staff="{{ $member->id }}"
                                                            {{ ($existing?->status ?? 'present') === $status ? 'checked' : '' }}>
                                                        <div class="w-8 h-8 flex items-center justify-center rounded-lg border-2 cursor-pointer transition-all text-xs
                                                            @if($status === 'present') peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white border-green-200 text-green-600
                                                            @elseif($status === 'absent') peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white border-red-200 text-red-600
                                                            @elseif($status === 'late') peer-checked:bg-yellow-500 peer-checked:border-yellow-500 peer-checked:text-white border-yellow-200 text-yellow-600
                                                            @elseif($status === 'half_day') peer-checked:bg-orange-500 peer-checked:border-orange-500 peer-checked:text-white border-orange-200 text-orange-600
                                                            @else peer-checked:bg-blue-500 peer-checked:border-blue-500 peer-checked:text-white border-blue-200 text-blue-600
                                                            @endif">
                                                            <span class="font-bold">{{ $label }}</span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="time" 
                                                name="check_in[{{ $member->id }}]" 
                                                value="{{ $existing?->check_in ? \Carbon\Carbon::parse($existing->check_in)->format('H:i') : '' }}"
                                                class="block w-28 rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="time" 
                                                name="check_out[{{ $member->id }}]" 
                                                value="{{ $existing?->check_out ? \Carbon\Carbon::parse($existing->check_out)->format('H:i') : '' }}"
                                                class="block w-28 rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" 
                                                name="remarks[{{ $member->id }}]" 
                                                value="{{ $existing?->remarks }}"
                                                placeholder="Optional"
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all duration-200 shadow-lg shadow-primary-500/25">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Attendance
                    </button>
                </div>
            </form>
        @else
            <div class="card-premium p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No Active Staff Found</h3>
                <p class="text-slate-500">There are no active staff members to mark attendance for.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function markAll(status) {
            document.querySelectorAll(`.status-radio[value="${status}"]`).forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
    @endpush
</x-layouts.admin>
