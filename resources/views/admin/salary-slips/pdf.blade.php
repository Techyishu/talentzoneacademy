<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Salary Slip - {{ $salarySlip->slip_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .slip-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .slip-info div {
            width: 48%;
        }

        .label {
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .value {
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .earnings {
            background-color: #f0fdf4;
        }

        .deductions {
            background-color: #fef2f2;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8fafc;
        }

        .net-salary {
            background-color: #eff6ff;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
        }

        .net-salary .amount {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }

        .footer {
            text-align: center;
            color: #666;
            font-size: 10px;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-generated {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>SALARY SLIP</h1>
            <p>{{ $salarySlip->period }}</p>
        </div>

        <table style="margin-bottom: 20px;">
            <tr>
                <td width="50%">
                    <div class="label">Slip No</div>
                    <div class="value">{{ $salarySlip->slip_no }}</div>
                </td>
                <td width="50%" class="text-right">
                    <div class="label">Status</div>
                    <div class="value">
                        <span
                            class="status-badge status-{{ $salarySlip->status }}">{{ strtoupper($salarySlip->status) }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <table style="margin-bottom: 20px;">
            <tr>
                <td width="50%">
                    <div class="label">Employee Name</div>
                    <div class="value">{{ $salarySlip->staff->name ?? 'N/A' }}</div>
                </td>
                <td width="50%">
                    <div class="label">Staff Code</div>
                    <div class="value">{{ $salarySlip->staff->staff_code ?? 'N/A' }}</div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="label">Designation</div>
                    <div class="value">{{ $salarySlip->staff->designation ?? '-' }}</div>
                </td>
                <td width="50%">
                    <div class="label">Pay Period</div>
                    <div class="value">{{ $salarySlip->period }}</div>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Earnings</th>
                    <th class="text-right">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="earnings">
                    <td>Basic Salary</td>
                    <td class="text-right">{{ number_format($salarySlip->basic_salary, 2) }}</td>
                </tr>
                <tr class="earnings">
                    <td>Allowances</td>
                    <td class="text-right">{{ number_format($salarySlip->allowances, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Gross Salary</td>
                    <td class="text-right">{{ number_format($salarySlip->gross_salary, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Deductions</th>
                    <th class="text-right">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salarySlip->deductions as $deduction)
                    <tr class="deductions">
                        <td>{{ $deduction->description }}</td>
                        <td class="text-right">{{ number_format($deduction->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center; color: #999;">No deductions</td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td class="text-right">{{ number_format($salarySlip->total_deductions, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="net-salary">
            <div class="label">Net Salary Payable</div>
            <div class="amount">₹ {{ number_format($salarySlip->net_salary, 2) }}</div>
        </div>

        @if($salarySlip->status === 'paid')
            <table>
                <tr>
                    <td width="33%">
                        <div class="label">Payment Date</div>
                        <div class="value">{{ $salarySlip->payment_date?->format('d M Y') }}</div>
                    </td>
                    <td width="33%">
                        <div class="label">Payment Mode</div>
                        <div class="value">{{ ucfirst($salarySlip->payment_mode) }}</div>
                    </td>
                    <td width="33%">
                        <div class="label">Reference</div>
                        <div class="value">{{ $salarySlip->payment_reference ?? '-' }}</div>
                    </td>
                </tr>
            </table>
        @endif

        <div class="footer">
            <p>This is a computer-generated document. No signature required.</p>
            <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>
</body>

</html>