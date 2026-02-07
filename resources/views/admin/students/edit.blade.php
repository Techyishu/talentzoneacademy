@php
/**
 * @var \Illuminate\Database\Eloquent\Collection<\App\Models\SchoolClass> $classes
 * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Section> $sections
 * @var \App\Models\Student $student
 */
@endphp
<x-layouts.admin>
    <x-slot name="title">Edit Student</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Edit Student</h1>
                <p class="mt-1 text-sm text-slate-600">Update student information</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Students
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="card-premium p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Photo Upload -->
                <x-admin.form.file-upload
                    label="Student Photo"
                    name="photo"
                    accept="image/jpeg,image/jpg,image/png"
                    :preview="$student->photo ? asset('storage/' . $student->photo) : null"
                    help="Maximum file size: 2MB. Accepted formats: JPG, PNG"
                />

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.input
                            label="Admission Number"
                            name="admission_no"
                            :value="$student->admission_no"
                            placeholder="e.g., STU001"
                            required
                        />

                        <x-admin.form.input
                            label="Full Name"
                            name="name"
                            :value="$student->name"
                            placeholder="e.g., John Doe"
                            required
                        />

                        <x-admin.form.select
                            label="Gender"
                            name="gender"
                            :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']"
                            :value="$student->gender"
                            required
                        />

                        <x-admin.form.date-picker
                            label="Date of Birth"
                            name="dob"
                            :value="$student->dob"
                            :max="date('Y-m-d')"
                            required
                        />
                    </div>
                </div>

                <!-- Academic Information -->
                <div x-data="{
                    selectedClass: '{{ $student->class_id ?? '' }}',
                    selectedSection: '{{ $student->section_id ?? '' }}',
                    sections: {{ $sections->toJson() }},
                    async loadSections() {
                        if (!this.selectedClass) {
                            this.sections = [];
                            return;
                        }
                        try {
                            const response = await fetch(`/admin/classes/${this.selectedClass}/sections`);
                            const data = await response.json();
                            this.sections = data || [];
                        } catch (error) {
                            console.error('Error loading sections:', error);
                            this.sections = [];
                        }
                    }
                }">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Academic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
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
                            <select name="section_id" x-model="selectedSection" :disabled="!selectedClass || sections.length === 0"
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
                            :value="$student->roll_no"
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
                            :value="$student->guardian_name"
                            placeholder="e.g., Robert Doe"
                            required
                        />

                        <x-admin.form.input
                            label="Guardian Phone"
                            name="guardian_phone"
                            type="tel"
                            :value="$student->guardian_phone"
                            placeholder="e.g., 9876543210"
                            required
                        />
                    </div>
                </div>

                <!-- Address -->
                <x-admin.form.textarea
                    label="Address"
                    name="address"
                    :value="$student->address"
                    placeholder="Enter complete address"
                    rows="3"
                />

                <!-- Status -->
                <x-admin.form.select
                    label="Status"
                    name="status"
                    :options="['active' => 'Active', 'inactive' => 'Inactive']"
                    :value="$student->status"
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
                        Update Student
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
