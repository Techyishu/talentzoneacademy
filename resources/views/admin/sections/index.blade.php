<x-layouts.admin>
    <x-slot name="title">Sections - {{ $class->name }}</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">{{ $class->name }} Sections
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage sections for this class</p>
                </div>
                <a href="{{ route('admin.sections.create', $class) }}"
                    class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                    <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Add Section</span>
                </a>
            </div>
            <a href="{{ route('admin.classes.index') }}"
                class="inline-flex items-center text-xs sm:text-sm text-slate-600 hover:text-slate-900">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Classes
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 border border-green-200">
                <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-lg bg-red-50 p-3 border border-red-200">
                <p class="text-xs sm:text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        @if($class->sections->count() > 0)
            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-3">
                @foreach($class->sections as $section)
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $class->name }} - {{ $section->name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $section->students->count() }} students</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.student-attendance.quick', [$class, $section]) }}"
                                    class="text-xs text-green-600 font-medium">Take Attendance</a>
                                <a href="{{ route('admin.sections.edit', [$class, $section]) }}"
                                    class="text-xs text-primary-600 font-medium">Edit</a>
                                <form action="{{ route('admin.sections.destroy', [$class, $section]) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Delete section?');">@csrf @method('DELETE')<button
                                        class="text-xs text-red-600 font-medium">Delete</button></form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Section Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Students</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($class->sections as $section)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $class->name }} -
                                    {{ $section->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $section->students->count() }} student(s)</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.student-attendance.quick', [$class, $section]) }}"
                                            class="text-xs text-green-600 font-medium hover:text-green-900">Take Attendance</a>
                                        <a href="{{ route('admin.sections.edit', [$class, $section]) }}"
                                            class="text-xs text-primary-600 font-medium hover:text-primary-900">Edit</a>
                                        <form action="{{ route('admin.sections.destroy', [$class, $section]) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button
                                                class="text-xs text-red-600 font-medium hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white rounded-xl border p-8 text-center">
                <p class="text-sm text-slate-500 mb-4">No sections found for {{ $class->name }}</p>
                <a href="{{ route('admin.sections.create', $class) }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-primary-600">Add
                    First Section</a>
            </div>
        @endif
    </div>
</x-layouts.admin>