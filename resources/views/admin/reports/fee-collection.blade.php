<x-layouts.admin>
    <x-slot name="title">Fee Collection Summary</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Fee Collection Summary</h1>
                <p class="mt-1 text-sm text-slate-600">View fee collection by date range and payment mode</p>
            </div>
            @if($totalReceipts > 0)
                <a href="{{ route('admin.reports.fee-collection.export', ['from_date' => $fromDate, 'to_date' => $toDate, 'payment_mode' => $paymentMode]) }}"
                    class="inline-flex items-center px-4 py-2 border-2 border-accent-300 rounded-xl text-sm font-semibold text-accent-700 bg-accent-50 hover:bg-accent-100 transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export to Excel
                </a>
            @endif
        </div>

        <!-- Filters -->
        <div class="card-premium p-6">
            <form method="GET" action="{{ route('admin.reports.fee-collection') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- From Date -->
                    <div>
                        <label for="from_date" class="block text-sm font-medium text-slate-700 mb-1">From Date</label>
                        <input type="date" name="from_date" id="from_date" value="{{ $fromDate }}"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>

                    <!-- To Date -->
                    <div>
                        <label for="to_date" class="block text-sm font-medium text-slate-700 mb-1">To Date</label>
                        <input type="date" name="to_date" id="to_date" value="{{ $toDate }}"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>

                    <!-- Payment Mode Filter -->
                    <div>
                        <label for="payment_mode" class="block text-sm font-medium text-slate-700 mb-1">Payment
                            Mode</label>
                        <select name="payment_mode" id="payment_mode"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            <option value="">All Modes</option>
                            <option value="cash" {{ $paymentMode == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="cheque" {{ $paymentMode == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="online" {{ $paymentMode == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="card" {{ $paymentMode == 'card' ? 'selected' : '' }}>Card</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg transition-all">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Collection</p>
                        <p class="text-2xl font-bold text-green-600">₹{{ number_format($grandTotal, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-xl p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Receipts</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalReceipts }}</p>
                    </div>
                </div>
            </div>

            @foreach($totalsByMode as $modeTotal)
                <div class="card-premium p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-xl p-3">
                            @if($modeTotal->payment_mode == 'cash')
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            @elseif($modeTotal->payment_mode == 'online')
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-500">{{ ucfirst($modeTotal->payment_mode) }}</p>
                            <p class="text-xl font-bold text-slate-900">₹{{ number_format($modeTotal->total, 2) }}</p>
                            <p class="text-xs text-slate-500">{{ $modeTotal->count }} receipts</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Collection by Fee Head -->
            @if($collectionByFeeHead->count() > 0)
                <div class="card-premium p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Collection by Fee Head</h3>
                    <div class="space-y-3">
                        @foreach($collectionByFeeHead as $feeHead)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-700">{{ $feeHead->fee_head }}</span>
                                <span
                                    class="text-sm font-semibold text-slate-900">₹{{ number_format($feeHead->total, 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full"
                                    style="width: {{ $grandTotal > 0 ? ($feeHead->total / $grandTotal * 100) : 0 }}%"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Daily Collection Chart Data -->
            <div class="card-premium p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Daily Collection</h3>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @php
                        $dailyTotals = $dailyCollection->groupBy('date')->map(fn($group) => $group->sum('total'));
                    @endphp
                    @forelse($dailyTotals as $date => $total)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                            <span class="text-sm font-semibold text-green-600">₹{{ number_format($total, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 text-center py-4">No collection data for this period</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Receipts -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Recent Receipts</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Receipt No</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Student</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Mode</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentReceipts as $receipt)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600">
                                    {{ $receipt->receipt_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    {{ $receipt->payment_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $receipt->student->name ?? '-' }}
                                    </div>
                                    <div class="text-sm text-slate-500">{{ $receipt->student->admission_no ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                    ₹{{ number_format($receipt->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $receipt->payment_mode == 'cash' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $receipt->payment_mode == 'online' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $receipt->payment_mode == 'cheque' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $receipt->payment_mode == 'card' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ ucfirst($receipt->payment_mode) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.fee-receipts.show', $receipt) }}"
                                        class="text-primary-600 hover:text-primary-900">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm text-slate-500">No receipts found for this period</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>