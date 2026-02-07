<x-layouts.admin>
    <x-slot name="title">Salary Slip - {{ $salarySlip->slip_no }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Salary Slip</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $salarySlip->slip_no }} • {{ $salarySlip->period }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.salary-slips.download', $salarySlip) }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('admin.salary-slips.index') }}" class="text-slate-600 hover:text-slate-800 p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Status Badge -->
        <div class="card-premium p-4 flex items-center justify-between">
            @php
                $statusColors = [
                    'draft' => 'bg-slate-100 text-slate-700',
                    'generated' => 'bg-blue-100 text-blue-700',
                    'paid' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
            @endphp
            <span
                class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$salarySlip->status] ?? 'bg-slate-100 text-slate-700' }}">
                {{ ucfirst($salarySlip->status) }}
            </span>
            @if($salarySlip->status === 'paid')
                <span class="text-sm text-slate-500">Paid on {{ $salarySlip->payment_date?->format('d M Y') }} via
                    {{ ucfirst($salarySlip->payment_mode) }}</span>
            @endif
        </div>

        <!-- Staff Info -->
        <div class="card-premium p-6">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Staff Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-slate-500">Name</p>
                    <p class="font-medium text-slate-900">{{ $salarySlip->staff->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Staff Code</p>
                    <p class="font-medium text-slate-900">{{ $salarySlip->staff->staff_code ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Designation</p>
                    <p class="font-medium text-slate-900">{{ $salarySlip->staff->designation ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Period</p>
                    <p class="font-medium text-slate-900">{{ $salarySlip->period }}</p>
                </div>
            </div>
        </div>

        <!-- Earnings & Deductions -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Earnings -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Earnings</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Basic Salary</span>
                        <span class="font-medium">₹{{ number_format($salarySlip->basic_salary, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Allowances</span>
                        <span class="font-medium">₹{{ number_format($salarySlip->allowances, 2) }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between font-semibold">
                        <span>Gross Salary</span>
                        <span class="text-green-600">₹{{ number_format($salarySlip->gross_salary, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Deductions -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Deductions</h3>
                <div class="space-y-3">
                    @forelse($salarySlip->deductions as $deduction)
                        <div class="flex justify-between">
                            <span class="text-slate-600">{{ $deduction->description }}</span>
                            <span class="font-medium text-red-600">-₹{{ number_format($deduction->amount, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm">No deductions</p>
                    @endforelse
                    <div class="border-t pt-3 flex justify-between font-semibold">
                        <span>Total Deductions</span>
                        <span class="text-red-600">-₹{{ number_format($salarySlip->total_deductions, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Salary -->
        <div class="card-premium p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <span class="text-lg font-medium text-slate-900">Net Salary</span>
                <span class="text-3xl font-bold text-blue-600">₹{{ number_format($salarySlip->net_salary, 2) }}</span>
            </div>
        </div>

        <!-- Actions -->
        @if($salarySlip->status === 'generated')
            <div class="card-premium p-6">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Mark as Paid</h3>
                <form method="POST" action="{{ route('admin.salary-slips.mark-paid', $salarySlip) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Date</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required
                                class="block w-full rounded-xl border-slate-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Mode</label>
                            <select name="payment_mode" required class="block w-full rounded-xl border-slate-300">
                                <option value="bank">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                                <option value="upi">UPI</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Reference (Optional)</label>
                            <input type="text" name="payment_reference" class="block w-full rounded-xl border-slate-300"
                                placeholder="Transaction ID">
                        </div>
                    </div>
                    <button type="submit"
                        class="px-6 py-2 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700">
                        Mark as Paid
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-layouts.admin>