<x-layouts.parent>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="card-premium p-6">
            <h1 class="text-2xl font-bold text-slate-900">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-slate-600 mt-1">Monitor your children's academic progress and fee payments.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="card-premium p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-purple-100">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Linked Children</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $children->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Fee Paid</p>
                        <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalFeePaid, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Children Cards -->
        <div>
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Your Children</h2>
            
            @if($children->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($childrenData as $data)
                        @php $child = $data['student']; @endphp
                        <div class="card-premium p-6">
                            <div class="flex items-start">
                                @if($child->photo)
                                    <img src="{{ asset('uploads/photos/' . $child->photo) }}" alt="{{ $child->name }}" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                                        {{ strtoupper(substr($child->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $child->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $child->schoolClass?->name ?? $child->class }} {{ $child->schoolSection ? '- ' . $child->schoolSection->name : '' }}</p>
                                    <p class="text-sm text-slate-500">{{ $child->admission_no }}</p>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="text-center p-2 bg-green-50 rounded-lg">
                                    <p class="text-xs text-slate-500">Present</p>
                                    <p class="text-lg font-bold text-green-600">{{ $data['attendance']['present'] }}</p>
                                </div>
                                <div class="text-center p-2 bg-red-50 rounded-lg">
                                    <p class="text-xs text-slate-500">Absent</p>
                                    <p class="text-lg font-bold text-red-600">{{ $data['attendance']['absent'] }}</p>
                                </div>
                                <div class="text-center p-2 bg-blue-50 rounded-lg">
                                    <p class="text-xs text-slate-500">Fee Paid</p>
                                    <p class="text-lg font-bold text-blue-600">₹{{ number_format($data['fee_paid']) }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('parent.children.show', $child) }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 text-sm font-medium">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-premium p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">No Children Linked</h3>
                    <p class="text-slate-500">Please contact the school administration to link your children to your account.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.parent>
