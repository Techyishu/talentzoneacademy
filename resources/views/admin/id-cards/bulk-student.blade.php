<x-layouts.admin>
    <x-slot name="title">Generate Bulk Student ID Cards</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Generate Bulk ID Cards</h1>
                <p class="mt-1 text-sm text-slate-600">Select class and section to generate ID cards for all students</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Students
            </a>
        </div>

        <!-- Form Card -->
        <div class="card-premium p-8">
            <form method="POST" action="{{ route('admin.id-cards.bulk-student') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Class Selection -->
                    <div>
                        <label for="class" class="block text-sm font-medium text-slate-700 mb-2">
                            Class <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="class"
                            name="class"
                            required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('class') border-red-300 @enderror"
                        >
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}" {{ old('class') == $class ? 'selected' : '' }}>
                                    Class {{ $class }}
                                </option>
                            @endforeach
                        </select>
                        @error('class')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Section Selection (Optional) -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-slate-700 mb-2">
                            Section <span class="text-xs text-slate-500">(Optional - leave blank for all sections)</span>
                        </label>
                        <select
                            id="section"
                            name="section"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        >
                            <option value="">-- All Sections --</option>
                            <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>Section A</option>
                            <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>Section B</option>
                            <option value="C" {{ old('section') == 'C' ? 'selected' : '' }}>Section C</option>
                            <option value="D" {{ old('section') == 'D' ? 'selected' : '' }}>Section D</option>
                        </select>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="rounded-xl bg-primary-50 border border-primary-200 p-4">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-primary-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-primary-900">Note</h3>
                                <div class="mt-1 text-sm text-primary-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Only active students will be included</li>
                                        <li>ID cards will be generated in PDF format</li>
                                        <li>Multiple ID cards will be included in a single PDF file</li>
                                        <li>The PDF can be printed directly</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate ID Cards PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
