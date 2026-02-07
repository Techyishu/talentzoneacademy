<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Fee Receipt
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.fee-receipts.store') }}" method="POST" id="receiptForm">
                        @csrf

                        <!-- Payment Type Selector -->
                        <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <label class="block text-gray-700 text-sm font-bold mb-3">Payment Type</label>
                            <div class="flex gap-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="payment_type" value="student"
                                        class="form-radio h-4 w-4 text-blue-600" checked onchange="togglePaymentType()">
                                    <span class="ml-2 text-gray-700">
                                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Individual Student Payment
                                    </span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="payment_type" value="family"
                                        class="form-radio h-4 w-4 text-blue-600" onchange="togglePaymentType()">
                                    <span class="ml-2 text-gray-700">
                                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Family Payment
                                    </span>
                                </label>
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Family payments will be distributed proportionally
                                across all children based on their balances</p>
                        </div>

                        <!-- Student Payment Form -->
                        <div id="student-payment-form">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Student Selection -->
                                <div>
                                    <label for="student_id" class="block text-gray-700 text-sm font-bold mb-2">
                                        Student <span class="text-red-500">*</span>
                                    </label>
                                    <select name="student_id" id="student_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('student_id') border-red-500 @enderror"
                                        required onchange="loadStudentBalance()">
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ old('student_id', $selectedStudent?->id) == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }} ({{ $student->admission_no }})
                                                @if($student->schoolClass)
                                                    - {{ $student->schoolClass->name }}
                                                    @if($student->schoolSection)
                                                        {{ $student->schoolSection->name }}
                                                    @endif
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Academic Session -->
                                <div>
                                    <label for="academic_session_id" class="block text-gray-700 text-sm font-bold mb-2">
                                        Academic Session
                                    </label>
                                    <select name="academic_session_id" id="academic_session_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id }}" {{ $activeSession && $activeSession->id == $session->id ? 'selected' : '' }}>
                                                {{ $session->name }}
                                                @if($session->is_current) (Current) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-gray-500 text-xs mt-1">Leave blank for general payment</p>
                                </div>

                                <!-- Payment Mode -->
                                <div>
                                    <label for="payment_mode" class="block text-gray-700 text-sm font-bold mb-2">
                                        Payment Mode <span class="text-red-500">*</span>
                                    </label>
                                    <select name="payment_mode" id="payment_mode"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('payment_mode') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Mode</option>
                                        <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="online" {{ old('payment_mode') == 'online' ? 'selected' : '' }}>
                                            Online</option>
                                        <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>
                                            Cheque</option>
                                        <option value="card" {{ old('payment_mode') == 'card' ? 'selected' : '' }}>Card
                                        </option>
                                    </select>
                                    @error('payment_mode')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Date -->
                                <div>
                                    <label for="payment_date" class="block text-gray-700 text-sm font-bold mb-2">
                                        Payment Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="payment_date" id="payment_date"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('payment_date') border-red-500 @enderror"
                                        value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                    @error('payment_date')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fee Month -->
                                <div>
                                    <label for="fee_month" class="block text-gray-700 text-sm font-bold mb-2">
                                        Fee Period (Optional)
                                    </label>
                                    <input type="text" name="fee_month" id="fee_month"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        value="{{ old('fee_month') }}" placeholder="e.g., January 2026, Q1 2026">
                                    <p class="text-gray-500 text-xs mt-1">Specify the period this payment covers</p>
                                </div>

                                <!-- Remarks -->
                                <div class="md:col-span-2">
                                    <label for="remarks" class="block text-gray-700 text-sm font-bold mb-2">
                                        Remarks (Optional)
                                    </label>
                                    <textarea name="remarks" id="remarks" rows="2"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                                </div>
                            </div>

                            <!-- Balance Summary -->
                            @if($balanceSummary)
                                <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4">
                                    <h3 class="font-semibold text-blue-900 mb-2">Fee Balance Summary</h3>
                                    <div class="grid grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="text-blue-700">Total Due:</span>
                                            <span
                                                class="font-bold text-blue-900">₹{{ number_format($balanceSummary['total_due'], 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-blue-700">Total Paid:</span>
                                            <span
                                                class="font-bold text-green-600">₹{{ number_format($balanceSummary['total_paid'], 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-blue-700">Balance:</span>
                                            <span
                                                class="font-bold text-red-600">₹{{ number_format($balanceSummary['total_balance'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Fee Items -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Fee Items</h3>
                                    <button type="button" onclick="addFeeItem()"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        + Add Fee Item
                                    </button>
                                </div>

                                <div id="feeItemsContainer">
                                    <!-- Fee items will be added here dynamically -->
                                </div>

                                <div class="mt-4 text-right">
                                    <span class="text-lg font-semibold text-gray-900">Total Amount: ₹</span>
                                    <span id="totalAmount" class="text-2xl font-bold text-blue-600">0.00</span>
                                </div>
                            </div>

                        </div>
                        <!-- End Student Payment Form -->

                        <!-- Family Payment Form -->
                        <div id="family-payment-form" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Parent Selection -->
                                <div class="md:col-span-2">
                                    <label for="parent_user_id" class="block text-gray-700 text-sm font-bold mb-2">
                                        Select Parent <span class="text-red-500">*</span>
                                    </label>
                                    <select name="parent_user_id" id="parent_user_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        onchange="loadFamilyBalance()">
                                        <option value="">-- Search and Select Parent --</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">
                                                {{ $parent->name }} ({{ $parent->email }})
                                                @if($parent->children->isNotEmpty())
                                                    - {{ $parent->children->count() }}
                                                    {{ Str::plural('child', $parent->children->count()) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Family Balance Summary (loaded via AJAX) -->
                            <div id="family-balance-card" style="display: none;" class="mb-6">
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-400 p-6 rounded-lg">
                                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Family Balance Summary
                                    </h3>
                                    <div class="grid grid-cols-3 gap-4 mb-4">
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <span class="text-sm text-gray-600 block">Total Due</span>
                                            <span class="text-2xl font-bold text-gray-900"
                                                id="family-total-due">₹0.00</span>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <span class="text-sm text-gray-600 block">Total Paid</span>
                                            <span class="text-2xl font-bold text-green-600"
                                                id="family-total-paid">₹0.00</span>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <span class="text-sm text-gray-600 block">Balance</span>
                                            <span class="text-2xl font-bold text-red-600"
                                                id="family-balance">₹0.00</span>
                                        </div>
                                    </div>

                                    <h4 class="font-semibold text-blue-900 mb-2 mt-4">Children & Allocation Preview:
                                    </h4>
                                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200" id="children-balances-table">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                        Student</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                        Class</th>
                                                    <th
                                                        class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                        Current Balance</th>
                                                    <th
                                                        class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                                        Will Receive</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200"
                                                id="children-balances-body">
                                                <!-- Populated via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Family Payment Details -->
                            <div id="family-payment-details" style="display: none;">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Payment Amount -->
                                    <div>
                                        <label for="family_amount" class="block text-gray-700 text-sm font-bold mb-2">
                                            Payment Amount <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="amount" id="family_amount" step="0.01" min="0.01"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            placeholder="Enter amount" oninput="calculateFamilyAllocation()">
                                        <p class="text-blue-600 text-xs mt-1">
                                            <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Amount will be distributed proportionally based on each child's balance
                                        </p>
                                    </div>

                                    <!-- Payment Mode -->
                                    <div>
                                        <label for="family_payment_mode"
                                            class="block text-gray-700 text-sm font-bold mb-2">
                                            Payment Mode <span class="text-red-500">*</span>
                                        </label>
                                        <select name="payment_mode" id="family_payment_mode"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            <option value="">Select Mode</option>
                                            <option value="cash">Cash</option>
                                            <option value="online">Online</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="card">Card</option>
                                        </select>
                                    </div>

                                    <!-- Payment Date -->
                                    <div>
                                        <label for="family_payment_date"
                                            class="block text-gray-700 text-sm font-bold mb-2">
                                            Payment Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" name="payment_date" id="family_payment_date"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            value="{{ date('Y-m-d') }}">
                                    </div>

                                    <!-- Academic Session -->
                                    <div>
                                        <label for="family_session_id"
                                            class="block text-gray-700 text-sm font-bold mb-2">
                                            Academic Session
                                        </label>
                                        <select name="academic_session_id" id="family_session_id"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            <option value="">Select Session</option>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session->id }}" {{ $activeSession && $activeSession->id == $session->id ? 'selected' : '' }}>
                                                    {{ $session->name }}
                                                    @if($session->is_current) (Current) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Remarks -->
                                    <div class="md:col-span-2">
                                        <label for="family_remarks" class="block text-gray-700 text-sm font-bold mb-2">
                                            Remarks (Optional)
                                        </label>
                                        <textarea name="remarks" id="family_remarks" rows="2"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            placeholder="Any additional notes..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Family Payment Form -->

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between border-t pt-6">
                            <a href="{{ route('admin.fee-receipts.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Create Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 0;
        let familyBalanceData = null;

        // Add first fee item on page load
        document.addEventListener('DOMContentLoaded', function () {
            addFeeItem();
        });

        // Toggle between student and family payment forms
        function togglePaymentType() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked').value;
            const studentForm = document.getElementById('student-payment-form');
            const familyForm = document.getElementById('family-payment-form');

            if (paymentType === 'student') {
                studentForm.style.display = 'block';
                familyForm.style.display = 'none';
                // Make student fields required
                document.getElementById('student_id').required = true;
                // Make family fields optional
                document.getElementById('parent_user_id').required = false;
            } else {
                studentForm.style.display = 'none';
                familyForm.style.display = 'block';
                // Make student fields optional
                document.getElementById('student_id').required = false;
                // Make family fields required
                document.getElementById('parent_user_id').required = true;
            }
        }

        // Load family balance via AJAX
        function loadFamilyBalance() {
            const parentId = document.getElementById('parent_user_id').value;
            const balanceCard = document.getElementById('family-balance-card');
            const paymentDetails = document.getElementById('family-payment-details');

            if (!parentId) {
                balanceCard.style.display = 'none';
                paymentDetails.style.display = 'none';
                return;
            }

            // Show loading state
            balanceCard.style.display = 'block';
            document.getElementById('family-total-due').textContent = 'Loading...';

            fetch(`{{ url('/admin/fee-receipts/family-balance') }}/${parentId}`)
                .then(response => response.json())
                .then(data => {
                    familyBalanceData = data;

                    // Update balance summary
                    document.getElementById('family-total-due').textContent = '₹' + parseFloat(data.total_due).toFixed(2);
                    document.getElementById('family-total-paid').textContent = '₹' + parseFloat(data.total_paid).toFixed(2);
                    document.getElementById('family-balance').textContent = '₹' + parseFloat(data.balance).toFixed(2);

                    // Populate children table
                    const tbody = document.getElementById('children-balances-body');
                    tbody.innerHTML = '';

                    if (data.children && data.children.length > 0) {
                        data.children.forEach(child => {
                            const row = `
                                <tr data-student-id="${child.id}" data-balance="${child.balance}">
                                    <td class="px-4 py-2 text-sm text-gray-900">${child.name}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">${child.class || 'N/A'}</td>
                                    <td class="px-4 py-2 text-sm text-right font-semibold text-red-600">₹${parseFloat(child.balance).toFixed(2)}</td>
                                    <td class="px-4 py-2 text-sm text-right font-bold text-green-600 allocation-cell" id="allocation-${child.id}">₹0.00</td>
                                </tr>
                            `;
                            tbody.insertAdjacentHTML('beforeend', row);
                        });

                        // Show payment details section
                        paymentDetails.style.display = 'block';
                    } else {
                        tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-2 text-center text-gray-500">No children found for this parent</td></tr>';
                        paymentDetails.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading family balance:', error);
                    alert('Failed to load family balance. Please try again.');
                    balanceCard.style.display = 'none';
                    paymentDetails.style.display = 'none';
                });
        }

        // Calculate proportional allocation when amount is entered
        function calculateFamilyAllocation() {
            const amount = parseFloat(document.getElementById('family_amount').value) || 0;

            if (!familyBalanceData || !familyBalanceData.children || amount <= 0) {
                // Reset allocations
                document.querySelectorAll('.allocation-cell').forEach(cell => {
                    cell.textContent = '₹0.00';
                });
                return;
            }

            const totalBalance = familyBalanceData.children.reduce((sum, child) => sum + parseFloat(child.balance), 0);

            if (totalBalance === 0) {
                // Equal distribution if all balances are zero
                const equalAmount = amount / familyBalanceData.children.length;
                familyBalanceData.children.forEach(child => {
                    document.getElementById(`allocation-${child.id}`).textContent = '₹' + equalAmount.toFixed(2);
                });
            } else {
                // Proportional distribution
                let remainingAmount = amount;
                let processedCount = 0;

                familyBalanceData.children.forEach((child, index) => {
                    processedCount++;
                    let allocated;

                    if (processedCount === familyBalanceData.children.length) {
                        // Last child gets remaining amount to avoid rounding errors
                        allocated = remainingAmount;
                    } else {
                        const ratio = parseFloat(child.balance) / totalBalance;
                        allocated = amount * ratio;
                        remainingAmount -= allocated;
                    }

                    document.getElementById(`allocation-${child.id}`).textContent = '₹' + allocated.toFixed(2);
                });
            }
        }

        // Student payment form functions (existing)
        function addFeeItem() {
            const container = document.getElementById('feeItemsContainer');
            const itemHtml = `
                <div class="fee-item grid grid-cols-12 gap-4 mb-3 items-end" data-index="${itemIndex}">
                    <div class="col-span-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Fee Description</label>
                        <input type="text" name="fee_items[${itemIndex}][description]" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., Tuition Fee, Bus Fee, Books" required>
                    </div>
                    <div class="col-span-5">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
                        <input type="number" name="fee_items[${itemIndex}][amount]" step="0.01" min="0.01" class="fee-amount shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="0.00" required oninput="updateTotal()">
                    </div>
                    <div class="col-span-1">
                        <button type="button" onclick="removeFeeItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                            ×
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
            itemIndex++;
        }

        function removeFeeItem(button) {
            const items = document.querySelectorAll('.fee-item');
            if (items.length > 1) {
                button.closest('.fee-item').remove();
                updateTotal();
            } else {
                alert('At least one fee item is required');
            }
        }

        function updateTotal() {
            const amounts = document.querySelectorAll('.fee-amount');
            let total = 0;
            amounts.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        function loadStudentBalance() {
            const studentId = document.getElementById('student_id').value;
            if (studentId) {
                window.location.href = `{{ route('admin.fee-receipts.create') }}?student_id=${studentId}`;
            }
        }
    </script>
</x-layouts.admin>