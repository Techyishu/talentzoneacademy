<x-layouts.admin>
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.schools.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-150">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $school->name }}</h1>
                    <p class="mt-1 text-sm text-gray-600">School code: {{ $school->code }}</p>
                </div>
            </div>
            <a href="{{ route('admin.schools.edit', $school) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit School
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <x-admin.stat-card
                title="Students"
                :value="$stats['students']"
                color="indigo"
                icon="users"
            />
            <x-admin.stat-card
                title="Staff"
                :value="$stats['staff']"
                color="emerald"
                icon="users"
            />
            <x-admin.stat-card
                title="Users"
                :value="$stats['users']"
                color="amber"
                icon="user-circle"
            />
            <x-admin.stat-card
                title="Pages"
                :value="$stats['pages']"
                color="purple"
                icon="document-text"
            />
            <x-admin.stat-card
                title="Gallery Images"
                :value="$stats['gallery_images']"
                color="pink"
                icon="photograph"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- School Information -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">School Information</h2>

                <div class="space-y-4">
                    @if($school->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <div class="inline-block p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }}" class="h-24 object-contain">
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">School Code</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $school->code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Receipt Prefix</label>
                            <p class="mt-1"><code class="text-sm bg-gray-100 px-2 py-1 rounded font-mono">{{ $school->receipt_prefix }}</code></p>
                        </div>
                    </div>

                    @if($school->email || $school->phone)
                        <div class="grid grid-cols-1 gap-3">
                            @if($school->email)
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a href="mailto:{{ $school->email }}" class="text-sm hover:text-indigo-600">{{ $school->email }}</a>
                                </div>
                            @endif
                            @if($school->phone)
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-sm">{{ $school->phone }}</span>
                                </div>
                            @endif
                            @if($school->website)
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <a href="{{ $school->website }}" target="_blank" class="text-sm hover:text-indigo-600">{{ $school->website }}</a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($school->address)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $school->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Branding -->
            <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Branding</h2>

                <div class="space-y-4">
                    @if($school->primary_color || $school->secondary_color)
                        <div class="grid grid-cols-2 gap-4">
                            @if($school->primary_color)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 h-12 rounded-lg border-2 border-gray-300 shadow-sm" style="background-color: {{ $school->primary_color }}"></div>
                                        <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $school->primary_color }}</code>
                                    </div>
                                </div>
                            @endif
                            @if($school->secondary_color)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 h-12 rounded-lg border-2 border-gray-300 shadow-sm" style="background-color: {{ $school->secondary_color }}"></div>
                                        <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $school->secondary_color }}</code>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($school->signature_image)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Signature (for receipts)</label>
                            <div class="inline-block p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <img src="{{ asset('storage/' . $school->signature_image) }}" alt="Signature" class="h-16 object-contain">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">School Users</h2>
                <span class="text-sm text-gray-600">{{ $school->users->count() }} {{ Str::plural('user', $school->users->count()) }}</span>
            </div>

            @if($school->users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($school->users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center text-gray-500">
                    No users assigned to this school yet.
                </div>
            @endif
        </div>

        <!-- Timestamps -->
        <div class="bg-white/70 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Created:</span> {{ $school->created_at->format('M d, Y \a\t g:i A') }}
                </div>
                <div>
                    <span class="font-medium">Last Updated:</span> {{ $school->updated_at->format('M d, Y \a\t g:i A') }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
