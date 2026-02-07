<x-layouts.admin>
    <x-slot name="title">Quick Attendance - {{ $class->name }} {{ $section->name }}</x-slot>

    <div class="space-y-4 sm:space-y-6" x-data="quickAttendance()">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">
                        {{ $class->name }} - {{ $section->name }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600 font-medium">
                        📱 Tap students to toggle Present/Absent • All are Present by default
                    </p>
                </div>

                <form method="GET" action="{{ route('admin.student-attendance.quick', [$class, $section]) }}"
                    class="flex items-center gap-2">
                    <input type="date" name="date" value="{{ $date }}"
                        class="rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                        onchange="this.form.submit()">
                </form>
            </div>
            <a href="{{ route('admin.sections.index', $class) }}"
                class="inline-flex items-center text-xs sm:text-sm text-slate-600 hover:text-slate-900">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Sections
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 border border-green-200">
                <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if($students->count() > 0)
            <form method="POST" action="{{ route('admin.student-attendance.store-quick') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="class_id" value="{{ $class->id }}">
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <!-- Summary Stats -->
                <div class="bg-white rounded-xl border border-slate-200 p-4 mb-4">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">Present: <span x-text="presentCount"
                                        class="text-green-600 text-lg"></span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-red-500 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">Absent: <span x-text="absentCount"
                                        class="text-red-600 text-lg"></span></span>
                            </div>
                            <div class="text-sm text-slate-500 font-medium">
                                Total: {{ $students->count() }}
                            </div>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Attendance
                        </button>
                    </div>
                </div>

                <!-- Legend -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-xs text-blue-900">
                        <p class="font-semibold mb-1">How to use:</p>
                        <p>✅ <strong class="text-green-700">Green cards with checkmark</strong> = Student is PRESENT</p>
                        <p>❌ <strong class="text-red-700">Red cards with X mark</strong> = Student is ABSENT</p>
                        <p class="mt-1">👆 <strong>Tap any card</strong> to change status</p>
                    </div>
                </div>

                <!-- Student List with Checkboxes -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Student</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Roll</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase">Present</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($students as $student)
                                @php
                                    $existing = $existingAttendance->get($student->id);
                                    $isPresent = !$existing || $existing->status !== 'absent';
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors"
                                    :class="!absentStudents.includes({{ $student->id }}) ? 'bg-green-50' : 'bg-red-50'">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" 
                                                    class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm">
                                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <span class="font-medium text-slate-900">{{ $student->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-slate-600">
                                        {{ $student->roll_no ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                class="w-6 h-6 rounded border-2 border-slate-300 text-green-600 focus:ring-green-500 focus:ring-2 cursor-pointer"
                                                :checked="!absentStudents.includes({{ $student->id }})"
                                                @change="toggleStudent({{ $student->id }})">
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Hidden inputs for absent students -->
                @foreach($students as $student)
                    <template x-if="absentStudents.includes({{ $student->id }})">
                        <input type="hidden" name="absent_students[]" value="{{ $student->id }}">
                    </template>
                @endforeach

                <!-- Bottom Save Button (Mobile) -->
                <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-slate-200 lg:hidden z-40">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-3 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition-all shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Attendance
                    </button>
                </div>
                <div class="h-20 lg:hidden"></div>
            </form>
        @else
            <div class="bg-white rounded-xl border p-8 text-center">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">No Active Students</h3>
                <p class="text-sm text-slate-500 mb-4">There are no active students in {{ $class->name }} -
                    {{ $section->name }}</p>
                <a href="{{ route('admin.students.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-primary-600">
                    Add Students
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function quickAttendance() {
                return {
                    absentStudents: [
                        @foreach($students as $student)
                            @php $existing = $existingAttendance->get($student->id); @endphp
                            @if($existing && $existing->status === 'absent')
                                {{ $student->id }},
                            @endif
                        @endforeach
                    ],
                    totalStudents: {{ $students->count() }},

                    get presentCount() {
                        return this.totalStudents - this.absentStudents.length;
                    },

                    get absentCount() {
                        return this.absentStudents.length;
                    },

                    toggleStudent(studentId) {
                        const index = this.absentStudents.indexOf(studentId);
                        if (index === -1) {
                            this.absentStudents.push(studentId);
                        } else {
                            this.absentStudents.splice(index, 1);
                        }
                    }
                }
            }
        </script>
    @endpush
</x-layouts.admin>