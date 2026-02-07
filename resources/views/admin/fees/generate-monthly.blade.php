<x-layouts.admin>
    <x-slot name="title">Generate Monthly Fees</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Generate Monthly Fees</h1>
                <p class="mt-1 text-sm text-slate-600">Generate monthly fee installments for students based on their class fee structures</p>
            </div>
        </div>

        <!-- Information Card -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-400 p-6 rounded-lg">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">How Monthly Fee Generation Works</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Generates fee balances for all active students in the selected session</li>
                        <li>• Automatically converts annual and quarterly fees to monthly amounts</li>
                        <li>• <strong>Monthly fees:</strong> Full amount | <strong>Quarterly:</strong> Amount ÷ 3 | <strong>Annual:</strong> Amount ÷ 12</li>
                        <li>• Idempotent: Running the same month multiple times won't create duplicates</li>
                        <li>• Family balances are automatically recalculated for all parents</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Generation Form -->
        <form action="{{ route('admin.fees.generate-monthly') }}" method="POST" class="card-premium p-8">
            @csrf

            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-slate-900 pb-2 border-b border-slate-200">Fee Generation Parameters</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Academic Session -->
                    <div>
                        <label for="session_id" class="block text-sm font-semibold text-slate-700 mb-2">
                            Academic Session <span class="text-red-500">*</span>
                        </label>
                        <select name="session_id"
                                id="session_id"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('session_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Session</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}" {{ $currentSession && $currentSession->id == $session->id ? 'selected' : '' }}>
                                    {{ $session->name }}
                                    @if($session->is_current)
                                        <span>(Current)</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('session_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Select the academic session for which to generate fees</p>
                    </div>

                    <!-- Month -->
                    <div>
                        <label for="month" class="block text-sm font-semibold text-slate-700 mb-2">
                            Month <span class="text-red-500">*</span>
                        </label>
                        <select name="month"
                                id="month"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm @error('month') border-red-500 @enderror"
                                required>
                            <option value="">Select Month</option>
                            @foreach($months as $value => $name)
                                <option value="{{ $value }}" {{ date('n') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('month')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Select the month for which to generate fees</p>
                    </div>
                </div>

                <!-- Preview Section -->
                <div id="preview-section" style="display: none;" class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Generation Preview</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-600">Session:</span>
                            <span class="font-medium text-slate-900" id="preview-session">-</span>
                        </div>
                        <div>
                            <span class="text-slate-600">Month:</span>
                            <span class="font-medium text-slate-900" id="preview-month">-</span>
                        </div>
                    </div>
                </div>

                <!-- Warning Notice -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-medium">Important:</p>
                            <p class="mt-1">This action will generate fees for <strong>all active students</strong> in the selected session. Ensure that fee structures are properly configured before proceeding.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border-2 border-slate-300 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Generate Monthly Fees
                    </button>
                </div>
            </div>
        </form>

        <!-- Recent Generations Log (Optional Enhancement) -->
        <div class="card-premium p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Tips for Fee Generation</h3>
            <div class="space-y-3 text-sm text-slate-600">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p><strong>Best Practice:</strong> Generate fees at the beginning of each month before collecting payments</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p><strong>Safe to Re-run:</strong> Running generation for the same month won't create duplicate fees</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p><strong>Prerequisites:</strong> Ensure students are assigned to classes and fee structures are configured</p>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p><strong>Automation:</strong> You can schedule this via cron to run automatically on the 1st of each month</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update preview when session or month changes
        document.getElementById('session_id').addEventListener('change', updatePreview);
        document.getElementById('month').addEventListener('change', updatePreview);

        function updatePreview() {
            const sessionSelect = document.getElementById('session_id');
            const monthSelect = document.getElementById('month');
            const previewSection = document.getElementById('preview-section');

            if (sessionSelect.value && monthSelect.value) {
                const sessionText = sessionSelect.options[sessionSelect.selectedIndex].text;
                const monthText = monthSelect.options[monthSelect.selectedIndex].text;

                document.getElementById('preview-session').textContent = sessionText;
                document.getElementById('preview-month').textContent = monthText;

                previewSection.style.display = 'block';
            } else {
                previewSection.style.display = 'none';
            }
        }
    </script>
    @endpush
</x-layouts.admin>
