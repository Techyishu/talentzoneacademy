<x-layouts.admin>
    <x-slot name="title">Record Salary Advance</x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Record Advance</h1>
                <p class="mt-1 text-sm text-slate-600">Record a new salary advance for a staff member</p>
            </div>
            <a href="{{ route('admin.salary-advances.index') }}" class="text-slate-600 hover:text-slate-800">
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

        <form method="POST" action="{{ route('admin.salary-advances.store') }}" class="card-premium p-6 space-y-6">
            @csrf

            <div>
                <label for="staff_id" class="block text-sm font-medium text-slate-700 mb-1">Staff Member *</label>
                <select name="staff_id" id="staff_id" required class="block w-full rounded-xl border-slate-300">
                    <option value="">-- Select Staff --</option>
                    @foreach($staff as $member)
                        <option value="{{ $member->id }}" {{ old('staff_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} ({{ $member->staff_code }}) -
                            ₹{{ number_format($member->salary ?? 0, 0) }}/month
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Advance Amount *</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1"
                        step="0.01" class="block w-full rounded-xl border-slate-300" placeholder="0.00">
                </div>
                <div>
                    <label for="advance_date" class="block text-sm font-medium text-slate-700 mb-1">Advance Date
                        *</label>
                    <input type="date" name="advance_date" id="advance_date"
                        value="{{ old('advance_date', date('Y-m-d')) }}" required
                        class="block w-full rounded-xl border-slate-300">
                </div>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-slate-700 mb-1">Reason</label>
                <input type="text" name="reason" id="reason" value="{{ old('reason') }}"
                    class="block w-full rounded-xl border-slate-300" placeholder="e.g., Medical emergency">
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                <textarea name="notes" id="notes" rows="3" class="block w-full rounded-xl border-slate-300"
                    placeholder="Any additional notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                <p class="text-sm text-amber-700">
                    <strong>Note:</strong> This advance will be automatically deducted from future salary slips once
                    approved. Maximum 20% of gross salary will be recovered per month.
                </p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.salary-advances.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200">Cancel</a>
                <button type="submit"
                    class="px-6 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90">Record
                    Advance</button>
            </div>
        </form>
    </div>
</x-layouts.admin>