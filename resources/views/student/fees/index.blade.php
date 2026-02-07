<x-layouts.student>
    <x-slot name="title">Fee Receipts</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">My Fee Receipts</h1>
            <div class="card-premium px-4 py-2">
                <span class="text-sm text-slate-500">Total Paid:</span>
                <span class="text-lg font-bold text-green-600 ml-2">₹{{ number_format($totalPaid, 2) }}</span>
            </div>
        </div>

        <!-- Receipts Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Receipt #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Payment Mode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($receipts as $receipt)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $receipt->receipt_number }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $receipt->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ ucfirst($receipt->payment_mode ?? 'Cash') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-green-600">
                                ₹{{ number_format($receipt->amount, 2) }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('student.fees.download', $receipt) }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">No fee receipts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($receipts->hasPages())
            <div class="mt-4">
                {{ $receipts->links() }}
            </div>
        @endif
    </div>
</x-layouts.student>