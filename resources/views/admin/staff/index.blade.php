<x-layouts.admin>
    <x-slot name="title">Staff</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Staff</h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage your school staff</p>
                </div>
                <a href="{{ route('admin.staff.create') }}"
                    class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                    <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Add Staff</span>
                </a>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap sm:overflow-visible">
                <a href="{{ route('admin.id-cards.bulk-staff') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-primary-300 rounded-lg text-xs font-semibold text-primary-700 bg-primary-50 whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                    </svg>
                    ID Cards
                </a>
                <a href="{{ route('admin.staff.import.create') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-accent-300 rounded-lg text-xs font-semibold text-accent-700 bg-accent-50 whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import
                </a>
                <a href="{{ route('admin.staff.export') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-warm-300 rounded-lg text-xs font-semibold text-warm-700 bg-warm-50 whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </a>
                <a href="{{ route('admin.staff.import.template') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-slate-300 rounded-lg text-xs font-semibold text-slate-700 bg-white whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Template
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="card-premium p-4 sm:p-6">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <div class="sm:col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="block w-full rounded-lg border-slate-300 text-sm" />
                    </div>
                    <select name="designation" class="block w-full rounded-lg border-slate-300 text-sm">
                        <option value="">All Designations</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>
                                {{ $designation }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-600">Search</button>
                    @if(request()->hasAny(['search', 'designation']))<a href="{{ route('admin.staff.index') }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 border border-slate-300 bg-white">Clear</a>@endif
                </div>
            </form>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-3">
            @forelse($staffMembers as $staff)
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-start gap-3">
                        @if($staff->photo)
                            <img src="{{ asset('storage/' . $staff->photo) }}"
                                class="h-11 w-11 rounded-full object-cover border-2 border-slate-200 flex-shrink-0">
                        @else
                            <div
                                class="h-11 w-11 rounded-full bg-gradient-to-br from-accent-400 to-accent-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $staff->name }}</h3>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">{{ ucfirst($staff->status) }}</span>
                            </div>
                            <p class="text-xs text-slate-500">{{ $staff->staff_code }} • {{ $staff->designation }}</p>
                            @if($staff->phone)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $staff->phone }}</p>@endif
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('admin.staff.show', $staff) }}"
                            class="text-xs text-primary-600 font-medium">View</a>
                        <a href="{{ route('admin.staff.edit', $staff) }}"
                            class="text-xs text-accent-600 font-medium">Edit</a>
                        <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline"
                            onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button
                                class="text-xs text-red-600 font-medium">Delete</button></form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border p-8 text-center">
                    <p class="text-sm text-slate-500">No staff found</p>
                    <a href="{{ route('admin.staff.create') }}"
                        class="mt-3 inline-block px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-600">Add
                        Staff</a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Photo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Designation</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($staffMembers as $staff)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">@if($staff->photo)<img src="{{ asset('storage/' . $staff->photo) }}"
                            class="h-9 w-9 rounded-full object-cover border">@else<div
                                        class="h-9 w-9 rounded-full bg-accent-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($staff->name, 0, 2)) }}</div>@endif</td>
                            <td class="px-4 py-3 text-xs font-medium text-slate-900">{{ $staff->staff_code }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $staff->name }}</td>
                            <td class="px-4 py-3 text-xs text-slate-900">{{ $staff->designation }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $staff->phone }}</td>
                            <td class="px-4 py-3"><span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium {{ $staff->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800' }}">{{ ucfirst($staff->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.staff.show', $staff) }}" class="text-primary-600"><svg
                                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg></a>
                                    <a href="{{ route('admin.staff.edit', $staff) }}" class="text-accent-600"><svg
                                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></a>
                                    <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button
                                            class="text-red-600"><svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <p class="text-sm text-slate-500">No staff found</p><a
                                    href="{{ route('admin.staff.create') }}"
                                    class="mt-3 inline-block px-4 py-2 rounded-xl text-sm font-semibold text-white bg-primary-600">Add
                                    Staff</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($staffMembers->hasPages())
        <div class="flex justify-center"><x-admin.pagination :paginator="$staffMembers" /></div>@endif
    </div>
</x-layouts.admin>