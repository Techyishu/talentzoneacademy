<x-layouts.admin>
    <x-slot name="title">Add Students by Parent</x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Add Students by Parent</h1>
                <p class="mt-1 text-sm text-slate-600">Create a family account with multiple students</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Students
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.parent-students.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Step 1: Parent Information -->
            <div class="card-premium p-8">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-slate-900">Parent Information</h2>
                        <p class="text-sm text-slate-600">Enter the parent/guardian details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-admin.form.input
                        label="Parent Name"
                        name="parent_name"
                        placeholder="e.g., Robert Doe"
                        required
                    />

                    <x-admin.form.input
                        label="Parent Email"
                        name="parent_email"
                        type="email"
                        placeholder="e.g., parent@example.com"
                        required
                    />

                    <x-admin.form.input
                        label="Parent Phone"
                        name="parent_phone"
                        type="tel"
                        placeholder="e.g., 9876543210"
                        required
                    />
                </div>

                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        If this parent already exists, the students will be added to their existing account.
                    </p>
                </div>
            </div>

            <!-- Step 2: Students -->
            <div class="card-premium p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-bold">2</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-slate-900">Students</h2>
                            <p class="text-sm text-slate-600">Add at least one student</p>
                        </div>
                    </div>
                    <button type="button" id="add-student-btn" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Another Student
                    </button>
                </div>

                <div id="students-container" class="space-y-6">
                    <!-- Student 1 (template) -->
                    <div class="student-form-row relative bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-6 border border-slate-200" data-student-index="0">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Student 1</h3>
                            <button type="button" class="remove-student-btn hidden text-red-600 hover:text-red-800 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.form.input
                                label="Admission Number"
                                name="students[0][admission_no]"
                                placeholder="e.g., STU001"
                                required
                            />

                            <x-admin.form.input
                                label="Student Name"
                                name="students[0][name]"
                                placeholder="e.g., John Doe"
                                required
                            />

                            <x-admin.form.select
                                label="Gender"
                                name="students[0][gender]"
                                :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']"
                                placeholder="Select gender"
                                required
                            />

                            <x-admin.form.date-picker
                                label="Date of Birth"
                                name="students[0][dob]"
                                :max="date('Y-m-d')"
                                required
                            />

                            <x-admin.form.select
                                label="Class"
                                name="students[0][class_id]"
                                :options="$classes->pluck('name', 'id')"
                                placeholder="Select class"
                                required
                            />

                            <x-admin.form.select
                                label="Relationship"
                                name="students[0][relationship]"
                                :options="['father' => 'Father', 'mother' => 'Mother', 'guardian' => 'Guardian', 'other' => 'Other']"
                                placeholder="Select relationship"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="card-premium p-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600">
                        <strong>Note:</strong> A parent portal account will be created automatically.
                    </p>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Create Family Account & Students
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let studentCount = 1;

        // Add student button
        document.getElementById('add-student-btn').addEventListener('click', function() {
            const container = document.getElementById('students-container');
            const template = container.querySelector('.student-form-row');
            const clone = template.cloneNode(true);

            // Update index and labels
            clone.dataset.studentIndex = studentCount;
            clone.querySelector('h3').textContent = `Student ${studentCount + 1}`;

            // Update all input names
            clone.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[0\]/g, `[${studentCount}]`);
                    input.value = '';
                }
                if (input.id) {
                    input.id = input.id.replace(/_0/g, `_${studentCount}`);
                }
            });

            // Show remove button
            clone.querySelector('.remove-student-btn').classList.remove('hidden');

            container.appendChild(clone);
            studentCount++;

            // Update all remove buttons
            updateRemoveButtons();
        });

        // Remove student
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-student-btn')) {
                const row = e.target.closest('.student-form-row');
                row.remove();
                renumberStudents();
                updateRemoveButtons();
            }
        });

        function renumberStudents() {
            document.querySelectorAll('.student-form-row').forEach((row, index) => {
                row.dataset.studentIndex = index;
                row.querySelector('h3').textContent = `Student ${index + 1}`;

                // Update input names
                row.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/\[\d+\]/g, `[${index}]`);
                    }
                });
            });
            studentCount = document.querySelectorAll('.student-form-row').length;
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.student-form-row');
            rows.forEach((row, index) => {
                const removeBtn = row.querySelector('.remove-student-btn');
                if (rows.length > 1) {
                    removeBtn.classList.remove('hidden');
                } else {
                    removeBtn.classList.add('hidden');
                }
            });
        }
    </script>
    @endpush
</x-layouts.admin>
