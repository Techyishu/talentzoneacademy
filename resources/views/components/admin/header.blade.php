<div class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <!-- Mobile Menu Button -->
    <button @click="sidebarOpen = true" type="button" class="text-slate-700 lg:hidden">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <!-- Breadcrumb / Page Title -->
    <div class="flex flex-1 items-center gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex-1">
            @if (isset($breadcrumbs))
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="flex items-center">
                                @if(!$loop->first)
                                    <svg class="h-5 w-5 flex-shrink-0 text-slate-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <a href="{{ $breadcrumb['url'] ?? '#' }}" class="text-sm font-medium {{ $loop->last ? 'text-slate-900' : 'text-slate-500 hover:text-slate-700' }}">
                                    {{ $breadcrumb['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif
        </div>
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center gap-x-4 lg:gap-x-6">
        <!-- School Switcher (Super Admin Only) -->
        @if(auth()->user()->isSuperAdmin())
            @php
                $schools = \App\Models\School::where('status', 'active')->get();
                $activeSchool = session('active_school_id') ? \App\Models\School::find(session('active_school_id')) : null;
            @endphp

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="flex items-center space-x-2 rounded-xl bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 transition-colors">
                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>{{ $activeSchool ? $activeSchool->name : 'Select School' }}</span>
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open"
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-64 origin-top-right rounded-xl glass-card border border-slate-200 shadow-xl"
                     style="display: none;">
                    <div class="py-2">
                        <div class="px-4 py-2 border-b border-slate-200">
                            <p class="text-xs font-semibold text-slate-500 uppercase">Switch School</p>
                        </div>
                        @foreach($schools as $school)
                            <form method="POST" action="{{ route('admin.switch-school') }}" class="block">
                                @csrf
                                <input type="hidden" name="school_id" value="{{ $school->id }}">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm flex items-center space-x-3 {{ $activeSchool && $activeSchool->id == $school->id ? 'bg-primary-50 text-primary-700' : 'text-slate-700 hover:bg-slate-50' }}">
                                    @if($school->logo)
                                        <img src="{{ asset('uploads/logos/' . $school->logo) }}" alt="{{ $school->name }}" class="h-8 w-8 rounded object-cover">
                                    @else
                                        <div class="h-8 w-8 rounded gradient-primary flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($school->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $school->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $school->code }}</p>
                                    </div>
                                    @if($activeSchool && $activeSchool->id == $school->id)
                                        <svg class="h-5 w-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- User Menu Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center space-x-2">
                <div class="h-9 w-9 rounded-full gradient-primary flex items-center justify-center text-white text-sm font-semibold ring-2 ring-white shadow">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'School Admin' }}</p>
                </div>
                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl glass-card border border-slate-200 shadow-xl"
                 style="display: none;">
                <div class="py-2">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Your Profile</span>
                        </div>
                    </a>

                    <div class="border-t border-slate-200 my-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <div class="flex items-center space-x-3">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Sign out</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
