<x-layouts.admin>
    <x-slot name="title">Salary Slips</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Salary Slips</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage staff salary slips</p>
            </div>
            <a href="{{ route('admin.salary-slips.create', ['month' => $month, 'year' => $year]) }}"
                class="inline-flex items-center px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white gradient-primary transition">
                <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Generate</span>
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 border border-green-200">
                <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4">
            <div class="card-premium p-3 sm:p-4">
                <p class="text-xs font-medium text-slate-500">Total</p>
                <p class="text-lg sm:text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
            </div>
            <div class="card-premium p-3 sm:p-4">
                <p class="text-xs font-medium text-slate-500">Paid</p>
                <p class="text-lg sm:text-2xl font-bold text-green-600">{{ $stats['paid'] }}</p>
            </div>
            <div class="card-premium p-3 sm:p-4">
                <p class="text-xs font-medium text-slate-500">Pending</p>
                <p class="text-lg sm:text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="card-premium p-3 sm:p-4">
                <p class="text-xs font-medium text-slate-500">Amount</p>
                <p class="text-lg sm:text-2xl font-bold text-blue-600">₹{{ number_format($stats['total_amount'], 0) }}
                </p>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" class="card-premium p-4">
            <div class="flex flex-wrap gap-2 sm:gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Month</label>
                    <select name="month" class="rounded-lg border-slate-300 text-sm">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('M', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Year</label>
                    <select name="year" class="rounded-lg border-slate-300 text-sm">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                    <select name="status" class="rounded-lg border-slate-300 text-sm">
                        <option value="">All</option>
                        <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="generated" {{ $status == 'generated' ? 'selected' : '' }}>Generated</option>
                        <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-3 py-2 bg-slate-800 text-white rounded-lg text-xs font-medium">Filter</button>
                </div>
            </div>
        </form>

        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-3">
            @forelse($salarySlips as $slip)
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $slip->staff->name ?? 'N/A' }}</h3>
                            <p class="text-xs text-slate-500">{{ $slip->slip_no }} • {{ $slip->period }}</p>
                            @if($slip->staff)
                            <p class="text-xs text-slate-400">{{ $slip->staff->designation }}</p>@endif
                        </div>
                        @php $statusColors = ['draft' => 'bg-slate-100 text-slate-700', 'generated' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700']; @endphp
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$slip->status] ?? 'bg-slate-100' }}">{{ ucfirst($slip->status) }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-3 pt-3 border-t border-slate-100 text-center">
                        <div>
                            <p class="text-xs text-slate-500">Gross</p>
                            <p class="text-sm font-medium text-slate-900">₹{{ number_format($slip->gross_salary, 0) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Deductions</p>
                            <p class="text-sm font-medium text-red-600">-₹{{ number_format($slip->total_deductions, 0) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Net</p>
                            <p class="text-sm font-bold text-slate-900">₹{{ number_format($slip->net_salary, 0) }}</p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('admin.salary-slips.show', $slip) }}"
                            class="text-xs text-primary-600 font-medium">View</a>
                        <a href="{{ route('admin.salary-slips.download', $slip) }}"
                            class="text-xs text-green-600 font-medium">PDF</a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border p-8 text-center">
                    <p class="text-sm text-slate-500">No salary slips found</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Slip No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Staff</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Period</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Gross</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Deductions</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Net</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-700 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($salarySlips as $slip)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $slip->slip_no }}</td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-slate-900">{{ $slip->staff->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $slip->staff->designation ?? '' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $slip->period }}</td>
                            <td class="px-4 py-3 text-sm text-right text-slate-900">
                                ₹{{ number_format($slip->gross_salary, 0) }}</td>
                            <td class="px-4 py-3 text-sm text-right text-red-600">
                                -₹{{ number_format($slip->total_deductions, 0) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-medium text-slate-900">
                                ₹{{ number_format($slip->net_salary, 0) }}</td>
                            <td class="px-4 py-3 text-center">
                                @php $statusColors = ['draft' => 'bg-slate-100 text-slate-700', 'generated' => 'bg-blue-100 text-blue-700', 'paid' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700']; @endphp<span
                                    class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$slip->status] ?? 'bg-slate-100' }}">{{ ucfirst($slip->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.salary-slips.show', $slip) }}"
                                        class="text-slate-600 hover:text-blue-600"><svg class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg></a>
                                    <a href="{{ route('admin.salary-slips.download', $slip) }}"
                                        class="text-slate-600 hover:text-green-600"><svg class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center text-slate-500">No salary slips found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($salarySlips->hasPages())
        <div class="mt-4">{{ $salarySlips->withQueryString()->links() }}</div>@endif
    </div>
</x-layouts.admin>