<x-layouts.admin>
    <x-slot name="title">Import Students</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Import Students</h1>
                <p class="mt-1 text-sm text-slate-600">Bulk import students using CSV file</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Students
            </a>
        </div>

        <!-- Instructions Card -->
        <x-admin.alert type="info" :dismissible="false">
            <div class="space-y-2">
                <p class="font-semibold">Import Instructions:</p>
                <ol class="list-decimal list-inside space-y-1 text-sm">
                    <li>Download the CSV template using the button below</li>
                    <li>Fill in the student data following the format in the template</li>
                    <li>Upload the completed CSV file using the form below</li>
                    <li>Review any errors and correct them before re-importing</li>
                </ol>
            </div>
        </x-admin.alert>

        <!-- Download Template -->
        <div class="card-premium p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="rounded-xl bg-primary-100 p-3">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">CSV Template</h3>
                        <p class="text-sm text-slate-600">Download the template to get started</p>
                    </div>
                </div>
                <a href="{{ route('admin.students.import.template') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Template
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="card-premium p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Upload CSV File
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-16 h-16 mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-600 font-semibold">Click to upload CSV file</p>
                                <p class="text-xs text-slate-500">or drag and drop</p>
                                <p class="text-xs text-slate-400 mt-2">CSV or TXT (MAX. 10MB)</p>
                            </div>
                            <input
                                type="file"
                                name="csv_file"
                                accept=".csv,.txt"
                                class="hidden"
                                required
                                onchange="this.parentElement.querySelector('.file-name').textContent = this.files[0]?.name || 'No file chosen'"
                            />
                        </label>
                    </div>
                    <p class="file-name text-sm text-slate-600 mt-2 text-center">No file chosen</p>

                    @error('csv_file')
                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-accent-600 to-accent-500 hover:from-accent-700 hover:to-accent-600 shadow-lg shadow-accent-500/50 transition-all duration-200 hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Import Students
                    </button>
                </div>
            </div>
        </form>

        <!-- Sample Data Table -->
        <div class="card-premium p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Required Fields</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-slate-700">Field Name</th>
                            <th class="px-4 py-2 text-left font-semibold text-slate-700">Required</th>
                            <th class="px-4 py-2 text-left font-semibold text-slate-700">Format/Options</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Admission No</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">Must be unique per school</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Name</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">Student full name</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Gender</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">male, female, or other</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Date of Birth</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">YYYY-MM-DD format</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Class</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">e.g., 10, 11, 12</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Guardian Name</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">Parent/guardian name</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Guardian Phone</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Required</span></td>
                            <td class="px-4 py-2 text-slate-600">Contact number</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-slate-900">Section, Roll No, Address</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">Optional</span></td>
                            <td class="px-4 py-2 text-slate-600">Can be left empty</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
