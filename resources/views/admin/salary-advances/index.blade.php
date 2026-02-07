<x-layouts.admin>
    <x-slot name="title">Salary Advances</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Salary Advances</h1>
                <p class="mt-1 text-sm text-slate-600">Track and manage staff salary advances</p>
            </div>
            <a href="{{ route('admin.salary-advances.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white gradient-primary hover:opacity-90 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Record Advance
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl bg-red-50 p-4 border border-red-200">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="card-premium p-4">
                <p class="text-sm font-medium text-slate-500">Total Advanced</p>
                <p class="text-2xl font-bold text-slate-900">₹{{ number_format($stats['total'], 2) }}</p>
            </div>
            <div class="card-premium p-4">
                <p class="text-sm font-medium text-slate-500">Recovered</p>
                <p class="text-2xl font-bold text-green-600">₹{{ number_format($stats['recovered'], 2) }}</p>
            </div>
            <div class="card-premium p-4">
                <p class="text-sm font-medium text-slate-500">Pending Recovery</p>
                <p class="text-2xl font-bold text-amber-600">₹{{ number_format($stats['pending'], 2) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" class="card-premium p-4 flex flex-wrap gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Staff</label>
                <select name="staff_id" class="rounded-lg border-slate-300 text-sm">
                    <option value="">All Staff</option>
                    @foreach($staff as $member)
                        <option value="{{ $member->id }}" {{ $staffId == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                <select name="status" class="rounded-lg border-slate-300 text-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="recovered" {{ $status == 'recovered' ? 'selected' : '' }}>Recovered</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-700">Filter</button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Staff</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Recovered</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Balance</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($advances as $advance)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-900">{{ $advance->staff->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $advance->reason ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $advance->advance_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-right font-medium text-slate-900">₹{{ number_format($advance->amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-right text-green-600">₹{{ number_format($advance->recovered_amount, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-right text-amber-600">₹{{ number_format($advance->pending_balance, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-blue-100 text-blue-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'recovered' => 'bg-green-100 text-green-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$advance->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($advance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($advance->status === 'pending')
                                        <form method="POST" action="{{ route('admin.salary-advances.approve', $advance) }}">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-700" title="Approve">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.salary-advances.reject', $advance) }}">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-700" title="Reject">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    @if($advance->recovered_amount == 0)
                                        <form method="POST" action="{{ route('admin.salary-advances.destroy', $advance) }}" onsubmit="return confirm('Delete this advance?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                No advances found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($advances->hasPages())
            <div class="mt-4">{{ $advances->withQueryString()->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
