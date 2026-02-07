<x-layouts.admin>
    <x-slot name="title">Receipt {{ $feeReceipt->receipt_no }}</x-slot>

    <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Fee Receipt</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">{{ $feeReceipt->receipt_no }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if(!$feeReceipt->cancelled && $feeReceipt->student)
                    @php
                        $parentPhone = $feeReceipt->student->father_phone ?: $feeReceipt->student->mother_phone ?: $feeReceipt->student->guardian_phone;
                        $pdfUrl = route('admin.fee-receipts.pdf', $feeReceipt);
                        $message = "Dear Parent,%0A%0AFee receipt for *" . $feeReceipt->student->name . "*%0A%0A📝 *Receipt No:* " . $feeReceipt->receipt_no . "%0A💰 *Amount:* ₹" . number_format($feeReceipt->amount, 2) . "%0A📅 *Date:* " . \Carbon\Carbon::parse($feeReceipt->payment_date)->format('d M Y') . "%0A💳 *Mode:* " . ucfirst($feeReceipt->payment_mode) . ($feeReceipt->fee_month ? "%0A📆 *Period:* " . $feeReceipt->fee_month : "") . "%0A%0A📄 *Download Receipt PDF:*%0A" . $pdfUrl . "%0A%0AThank you for the payment!%0A%0A- " . ($feeReceipt->school->name ?? 'School');
                        $whatsappUrl = $parentPhone ? "https://wa.me/91" . preg_replace('/[^0-9]/', '', $parentPhone) . "?text=" . $message : "https://wa.me/?text=" . $message;
                    @endphp
                    <a href="{{ $whatsappUrl }}" target="_blank"
                        class="inline-flex items-center px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-[#25D366] hover:bg-[#128C7E] transition-all shadow-lg"
                        title="Send to WhatsApp">
                        <svg class="w-5 h-5 sm:mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span class="hidden sm:inline">WhatsApp</span>
                    </a>
                @endif
                <a href="{{ route('admin.fee-receipts.pdf', $feeReceipt) }}" target="_blank"
                    class="inline-flex items-center px-3 py-2 border-2 border-warm-300 rounded-xl text-xs sm:text-sm font-semibold text-warm-700 bg-warm-50 hover:bg-warm-100 transition-all">
                    <svg class="h-5 w-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="hidden sm:inline">PDF</span>
                </a>
                <a href="{{ route('admin.fee-receipts.index') }}"
                    class="inline-flex items-center px-3 py-2 border-2 border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                    <svg class="h-5 w-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back</span>
                </a>
            </div>
        </div>

        <!-- Success Message with WhatsApp CTA -->
        @if(session('success'))
            <div class="rounded-xl bg-green-50 p-4 border border-green-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    @if(!$feeReceipt->cancelled && $feeReceipt->student)
                        @php
                            $parentPhone = $feeReceipt->student->father_phone ?: $feeReceipt->student->mother_phone ?: $feeReceipt->student->guardian_phone;
                            $pdfUrl = route('admin.fee-receipts.pdf', $feeReceipt);
                            $message = "Dear Parent,%0A%0AFee receipt for *" . $feeReceipt->student->name . "*%0A%0A📝 *Receipt No:* " . $feeReceipt->receipt_no . "%0A💰 *Amount:* ₹" . number_format($feeReceipt->amount, 2) . "%0A📅 *Date:* " . \Carbon\Carbon::parse($feeReceipt->payment_date)->format('d M Y') . "%0A💳 *Mode:* " . ucfirst($feeReceipt->payment_mode) . ($feeReceipt->fee_month ? "%0A📆 *Period:* " . $feeReceipt->fee_month : "") . "%0A%0A📄 *Download Receipt PDF:*%0A" . $pdfUrl . "%0A%0AThank you for the payment!%0A%0A- " . ($feeReceipt->school->name ?? 'School');
                            $whatsappUrl = $parentPhone ? "https://wa.me/91" . preg_replace('/[^0-9]/', '', $parentPhone) . "?text=" . $message : "https://wa.me/?text=" . $message;
                        @endphp
                        <a href="{{ $whatsappUrl }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-[#25D366] hover:bg-[#128C7E] transition-all shadow-lg animate-pulse">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Send to Parent on WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Receipt Details Card -->
        <div class="card-premium p-4 sm:p-8">
            @if($feeReceipt->cancelled)
                <x-admin.alert type="error" :dismissible="false">
                    This receipt was cancelled on {{ $feeReceipt->cancelled_at->format('M d, Y \a\t h:i A') }}
                </x-admin.alert>
            @endif

            <div class="space-y-4 sm:space-y-6 mt-4 sm:mt-6">
                <!-- Student Info -->
                @if($feeReceipt->student)
                    <div class="flex items-start gap-3 sm:gap-4 pb-4 sm:pb-6 border-b border-slate-200">
                        @if($feeReceipt->student->photo)
                            <img src="{{ asset('storage/' . $feeReceipt->student->photo) }}"
                                alt="{{ $feeReceipt->student->name }}"
                                class="h-14 w-14 sm:h-20 sm:w-20 rounded-xl object-cover border-2 border-slate-200">
                        @else
                            <div
                                class="h-14 w-14 sm:h-20 sm:w-20 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-lg sm:text-2xl font-bold">
                                {{ strtoupper(substr($feeReceipt->student->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 truncate">
                                {{ $feeReceipt->student->name }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Admission:
                                {{ $feeReceipt->student->admission_no }}</p>
                            <p class="text-xs sm:text-sm text-slate-600">
                                {{ $feeReceipt->student->class }}{{ $feeReceipt->student->section ? ' - ' . $feeReceipt->student->section : '' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-flex px-2 sm:px-3 py-1 rounded-full text-xs font-medium {{ $feeReceipt->cancelled ? 'bg-red-100 text-red-800' : 'bg-accent-100 text-accent-800' }}">
                                {{ $feeReceipt->cancelled ? 'Cancelled' : 'Active' }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Payment Info -->
                <div class="grid grid-cols-2 gap-3 sm:gap-6">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Receipt No</p>
                        <p class="text-sm sm:text-lg font-bold text-slate-900 mt-1">{{ $feeReceipt->receipt_no }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Amount Paid</p>
                        <p class="text-sm sm:text-lg font-bold text-accent-600 mt-1">
                            ₹{{ number_format($feeReceipt->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Payment Mode</p>
                        <p class="text-xs sm:text-sm font-medium text-slate-900 mt-1">
                            {{ ucfirst(str_replace('_', ' ', $feeReceipt->payment_mode)) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Payment Date</p>
                        <p class="text-xs sm:text-sm font-medium text-slate-900 mt-1">
                            {{ \Carbon\Carbon::parse($feeReceipt->payment_date)->format('M d, Y') }}</p>
                    </div>
                    @if($feeReceipt->fee_month)
                        <div>
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Fee Period</p>
                            <p class="text-xs sm:text-sm font-medium text-slate-900 mt-1">{{ $feeReceipt->fee_month }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Created On</p>
                        <p class="text-xs sm:text-sm font-medium text-slate-900 mt-1">
                            {{ $feeReceipt->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Remarks -->
                @if($feeReceipt->remarks)
                    <div class="pt-4 sm:pt-6 border-t border-slate-200">
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">Remarks</p>
                        <p class="text-xs sm:text-sm text-slate-700 bg-slate-50 rounded-lg p-3 sm:p-4">
                            {{ $feeReceipt->remarks }}</p>
                    </div>
                @endif

                <!-- Actions -->
                @if(!$feeReceipt->cancelled)
                    <div class="flex items-center justify-end gap-3 pt-4 sm:pt-6 border-t border-slate-200">
                        <form action="{{ route('admin.fee-receipts.cancel', $feeReceipt) }}" method="POST"
                            onsubmit="return confirm('Cancel this receipt? This cannot be undone.');">
                            @csrf
                            @method('POST')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-500 transition-all">
                                <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="hidden sm:inline">Cancel Receipt</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>