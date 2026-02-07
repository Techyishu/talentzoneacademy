<x-layouts.admin>
    <x-slot name="title">Create Academic Session</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Create Academic Session</h1>
                <p class="mt-1 text-sm text-slate-600">Add a new academic year or session</p>
            </div>
            <a href="{{ route('admin.academic-sessions.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Sessions
            </a>
        </div>

        <!-- Form Card -->
        <div class="card-premium p-8">
            <form method="POST" action="{{ route('admin.academic-sessions.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Session Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                            Session Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="e.g., 2025-2026"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('name') border-red-300 @enderror"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Enter the academic session name (e.g., "2025-2026" or "FY 2025-26")</p>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-slate-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('start_date') border-red-300 @enderror"
                        />
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-slate-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('end_date') border-red-300 @enderror"
                        />
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Current Session -->
                    <div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input
                                    id="is_current"
                                    name="is_current"
                                    type="checkbox"
                                    value="1"
                                    {{ old('is_current') ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                                />
                            </div>
                            <div class="ml-3">
                                <label for="is_current" class="text-sm font-medium text-slate-700">
                                    Set as Current Session
                                </label>
                                <p class="text-xs text-slate-500 mt-1">
                                    Mark this as the active academic session. All date-related features will use this session by default.
                                </p>
                            </div>
                        </div>
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
                                    If you mark this as the current session, any existing current session will be automatically unmarked.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4">
                        <a href="{{ route('admin.academic-sessions.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Academic Session
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
