<x-layouts.admin>
    <x-slot name="title">Edit Staff Member</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Edit Staff Member</h1>
                <p class="mt-1 text-sm text-slate-600">Update staff member information</p>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Staff
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" class="card-premium p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Photo Upload -->
                <x-admin.form.file-upload
                    label="Staff Photo"
                    name="photo"
                    accept="image/jpeg,image/jpg,image/png"
                    :preview="$staff->photo ? asset('storage/' . $staff->photo) : null"
                    help="Maximum file size: 2MB. Accepted formats: JPG, PNG"
                />

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.input
                            label="Staff Code"
                            name="staff_code"
                            :value="$staff->staff_code"
                            placeholder="e.g., STF001"
                            required
                        />

                        <x-admin.form.input
                            label="Full Name"
                            name="name"
                            :value="$staff->name"
                            placeholder="e.g., John Smith"
                            required
                        />

                        <x-admin.form.input
                            label="Designation"
                            name="designation"
                            :value="$staff->designation"
                            placeholder="e.g., Teacher, Principal, etc."
                            required
                        />

                        <x-admin.form.input
                            label="Phone Number"
                            name="phone"
                            type="tel"
                            :value="$staff->phone"
                            placeholder="e.g., 9876543210"
                            required
                        />
                    </div>
                </div>

                <!-- Employment Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Employment Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-admin.form.date-picker
                            label="Joining Date"
                            name="joining_date"
                            :value="$staff->joining_date"
                            :max="date('Y-m-d')"
                            required
                        />

                        <x-admin.form.input
                            label="Salary"
                            name="salary"
                            type="number"
                            step="0.01"
                            :value="$staff->salary"
                            placeholder="e.g., 50000"
                            help="Monthly salary (optional)"
                        />
                    </div>
                </div>

                <!-- Status -->
                <x-admin.form.select
                    label="Status"
                    name="status"
                    :options="['active' => 'Active', 'inactive' => 'Inactive']"
                    :value="$staff->status"
                    required
                />

                <!-- Show on Website -->
                <div class="flex items-center gap-3">
                    <input type="hidden" name="show_on_website" value="0">
                    <input type="checkbox" 
                        name="show_on_website" 
                        value="1"
                        id="show_on_website"
                        {{ $staff->show_on_website ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <label for="show_on_website" class="text-sm font-medium text-slate-700">
                        Show this staff member on the public website
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Staff Member
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
