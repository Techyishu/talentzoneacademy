<x-layouts.admin>
    <x-slot name="title">Mark Student Attendance</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Mark Attendance</h1>
                <p class="mt-1 text-sm text-slate-600">Mark attendance for students by class and section</p>
            </div>
            <a href="{{ route('admin.student-attendance.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Selection Form -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.student-attendance.create') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-slate-700 mb-1">Date <span class="text-red-500">*</span></label>
                        <input type="date" name="date" id="date" value="{{ $date }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>

                    <!-- Class -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-slate-700 mb-1">Class <span class="text-red-500">*</span></label>
                        <select name="class_id" id="class_id" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label for="section_id" class="block text-sm font-medium text-slate-700 mb-1">Section</label>
                        <select name="section_id" id="section_id" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            <option value="">All Sections</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $sectionId == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Load Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Load Students
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($students->count() > 0)
            <!-- Attendance Form -->
            <form method="POST" action="{{ route('admin.student-attendance.store') }}">
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
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Roll No</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($students as $index => $student)
                                    @php
                                        $existing = $existingAttendance->get($student->id);
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="attendance[{{ $index }}][student_id]" value="{{ $student->id }}">
                                            <div class="flex items-center">
                                                @if($student->photo)
                                                    <img src="{{ asset('uploads/photos/' . $student->photo) }}" alt="{{ $student->name }}" class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-slate-900">{{ $student->name }}</div>
                                                    <div class="text-sm text-slate-500">{{ $student->admission_no }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                            {{ $student->roll_no ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center space-x-2">
                                                @foreach(['present' => 'P', 'absent' => 'A', 'late' => 'L', 'leave' => 'Le'] as $status => $label)
                                                    <label class="relative">
                                                        <input type="radio" 
                                                            name="attendance[{{ $index }}][status]" 
                                                            value="{{ $status }}" 
                                                            class="peer sr-only status-radio"
                                                            data-student="{{ $student->id }}"
                                                            {{ ($existing?->status ?? 'present') === $status ? 'checked' : '' }}>
                                                        <div class="w-10 h-10 flex items-center justify-center rounded-lg border-2 cursor-pointer transition-all
                                                            @if($status === 'present') peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white border-green-200 text-green-600
                                                            @elseif($status === 'absent') peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white border-red-200 text-red-600
                                                            @elseif($status === 'late') peer-checked:bg-yellow-500 peer-checked:border-yellow-500 peer-checked:text-white border-yellow-200 text-yellow-600
                                                            @else peer-checked:bg-blue-500 peer-checked:border-blue-500 peer-checked:text-white border-blue-200 text-blue-600
                                                            @endif">
                                                            <span class="text-sm font-bold">{{ $label }}</span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" 
                                                name="remarks[{{ $student->id }}]" 
                                                value="{{ $existing?->remarks }}"
                                                placeholder="Optional remarks"
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
        @elseif($classId)
            <div class="card-premium p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No Active Students Found</h3>
                <p class="text-slate-500">There are no active students in the selected class/section.</p>
            </div>
        @else
            <div class="card-premium p-12 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Select Class to Continue</h3>
                <p class="text-slate-500">Please select a date and class to load students for marking attendance.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.getElementById('class_id').addEventListener('change', function() {
            const classId = this.value;
            const sectionSelect = document.getElementById('section_id');
            
            sectionSelect.innerHTML = '<option value="">All Sections</option>';
            
            if (classId) {
                fetch(`{{ url('admin/classes') }}/${classId}/sections-json`)
                    .then(response => response.json())
                    .then(sections => {
                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            sectionSelect.appendChild(option);
                        });
                    });
            }
        });

        function markAll(status) {
            document.querySelectorAll(`.status-radio[value="${status}"]`).forEach(radio => {
                radio.checked = true;
            });
        }
    </script>
    @endpush
</x-layouts.admin>
