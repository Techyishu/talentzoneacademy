<x-layouts.admin>
    <x-slot name="title">Generate Salary Slips</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Generate Salary Slips</h1>
                <p class="mt-1 text-sm text-slate-600">Select staff members to generate salary slips</p>
            </div>
            <a href="{{ route('admin.salary-slips.index') }}" class="text-slate-600 hover:text-slate-800">
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

        <form method="POST" action="{{ route('admin.salary-slips.store') }}" class="space-y-6"
            x-data="{ selectAll: false }">
            @csrf

            <!-- Period Selection -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Select Period</h3>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="month" class="block text-sm font-medium text-slate-700 mb-1">Month</label>
                        <select name="month" id="month" class="block w-full rounded-xl border-slate-300">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="year" class="block text-sm font-medium text-slate-700 mb-1">Year</label>
                        <select name="year" id="year" class="block w-full rounded-xl border-slate-300">
                            @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <!-- Staff Selection -->
            <div class="card-premium p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-slate-900">Select Staff</h3>
                    <label class="flex items-center text-sm">
                        <input type="checkbox" x-model="selectAll"
                            @change="$refs.staffTable.querySelectorAll('input[name=\'staff_ids[]\']').forEach(el => el.checked = selectAll)"
                            class="rounded border-slate-300 text-blue-600 mr-2">
                        Select All
                    </label>
                </div>

                @if($staff->count() > 0)
                    <div class="overflow-hidden rounded-xl border border-slate-200" x-ref="staffTable">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase w-10">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Staff
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">
                                        Designation</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Basic
                                        Salary</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase w-32">
                                        Allowances</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($staff as $member)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="staff_ids[]" value="{{ $member->id }}"
                                                class="rounded border-slate-300 text-blue-600">
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="text-sm font-medium text-slate-900">{{ $member->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $member->staff_code }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $member->designation ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-slate-900">
                                            ₹{{ number_format($member->salary ?? 0, 2) }}</td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="allowances[{{ $member->id }}]" value="0" min="0"
                                                step="0.01" class="w-full text-sm text-right rounded-lg border-slate-300">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <p>All active staff already have salary slips for this period.</p>
                        <p class="text-sm mt-2">Try selecting a different month/year.</p>
                    </div>
                @endif
            </div>

            @if($staff->count() > 0)
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.salary-slips.index') }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90">Generate
                        Slips</button>
                </div>
            @endif
        </form>
    </div>
</x-layouts.admin>