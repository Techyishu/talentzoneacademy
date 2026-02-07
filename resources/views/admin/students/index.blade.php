@php
    /**
     * @var \Illuminate\Support\Collection<int, string> $classes
     * @var \Illuminate\Support\Collection<int, string> $sections
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $students
     */
@endphp
<x-layouts.admin>
    <x-slot name="title">Students</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Students</h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage your school students</p>
                </div>
                <!-- Primary action button always visible -->
                <a href="{{ route('admin.students.create') }}"
                    class="inline-flex items-center px-3 py-2 sm:px-4 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Add Student</span>
                </a>
            </div>

            <!-- Action buttons - scrollable on mobile -->
            <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap sm:overflow-visible">
                <a href="{{ route('admin.parent-students.create') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-indigo-300 rounded-lg text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Add by Parent
                </a>
                <a href="{{ route('admin.id-cards.bulk-student-form') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-primary-300 rounded-lg text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    ID Cards
                </a>
                <a href="{{ route('admin.students.import.create') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-accent-300 rounded-lg text-xs font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import
                </a>
                <a href="{{ route('admin.students.export') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-warm-300 rounded-lg text-xs font-semibold text-warm-700 bg-warm-50 hover:bg-warm-100 transition-all whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </a>
                <a href="{{ route('admin.students.import.template') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-slate-300 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Template
                </a>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card-premium p-4 sm:p-6">
            <form method="GET" action="{{ route('admin.students.index') }}" class="space-y-3 sm:space-y-4">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-4">
                    <!-- Search -->
                    <div class="col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search name, admission no..."
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm" />
                    </div>

                    <!-- Class Filter -->
                    <div>
                        <select name="class"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            <option value="">All Classes</option>
                            @foreach($classes as $className)
                                <option value="{{ $className }}" {{ request('class') == $className ? 'selected' : '' }}>
                                    {{ $className }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section Filter -->
                    <div>
                        <select name="section"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            <option value="">All Sections</option>
                            @foreach($sections as $sectionName)
                                <option value="{{ $sectionName }}" {{ request('section') == $sectionName ? 'selected' : '' }}>
                                    {{ $sectionName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-xs font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg transition-all">
                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search
                    </button>
                    @if(request()->hasAny(['search', 'class', 'section', 'status']))
                        <a href="{{ route('admin.students.index') }}"
                            class="inline-flex items-center px-3 py-1.5 border-2 border-slate-300 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Mobile Card View -->
        <div class="block lg:hidden space-y-3">
            @forelse($students as $student)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                    <div class="flex items-start gap-3">
                        <!-- Photo -->
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}"
                                class="h-12 w-12 rounded-full object-cover border-2 border-slate-200 flex-shrink-0">
                        @else
                            <div
                                class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr($student->name, 0, 2)) }}
                            </div>
                        @endif

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $student->name }}</h3>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $student->admission_no }} • {{ $student->gender }}
                            </p>
                            <p class="text-xs text-slate-600 mt-1">
                                Class {{ $student->class }}{{ $student->section ? '-' . $student->section : '' }}
                                @if($student->roll_no) (Roll: {{ $student->roll_no }}) @endif
                            </p>
                            @if($student->guardian_name)
                                <p class="text-xs text-slate-500 mt-1">
                                    <span class="font-medium">Guardian:</span> {{ $student->guardian_name }}
                                </p>
                            @endif
                            @if($student->parents->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($student->parents as $parent)
                                        <span
                                            class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                                            {{ $parent->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 mt-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('admin.students.show', $student) }}"
                            class="inline-flex items-center text-xs text-primary-600 hover:text-primary-900 font-medium">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.students.edit', $student) }}"
                            class="inline-flex items-center text-xs text-accent-600 hover:text-accent-900 font-medium">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline"
                            onsubmit="return confirm('Delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center text-xs text-red-600 hover:text-red-900 font-medium">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
                    <svg class="h-12 w-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-sm font-medium text-slate-500">No students found</p>
                    <p class="text-xs text-slate-400 mt-1">Add your first student to get started</p>
                    <a href="{{ route('admin.students.create') }}"
                        class="mt-3 inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-xs font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                        Add Student
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Photo</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Adm No</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Class</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Guardian</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Parent</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($student->photo)
                                        <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}"
                                            class="h-9 w-9 rounded-full object-cover border-2 border-slate-200">
                                    @else
                                        <div
                                            class="h-9 w-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs font-medium text-slate-900">
                                    {{ $student->admission_no }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $student->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $student->gender }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-900">
                                    {{ $student->class }}{{ $student->section ? '-' . $student->section : '' }}
                                    @if($student->roll_no)
                                        <span class="text-slate-500">({{ $student->roll_no }})</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-xs text-slate-900">{{ $student->guardian_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $student->guardian_phone }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($student->parents->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($student->parents as $parent)
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ Str::limit($parent->name, 12) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.students.show', $student) }}"
                                            class="text-primary-600 hover:text-primary-900" title="View">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student) }}"
                                            class="text-accent-600 hover:text-accent-900" title="Edit">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Delete this student?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-sm font-medium text-slate-500">No students found</p>
                                        <p class="text-xs text-slate-400 mt-1">Get started by adding your first student</p>
                                        <a href="{{ route('admin.students.create') }}"
                                            class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                                            Add Student
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
            <div class="flex justify-center">
                <x-admin.pagination :paginator="$students" />
            </div>
        @endif
    </div>
</x-layouts.admin>