<x-layouts.admin>
    <x-slot name="title">Students by Class</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Students by Class</h1>
                <p class="mt-1 text-sm text-slate-600">View student count breakdown by class and section</p>
            </div>
            <a href="{{ route('admin.reports.students-by-class.export', ['status' => $status]) }}"
               class="inline-flex items-center px-4 py-2 border-2 border-accent-300 rounded-xl text-sm font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all duration-200">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export to Excel
            </a>
        </div>

        <!-- Filters -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.reports.students-by-class') }}" class="flex items-center gap-4">
                <label for="status" class="text-sm font-medium text-slate-700">Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Students</option>
                </select>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-primary-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Students</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Classes</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalClasses }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-pink-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Female</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $genderBreakdown['female'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-cyan-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Male</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $genderBreakdown['male'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Breakdown Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Class-wise Breakdown</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">Sections</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Total Students</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">% of Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($classSummary as $class)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $class->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-wrap justify-center gap-1">
                                        @forelse($class->sections as $section)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                                {{ $section->name }}: {{ $section->students_count }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-slate-400">No sections</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-slate-900">{{ $class->students_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-16 bg-slate-200 rounded-full h-2">
                                            <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $totalStudents > 0 ? ($class->students_count / $totalStudents * 100) : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm text-slate-600">{{ $totalStudents > 0 ? number_format($class->students_count / $totalStudents * 100, 1) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <p class="text-sm font-medium text-slate-500">No classes found</p>
                                        <p class="text-xs text-slate-400 mt-1">Create classes to see the breakdown</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($classSummary->count() > 0)
                        <tfoot class="bg-slate-100">
                            <tr>
                                <td class="px-6 py-4 text-sm font-bold text-slate-900">Total</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-slate-900">{{ $classSummary->sum(fn($c) => $c->sections->count()) }} sections</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">{{ $totalStudents }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">100%</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
