<x-layouts.admin>
    <x-slot name="title">Portal Users</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Portal Users</h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage user accounts</p>
                </div>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap sm:overflow-visible">
                <a href="{{ route('admin.portal-users.create', ['type' => 'staff']) }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-emerald-600 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>Staff
                </a>
                <a href="{{ route('admin.portal-users.create', ['type' => 'student']) }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-blue-600 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>Student
                </a>
                <a href="{{ route('admin.portal-users.create', ['type' => 'parent']) }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-purple-600 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>Parent
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 border border-green-200">
                <p class="text-xs font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-2 sm:gap-4">
            <a href="{{ route('admin.portal-users.index', ['type' => 'staff']) }}"
                class="card-premium p-3 sm:p-4 {{ $type === 'staff' ? 'ring-2 ring-emerald-500' : '' }}">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-emerald-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-emerald-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs font-medium text-slate-500">Staff</p>
                        <p class="text-lg sm:text-xl font-bold text-emerald-600">{{ $stats['staff'] }}</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.portal-users.index', ['type' => 'student']) }}"
                class="card-premium p-3 sm:p-4 {{ $type === 'student' ? 'ring-2 ring-blue-500' : '' }}">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-blue-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs font-medium text-slate-500">Students</p>
                        <p class="text-lg sm:text-xl font-bold text-blue-600">{{ $stats['student'] }}</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.portal-users.index', ['type' => 'parent']) }}"
                class="card-premium p-3 sm:p-4 {{ $type === 'parent' ? 'ring-2 ring-purple-500' : '' }}">
                <div class="flex items-center">
                    <div class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-purple-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs font-medium text-slate-500">Parents</p>
                        <p class="text-lg sm:text-xl font-bold text-purple-600">{{ $stats['parent'] }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Filter -->
        <div class="card-premium p-3 sm:p-4 flex flex-wrap gap-2">
            <a href="{{ route('admin.portal-users.index') }}"
                class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $type === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-700' }}">All</a>
            <a href="{{ route('admin.portal-users.index', ['type' => 'staff']) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $type === 'staff' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }}">Staff</a>
            <a href="{{ route('admin.portal-users.index', ['type' => 'student']) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $type === 'student' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">Students</a>
            <a href="{{ route('admin.portal-users.index', ['type' => 'parent']) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $type === 'parent' ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-700' }}">Parents</a>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-3">
            @forelse($users as $user)
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0
                                @if($user->role === 'staff') bg-emerald-500 @elseif($user->role === 'student') bg-blue-500 @else bg-purple-500 @endif">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $user->name }}</h3>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($user->role === 'staff') bg-emerald-100 text-emerald-800 @elseif($user->role === 'student') bg-blue-100 text-blue-800 @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                @if($user->role === 'staff' && $user->staff){{ $user->staff->name }}
                                @elseif($user->role === 'student' && $user->student){{ $user->student->name }}
                                @elseif($user->role === 'parent'){{ $user->children->count() }} children
                                @else - @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('admin.portal-users.edit', $user) }}"
                            class="text-xs text-primary-600 font-medium">Edit</a>
                        <form action="{{ route('admin.portal-users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button
                                class="text-xs text-red-600 font-medium">Delete</button></form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border p-8 text-center">
                    <p class="text-sm text-slate-500">No users found</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Linked</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div
                                        class="h-9 w-9 rounded-full flex items-center justify-center text-white text-xs font-bold
                                            @if($user->role === 'staff') bg-emerald-500 @elseif($user->role === 'student') bg-blue-500 @else bg-purple-500 @endif">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3"><span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium @if($user->role === 'staff') bg-emerald-100 text-emerald-800 @elseif($user->role === 'student') bg-blue-100 text-blue-800 @else bg-purple-100 text-purple-800 @endif">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                @if($user->role === 'staff' && $user->staff){{ $user->staff->name }}@elseif($user->role === 'student' && $user->student){{ $user->student->name }}@elseif($user->role === 'parent'){{ $user->children->count() }}
                                children@else - @endif</td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.portal-users.edit', $user) }}"
                                        class="text-slate-600 hover:text-blue-600"><svg class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></a>
                                    <form action="{{ route('admin.portal-users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button
                                            class="text-slate-600 hover:text-red-600"><svg class="w-4 h-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-500">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="mt-4">{{ $users->withQueryString()->links() }}</div>@endif
    </div>
</x-layouts.admin>