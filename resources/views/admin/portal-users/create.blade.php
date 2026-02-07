<x-layouts.admin>
    <x-slot name="title">Create {{ ucfirst($type) }} User</x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Create {{ ucfirst($type) }} User</h1>
                <p class="mt-1 text-sm text-slate-600">Create a new portal account for
                    {{ $type === 'parent' ? 'a parent' : ($type === 'staff' ? 'a staff member' : 'a student') }}</p>
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

        <!-- Type Tabs -->
        <div class="flex gap-2">
            <a href="{{ route('admin.portal-users.create', ['type' => 'staff']) }}"
                class="px-4 py-2 rounded-lg font-medium {{ $type === 'staff' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Staff</a>
            <a href="{{ route('admin.portal-users.create', ['type' => 'student']) }}"
                class="px-4 py-2 rounded-lg font-medium {{ $type === 'student' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Student</a>
            <a href="{{ route('admin.portal-users.create', ['type' => 'parent']) }}"
                class="px-4 py-2 rounded-lg font-medium {{ $type === 'parent' ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Parent</a>
        </div>

        <form method="POST" action="{{ route('admin.portal-users.store') }}" class="card-premium p-6 space-y-6">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            @if($type === 'staff')
                <div>
                    <label for="staff_id" class="block text-sm font-medium text-slate-700 mb-1">Select Staff Member
                        *</label>
                    @if($staff->count() > 0)
                        <select name="staff_id" id="staff_id" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Select Staff --</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}" {{ old('staff_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->staff_code }}) - {{ $member->designation ?? 'Staff' }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-amber-600 bg-amber-50 p-3 rounded-lg">All staff members already have accounts or
                            no staff exists.</p>
                    @endif
                </div>
            @elseif($type === 'student')
                <div>
                    <label for="student_id" class="block text-sm font-medium text-slate-700 mb-1">Select Student *</label>
                    @if($students->count() > 0)
                        <select name="student_id" id="student_id" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->admission_no }}) - {{ $student->class }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-amber-600 bg-amber-50 p-3 rounded-lg">All students already have accounts or no
                            students exist.</p>
                    @endif
                </div>
            @elseif($type === 'parent')
                <div x-data="{ children: [{ id: '', relationship: 'guardian' }] }">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Link Children *</label>
                    <div class="space-y-3" id="children-container">
                        <template x-for="(child, index) in children" :key="index">
                            <div class="flex gap-3 items-center">
                                <select :name="'children[' + index + ']'" x-model="child.id" required
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
            @endif

            <div class="border-t border-slate-200 pt-6 space-y-4">
                <h3 class="text-lg font-medium text-slate-900">Account Details</h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password *</label>
                    <input type="password" name="password" id="password" required minlength="8"
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-slate-500">Minimum 8 characters</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm
                        Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.portal-users.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-6 py-2 rounded-xl text-sm font-semibold text-white 
                    @if($type === 'staff') bg-emerald-600 hover:bg-emerald-700
                    @elseif($type === 'student') bg-blue-600 hover:bg-blue-700
                    @else bg-purple-600 hover:bg-purple-700
                    @endif">
                    Create User
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>