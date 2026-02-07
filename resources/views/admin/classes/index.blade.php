@php
/** @var \Illuminate\Database\Eloquent\Collection<\App\Models\SchoolClass> $classes */
@endphp
<x-layouts.admin>
    <x-slot name="title">Classes</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Classes</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage school classes</p>
            </div>
            <a href="{{ route('admin.classes.create') }}"
                class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="hidden sm:inline">Add Class</span>
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

        @if($classes->count() > 0)
            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-3">
                @foreach($classes as $schoolClass)
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $schoolClass->name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Order: {{ $schoolClass->display_order }}</p>
                            </div>
                            <div class="text-right">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">{{ $schoolClass->sections->count() }}
                                    sections</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $schoolClass->students->count() }} students</p>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-3 pt-3 border-t border-slate-100">
                            <a href="{{ route('admin.sections.index', $schoolClass) }}"
                                class="text-xs text-green-600 font-medium">Sections</a>
                            <a href="{{ route('admin.classes.edit', $schoolClass) }}"
                                class="text-xs text-primary-600 font-medium">Edit</a>
                            <form action="{{ route('admin.classes.destroy', $schoolClass) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete class?');">@csrf @method('DELETE')<button
                                    class="text-xs text-red-600 font-medium">Delete</button></form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Class Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Sections</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Students</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($classes as $schoolClass)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $schoolClass->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $schoolClass->display_order }}</td>
                                <td class="px-4 py-3"><a href="{{ route('admin.sections.index', $schoolClass) }}"
                                        class="text-sm text-primary-600 hover:text-primary-900">{{ $schoolClass->sections->count() }}
                                        section(s)</a></td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ $schoolClass->students->count() }} student(s)
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.sections.index', $schoolClass) }}"
                                            class="text-xs text-green-600 font-medium hover:text-green-900">Sections</a>
                                        <a href="{{ route('admin.classes.edit', $schoolClass) }}"
                                            class="text-xs text-primary-600 font-medium hover:text-primary-900">Edit</a>
                                        <form action="{{ route('admin.classes.destroy', $schoolClass) }}" method="POST"
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
                <p class="text-sm text-slate-500 mb-4">No classes found</p>
                <a href="{{ route('admin.classes.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-primary-600">Add
                    Your First Class</a>
            </div>
        @endif
    </div>
</x-layouts.admin>