<x-layouts.admin>
    <x-slot name="title">Student Fee Details - {{ $student->name }}</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm text-slate-500">
                        <li><a href="{{ route('admin.reports.dues') }}" class="hover:text-primary-600">Dues Report</a></li>
                        <li><svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-slate-700 font-medium">{{ $student->name }}</li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-slate-900 font-heading">Fee Details</h1>
                <p class="mt-1 text-sm text-slate-600">Detailed fee breakdown for {{ $student->name }}</p>
            </div>
            <a href="{{ route('admin.fee-receipts.create', ['student_id' => $student->id]) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg shadow-primary-500/50 transition-all duration-200 hover:scale-105">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Collect Fee
            </a>
        </div>

        <!-- Student Info Card -->
        <div class="card-premium p-6">
            <div class="flex items-start gap-6">
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}" class="h-20 w-20 rounded-xl object-cover border-2 border-slate-200">
                @else
                    <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                @endif
                <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Admission No</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $student->admission_no }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Student Name</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $student->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Class</p>
                        <p class="text-sm font-semibold text-slate-900">
                            {{ $student->schoolClass?->name ?? '-' }}
                            @if($student->schoolSection)
                                - {{ $student->schoolSection->name }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Father's Name</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $student->father_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Selector -->
        <div class="card-premium p-4">
            <form method="GET" action="{{ route('admin.reports.student-dues', $student) }}" class="flex items-center gap-4">
                <label for="session_id" class="text-sm font-medium text-slate-700">Academic Session:</label>
                <select name="session_id" id="session_id" onchange="this.form.submit()" class="rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ $sessionId == $session->id ? 'selected' : '' }}>
                            {{ $session->name }}{{ $session->is_current ? ' (Current)' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($summary)
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="card-premium p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-xl p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-500">Total Due</p>
                            <p class="text-2xl font-bold text-slate-900">₹{{ number_format($summary['total_due'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-xl p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-500">Total Paid</p>
                            <p class="text-2xl font-bold text-green-600">₹{{ number_format($summary['total_paid'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-{{ $summary['total_balance'] > 0 ? 'red' : 'green' }}-100 rounded-xl p-3">
                            <svg class="h-6 w-6 text-{{ $summary['total_balance'] > 0 ? 'red' : 'green' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-slate-500">Balance</p>
                            <p class="text-2xl font-bold text-{{ $summary['total_balance'] > 0 ? 'red' : 'green' }}-600">₹{{ number_format($summary['total_balance'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Breakdown Table -->
            <div class="overflow-hidden rounded-xl glass-card border border-slate-200 shadow-sm">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Fee Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Fee Head</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Frequency</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Due Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Paid</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Balance</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($summary['items'] as $item)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                        {{ $item['fee_head']->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 capitalize">
                                        {{ $item['frequency'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-slate-900">
                                        ₹{{ number_format($item['total_due'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-medium">
                                        ₹{{ number_format($item['total_paid'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $item['balance'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        ₹{{ number_format($item['balance'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item['balance'] <= 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @elseif($item['total_paid'] > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Partial
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <p class="text-sm text-slate-500">No fee structure found for this student's class</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(count($summary['items']) > 0)
                            <tfoot class="bg-slate-100">
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-sm font-bold text-slate-900">Total</td>
                                    <td class="px-6 py-4 text-sm text-right font-bold text-slate-900">₹{{ number_format($summary['total_due'], 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-bold text-green-600">₹{{ number_format($summary['total_paid'], 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-bold {{ $summary['total_balance'] > 0 ? 'text-red-600' : 'text-green-600' }}">₹{{ number_format($summary['total_balance'], 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        @else
            <!-- No Summary Available -->
            <div class="card-premium p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-medium text-slate-500">No fee information available</p>
                <p class="text-xs text-slate-400 mt-1">Please select an academic session or set up fee structures</p>
            </div>
        @endif
    </div>
</x-layouts.admin>
