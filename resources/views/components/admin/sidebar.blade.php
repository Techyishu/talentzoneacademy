<!-- Mobile Sidebar -->
<div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-64 lg:hidden"
    style="display: none;">
    <div class="flex h-full flex-col admin-sidebar">
        <!-- Logo / School Branding -->
        <div class="flex h-16 items-center justify-between px-4 border-b border-slate-700/50">
            @php
                $activeSchool = session('active_school_id') ? \App\Models\School::find(session('active_school_id')) : null;
            @endphp

            <div class="flex items-center space-x-3">
                @if($activeSchool && $activeSchool->logo)
                    <img src="{{ asset('uploads/logos/' . $activeSchool->logo) }}" alt="{{ $activeSchool->name }}"
                        class="h-8 w-8 rounded-lg object-cover">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="SchoolSuite"
                        class="h-8 w-8 rounded-lg object-cover bg-white">
                @endif
                <span class="text-sm font-semibold text-white">
                    {{ $activeSchool ? $activeSchool->name : 'SchoolSuite' }}
                </span>
            </div>

            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-3 py-4 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.students.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.students.*') || request()->routeIs('admin.parent-students.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span>Students</span>
            </a>

            <a href="{{ route('admin.staff.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                <span>Staff</span>
            </a>

            <a href="{{ route('admin.portal-users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.portal-users.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Portal Users</span>
            </a>

            <a href="{{ route('admin.fee-receipts.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.fee-receipts.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <span>Fees</span>
            </a>

            <div
                x-data="{ attendanceOpen: {{ request()->routeIs('admin.student-attendance.*') || request()->routeIs('admin.staff-attendance.*') ? 'true' : 'false' }} }">
                <button @click="attendanceOpen = !attendanceOpen"
                    class="sidebar-link w-full justify-between {{ request()->routeIs('admin.student-attendance.*') || request()->routeIs('admin.staff-attendance.*') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        <span class="ml-3">Attendance</span>
                    </span>
                    <svg class="h-4 w-4 transform transition-transform" :class="attendanceOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="attendanceOpen" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.student-attendance.index') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.student-attendance.*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span>Students</span>
                    </a>
                    <a href="{{ route('admin.staff-attendance.index') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.staff-attendance.*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Staff</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.salary-slips.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.salary-slips.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Salary</span>
            </a>

            <div x-data="{ reportsOpen: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                <button @click="reportsOpen = !reportsOpen"
                    class="sidebar-link w-full justify-between {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span class="ml-3">Reports</span>
                    </span>
                    <svg class="h-4 w-4 transform transition-transform" :class="reportsOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="reportsOpen" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.reports.dues') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.dues') || request()->routeIs('admin.reports.student-dues') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Pending Dues</span>
                    </a>
                    <a href="{{ route('admin.reports.fee-collection') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.fee-collection*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span>Fee Collection</span>
                    </a>
                    <a href="{{ route('admin.reports.students-by-class') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.students-by-class*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span>Students by Class</span>
                    </a>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-700/50">
                <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Settings
                </div>
                <a href="{{ route('admin.academic-sessions.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.academic-sessions.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Academic Sessions</span>
                </a>
                <a href="{{ route('admin.classes.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.sections.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span>Classes & Sections</span>
                </a>
            </div>

            @if(auth()->user()->isSuperAdmin())
                <div class="pt-4 mt-4 border-t border-slate-700/50">
                    <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Super Admin
                    </div>
                    <a href="{{ route('admin.schools.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span>Manage Schools</span>
                    </a>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-700/50">
                    <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Website Content
                    </div>
                    <a href="{{ route('admin.gallery.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Gallery</span>
                    </a>
                    <a href="{{ route('admin.contact-submissions.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Contact Submissions</span>
                    </a>
                    <a href="{{ route('admin.public-reviews.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.public-reviews.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>Public Reviews</span>
                    </a>
                    <a href="{{ route('admin.background-music.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.background-music.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                            </path>
                        </svg>
                        <span>Background Music</span>
                    </a>
                    <a href="{{ route('admin.homepage-videos.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.homepage-videos.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Homepage Videos</span>
                    </a>
                </div>
            @endif
        </nav>

        <!-- User Section (Bottom) -->
        <div class="border-t border-slate-700/50 px-3 py-4">
            <div class="flex items-center space-x-3 rounded-xl bg-slate-800/50 px-3 py-2">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full gradient-primary text-xs font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Desktop Sidebar -->
<div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
    <div class="flex min-h-0 flex-1 flex-col glass-dark shadow-2xl">
        <!-- Logo / School Branding -->
        <div class="flex h-16 items-center px-4 border-b border-slate-700/50">
            @php
                $activeSchool = session('active_school_id') ? \App\Models\School::find(session('active_school_id')) : null;
            @endphp

            <div class="flex items-center space-x-3">
                @if($activeSchool && $activeSchool->logo)
                    <img src="{{ asset('uploads/logos/' . $activeSchool->logo) }}" alt="{{ $activeSchool->name }}"
                        class="h-8 w-8 rounded-lg object-cover">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="SchoolSuite"
                        class="h-8 w-8 rounded-lg object-cover bg-white">
                @endif
                <span class="text-sm font-semibold text-white truncate">
                    {{ $activeSchool ? $activeSchool->name : 'SchoolSuite' }}
                </span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-3 py-4 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.students.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.students.*') || request()->routeIs('admin.parent-students.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span>Students</span>
            </a>

            <a href="{{ route('admin.staff.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                <span>Staff</span>
            </a>

            <a href="{{ route('admin.portal-users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.portal-users.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Portal Users</span>
            </a>

            <a href="{{ route('admin.fee-receipts.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.fee-receipts.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <span>Fees</span>
            </a>

            <a href="{{ route('admin.salary-slips.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.salary-slips.*') ? 'active' : '' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Salary</span>
            </a>

            <div x-data="{ reportsOpen: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                <button @click="reportsOpen = !reportsOpen"
                    class="sidebar-link w-full justify-between {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <span class="flex items-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <span class="ml-3">Reports</span>
                    </span>
                    <svg class="h-4 w-4 transform transition-transform" :class="reportsOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="reportsOpen" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.reports.dues') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.dues') || request()->routeIs('admin.reports.student-dues') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Pending Dues</span>
                    </a>
                    <a href="{{ route('admin.reports.fee-collection') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.fee-collection*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span>Fee Collection</span>
                    </a>
                    <a href="{{ route('admin.reports.students-by-class') }}"
                        class="sidebar-link text-sm {{ request()->routeIs('admin.reports.students-by-class*') ? 'active' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span>Students by Class</span>
                    </a>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-700/50">
                <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Settings
                </div>
                <a href="{{ route('admin.academic-sessions.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.academic-sessions.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Academic Sessions</span>
                </a>
                <a href="{{ route('admin.classes.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.sections.*') ? 'active' : '' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span>Classes & Sections</span>
                </a>
            </div>

            @if(auth()->user()->isSuperAdmin())
                <div class="pt-4 mt-4 border-t border-slate-700/50">
                    <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Super Admin
                    </div>
                    <a href="{{ route('admin.schools.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span>Manage Schools</span>
                    </a>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-700/50">
                    <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Website Content
                    </div>
                    <a href="{{ route('admin.gallery.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Gallery</span>
                    </a>
                    <a href="{{ route('admin.contact-submissions.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Contact Submissions</span>
                    </a>
                    <a href="{{ route('admin.public-reviews.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.public-reviews.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>Public Reviews</span>
                    </a>
                    <a href="{{ route('admin.background-music.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.background-music.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                            </path>
                        </svg>
                        <span>Background Music</span>
                    </a>
                    <a href="{{ route('admin.homepage-videos.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.homepage-videos.*') ? 'active' : '' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Homepage Videos</span>
                    </a>
                </div>
            @endif
        </nav>

        <!-- User Section (Bottom) -->
        <div class="border-t border-slate-700/50 px-3 py-4">
            <div class="flex items-center space-x-3 rounded-xl bg-slate-800/50 px-3 py-2">
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full gradient-primary text-xs font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>