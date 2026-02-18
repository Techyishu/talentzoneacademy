@php
/** @var \Illuminate\Database\Eloquent\Collection<\App\Models\SchoolClass> $classes */
@endphp
<x-layouts.admin>
    <x-slot name="title">Add Student</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Add New Student</h1>
                <p class="mt-1 text-sm text-slate-600">Fill in the student information below</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Students
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="card-premium p-8">
            @csrf

            <div class="space-y-6">
                <!-- Photo Upload -->
                <x-admin.form.file-upload
                    label="Student Photo"
                    name="photo"
                    accept="image/jpeg,image/jpg,image/png"
                    help="Maximum file size: 2MB. Accepted formats: JPG, PNG"
                />

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.input
                            label="Admission Number"
                            name="admission_no"
                            placeholder="e.g., STU001"
                            required
                        />

                        <x-admin.form.input
                            label="Full Name"
                            name="name"
                            placeholder="e.g., John Doe"
                            required
                        />

                        <x-admin.form.select
                            label="Gender"
                            name="gender"
                            :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']"
                            placeholder="Select gender"
                            required
                        />

                        <x-admin.form.date-picker
                            label="Date of Birth"
                            name="dob"
                            :max="date('Y-m-d')"
                            required
                        />
                    </div>
                </div>

                <!-- Academic Information -->
                <div x-data="{
                    selectedClass: '',
                    sections: [],
                    async loadSections() {
                        if (!this.selectedClass) {
                            this.sections = [];
                            return;
                        }
                        try {
                            const response = await fetch(`/admin/classes/${this.selectedClass}/sections`);
                            const data = await response.json();
                            // Assuming API returns sections array
                            this.sections = data.sections || data || [];
                        } catch (error) {
                            console.error('Error loading sections:', error);
                            this.sections = [];
                        }
                    }
                }">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Academic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label  class="block text-sm font-medium text-slate-700 mb-1">
                                Class <span class="text-red-500">*</span>
                            </label>
                            <select name="class_id" x-model="selectedClass" @change="loadSections()" required
                                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Select class</option>
                                @foreach($classes as $schoolClass)
                                    <option value="{{ $schoolClass->id }}">{{ $schoolClass->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Section</label>
                            <select name="section_id" :disabled="!selectedClass || sections.length === 0"
                                class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-slate-100 disabled:cursor-not-allowed">
                                <option value="">Select section</option>
                                <template x-for="section in sections" :key="section.id">
                                    <option :value="section.id" x-text="section.name"></option>
                                </template>
                            </select>
                            <p class="mt-1 text-xs text-slate-500" x-show="!selectedClass">Select a class first</p>
                        </div>

                        <x-admin.form.input
                            label="Roll Number"
                            name="roll_no"
                            type="number"
                            placeholder="e.g., 1"
                        />
                    </div>
                </div>

                <!-- Guardian Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Guardian Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.input
                            label="Guardian Name"
                            name="guardian_name"
                            placeholder="e.g., Robert Doe"
                            required
                        />

                        <x-admin.form.input
                            label="Guardian Phone"
                            name="guardian_phone"
                            type="tel"
                            placeholder="e.g., 9876543210"
                            required
                        />
                    </div>
                </div>

                <!-- Parent Account Linking (Optional) -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Parent Account Linking (Optional)
                            </h3>
                            <p class="mt-1 text-sm text-slate-600">Link this student to a parent account for consolidated family fee payments</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="link_parent" name="link_parent" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div id="parent-fields" style="display: none;" class="space-y-4 mt-4 pt-4 border-t border-blue-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.form.input
                                label="Parent Name"
                                name="parent_name"
                                placeholder="e.g., Robert Doe"
                            />

                            <x-admin.form.select
                                label="Relationship"
                                name="relationship"
                                :options="['father' => 'Father', 'mother' => 'Mother', 'guardian' => 'Guardian', 'other' => 'Other']"
                                placeholder="Select relationship"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-admin.form.input
                                    label="Parent Email"
                                    name="parent_email"
                                    type="email"
                                    placeholder="e.g., parent@example.com"
                                />
                                <p class="mt-1 text-xs text-slate-500">Will be used for login if account is created</p>
                            </div>

                            <x-admin.form.input
                                label="Parent Phone"
                                name="parent_phone"
                                type="tel"
                                placeholder="e.g., 9876543210"
                            />
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="create_parent_account" name="create_parent_account" value="1" checked class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="create_parent_account" class="ml-2 text-sm font-medium text-slate-900">
                                Create parent portal account
                            </label>
                        </div>

                        <div class="bg-blue-100 border border-blue-200 rounded-lg p-3">
                            <p class="text-sm text-blue-800">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Note:</strong> If this parent already exists in the system, the student will be linked to the existing account.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <x-admin.form.textarea
                    label="Address"
                    name="address"
                    placeholder="Enter complete address"
                    rows="3"
                />

                <!-- Status -->
                <x-admin.form.select
                    label="Status"
                    name="status"
                    :options="['active' => 'Active', 'inactive' => 'Inactive']"
                    value="active"
                    required
                />

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Student
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Toggle parent fields visibility and disable when hidden
        const linkParentCheckbox = document.getElementById('link_parent');
        const parentFields = document.getElementById('parent-fields');

        function toggleParentFields() {
            if (linkParentCheckbox.checked) {
                parentFields.style.display = 'block';
                parentFields.querySelectorAll('input, select').forEach(el => el.disabled = false);
            } else {
                parentFields.style.display = 'none';
                parentFields.querySelectorAll('input, select').forEach(el => el.disabled = true);
            }
        }

        linkParentCheckbox.addEventListener('change', toggleParentFields);
        // Run on page load to handle validation errors (form re-render)
        toggleParentFields();
    </script>
    @endpush
</x-layouts.admin>
