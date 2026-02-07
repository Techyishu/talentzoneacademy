<x-layouts.admin>
    <x-slot name="title">Edit User - {{ $portalUser->name }}</x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Edit User</h1>
                <p class="mt-1 text-sm text-slate-600">Update portal account for {{ $portalUser->name }}</p>
            </div>
            <a href="{{ route('admin.portal-users.index') }}" class="text-slate-600 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        @if($errors->any())
            <div class="rounded-xl bg-red-50 p-4 border border-red-200">
                <ul class="list-disc list-inside text-sm text-red-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-premium p-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($portalUser->role === 'staff') bg-emerald-100 text-emerald-800
                @elseif($portalUser->role === 'student') bg-blue-100 text-blue-800
                @else bg-purple-100 text-purple-800
                @endif">
                {{ ucfirst($portalUser->role) }} Account
            </span>
            @if($portalUser->staff)
                <span class="ml-2 text-sm text-slate-500">Linked to: {{ $portalUser->staff->name }}
                    ({{ $portalUser->staff->staff_code }})</span>
            @elseif($portalUser->student)
                <span class="ml-2 text-sm text-slate-500">Linked to: {{ $portalUser->student->name }}
                    ({{ $portalUser->student->admission_no }})</span>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.portal-users.update', $portalUser) }}"
            class="card-premium p-6 space-y-6">
            @csrf
            @method('PUT')

            @if($portalUser->role === 'parent')
                <div x-data="{ 
                        children: [
                            @foreach($portalUser->children as $index => $child)
                                { id: '{{ $child->id }}', relationship: '{{ $child->pivot->relationship }}' }@if(!$loop->last),@endif
                            @endforeach
                            @if($portalUser->children->count() === 0)
                                { id: '', relationship: 'guardian' }
                            @endif
                        ] 
                    }">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Linked Children</label>
                    <div class="space-y-3">
                        <template x-for="(child, index) in children" :key="index">
                            <div class="flex gap-3 items-center">
                                <select :name="'children[' + index + ']'" x-model="child.id"
                                    class="flex-1 rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">-- Select Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }} ({{ $student->admission_no }}) -
                                            {{ $student->schoolClass?->name ?? $student->class }}
                                        </option>
                                    @endforeach
                                </select>
                                <select :name="'relationships[' + index + ']'" x-model="child.relationship"
                                    class="w-32 rounded-xl border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                    <option value="guardian">Guardian</option>
                                    <option value="other">Other</option>
                                </select>
                                <button type="button" @click="children.splice(index, 1)" x-show="children.length > 1"
                                    class="p-2 text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="children.push({ id: '', relationship: 'guardian' })"
                        class="mt-3 text-sm text-purple-600 hover:text-purple-700 font-medium">
                        + Add Another Child
                    </button>
                </div>
                <div class="border-t border-slate-200 pt-6"></div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $portalUser->name) }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $portalUser->email) }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password" minlength="8"
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-slate-500">Leave blank to keep current password</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.portal-users.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700">
                    Update User
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>