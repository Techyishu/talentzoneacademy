<x-layouts.admin>
    <x-slot name="title">Fee Receipts</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Fee Receipts</h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600">Manage fee collections</p>
                </div>
                <a href="{{ route('admin.fee-receipts.create') }}"
                    class="inline-flex items-center px-3 py-2 border border-transparent rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 shadow-lg transition-all">
                    <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Create Receipt</span>
                </a>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.fee-receipts.export') }}"
                    class="inline-flex items-center px-3 py-1.5 border-2 border-warm-300 rounded-lg text-xs font-semibold text-warm-700 bg-warm-50 whitespace-nowrap">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-2 sm:gap-6">
            <div class="card-premium p-3 sm:p-6">
                <p class="text-xs sm:text-sm font-medium text-slate-600">Total</p>
                <p class="text-lg sm:text-2xl font-bold text-slate-900 mt-1">{{ $totalReceipts }}</p>
            </div>
            <div class="card-premium p-3 sm:p-6">
                <p class="text-xs sm:text-sm font-medium text-slate-600">Collected</p>
                <p class="text-lg sm:text-2xl font-bold text-slate-900 mt-1">₹{{ number_format($totalAmount, 0) }}</p>
            </div>
            <div class="card-premium p-3 sm:p-6">
                <p class="text-xs sm:text-sm font-medium text-slate-600">This Month</p>
                <p class="text-lg sm:text-2xl font-bold text-slate-900 mt-1">
                    {{ $receipts->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card-premium p-4 sm:p-6">
            <form method="GET" action="{{ route('admin.fee-receipts.index') }}" class="space-y-3">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <div class="col-span-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="block w-full rounded-lg border-slate-300 text-sm" />
                    </div>
                    <select name="payment_mode" class="block w-full rounded-lg border-slate-300 text-sm">
                        <option value="">All Modes</option>
                        <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="online" {{ request('payment_mode') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="cheque" {{ request('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="bank_transfer" {{ request('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>
                            Bank</option>
                    </select>
                    <select name="status" class="block w-full rounded-lg border-slate-300 text-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-600">Search</button>
                    @if(request()->hasAny(['search', 'payment_mode', 'status']))<a
                        href="{{ route('admin.fee-receipts.index') }}"
                    class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 border border-slate-300 bg-white">Clear</a>@endif
                </div>
            </form>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-3">
            @forelse($receipts as $receipt)
                <div class="bg-white rounded-xl border border-slate-200 p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-slate-900 truncate">{{ $receipt->student->name }}</h3>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0 {{ $receipt->cancelled ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">{{ $receipt->cancelled ? 'Cancelled' : 'Active' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $receipt->receipt_no }}</p>
                        </div>
                        <p class="text-sm font-bold text-slate-900">₹{{ number_format($receipt->amount, 0) }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100">
                        <div class="text-xs text-slate-500">
                            <span>{{ ucfirst($receipt->payment_mode) }}</span> •
                            <span>{{ \Carbon\Carbon::parse($receipt->payment_date)->format('M d') }}</span>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.fee-receipts.show', $receipt) }}"
                                class="text-xs text-primary-600 font-medium">View</a>
                            <a href="{{ route('admin.fee-receipts.pdf', $receipt) }}"
                                class="text-xs text-warm-600 font-medium">PDF</a>
                            @if(!$receipt->cancelled)
                                <form action="{{ route('admin.fee-receipts.cancel', $receipt) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Cancel receipt?');"> @csrf<button
                                        class="text-xs text-red-600 font-medium">Cancel</button></form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border p-8 text-center">
                    <p class="text-sm text-slate-500">No receipts found</p>
                    <a href="{{ route('admin.fee-receipts.create') }}"
                        class="mt-3 inline-block px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary-600">Create
                        Receipt</a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-hidden rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Receipt</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Mode</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($receipts as $receipt)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-slate-900">{{ $receipt->receipt_no }}</div>
                                @if($receipt->fee_month)
                                <div class="text-xs text-slate-500">{{ $receipt->fee_month }}</div>@endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-slate-900">{{ $receipt->student->name }}</div>
                                <div class="text-xs text-slate-500">{{ $receipt->student->admission_no }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-slate-900">₹{{ number_format($receipt->amount, 0) }}
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-600">
                                {{ ucfirst(str_replace('_', ' ', $receipt->payment_mode)) }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">
                                {{ \Carbon\Carbon::parse($receipt->payment_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3"><span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium {{ $receipt->cancelled ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">{{ $receipt->cancelled ? 'Cancelled' : 'Active' }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.fee-receipts.show', $receipt) }}" class="text-primary-600"><svg
                                            class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg></a>
                                    <a href="{{ route('admin.fee-receipts.pdf', $receipt) }}" class="text-warm-600"
                                        target="_blank"><svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg></a>
                                    @if(!$receipt->cancelled)
                                        <form action="{{ route('admin.fee-receipts.cancel', $receipt) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Cancel?');"> @csrf<button
                                                class="text-red-600"><svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                    </svg></button></form>@endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <p class="text-sm text-slate-500">No receipts found</p><a
                                    href="{{ route('admin.fee-receipts.create') }}"
                                    class="mt-3 inline-block px-4 py-2 rounded-xl text-sm font-semibold text-white bg-primary-600">Create
                                    Receipt</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($receipts->hasPages())
        <div class="flex justify-center"><x-admin.pagination :paginator="$receipts" /></div>@endif
    </div>
</x-layouts.admin>