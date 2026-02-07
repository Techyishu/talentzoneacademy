<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Receipt - {{ $receipt->receipt_no }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; padding: 40px; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid {{ $school->primary_color ?? '#6366f1' }}; }
        .logo { max-width: 100px; max-height: 100px; margin-bottom: 15px; }
        .school-name { font-size: 24px; font-weight: bold; color: {{ $school->primary_color ?? '#6366f1' }}; margin-bottom: 5px; }
        .school-info { font-size: 12px; color: #666; }
        .receipt-title { background: {{ $school->primary_color ?? '#6366f1' }}; color: white; padding: 10px; text-align: center; font-size: 18px; font-weight: bold; margin: 20px 0; }
        .receipt-no { text-align: right; font-weight: bold; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; font-size: 14px; color: {{ $school->primary_color ?? '#6366f1' }}; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #ddd; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dotted #ddd; }
        .info-label { font-weight: bold; color: #666; }
        .info-value { color: #333; }
        .amount-box { background: #f8f9fa; border: 2px solid {{ $school->primary_color ?? '#6366f1' }}; padding: 15px; text-align: center; margin: 20px 0; }
        .amount-label { font-size: 12px; color: #666; margin-bottom: 5px; }
        .amount-value { font-size: 28px; font-weight: bold; color: {{ $school->primary_color ?? '#6366f1' }}; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature { text-align: center; }
        .signature-line { width: 200px; border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; }
        .signature-img { max-width: 150px; max-height: 50px; margin-bottom: 10px; }
        .note { font-size: 10px; color: #999; margin-top: 20px; font-style: italic; text-align: center; }
        @media print { body { padding: 20px; } }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        @if($school->logo)
            <img src="{{ public_path('storage/uploads/logos/' . $school->logo) }}" class="logo" alt="{{ $school->name }}">
        @endif
        <div class="school-name">{{ $school->name }}</div>
        <div class="school-info">{{ $school->address }}</div>
        <div class="school-info">Phone: {{ $school->phone }} | Email: {{ $school->email }}</div>
    </div>

    <!-- Receipt Title -->
    <div class="receipt-title">FEE RECEIPT</div>

    <!-- Receipt Number -->
    <div class="receipt-no">Receipt No: {{ $receipt->receipt_no }}</div>

    <!-- Student Information -->
    <div class="section">
        <div class="section-title">STUDENT INFORMATION</div>
        <div class="info-row">
            <span class="info-label">Student Name:</span>
            <span class="info-value">{{ $student->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Admission No:</span>
            <span class="info-value">{{ $student->admission_no }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Class:</span>
            <span class="info-value">{{ $student->class }}{{ $student->section ? ' - ' . $student->section : '' }}</span>
        </div>
        @if($student->guardian_name)
            <div class="info-row">
                <span class="info-label">Guardian Name:</span>
                <span class="info-value">{{ $student->guardian_name }}</span>
            </div>
        @endif
    </div>

    <!-- Payment Information -->
    <div class="section">
        <div class="section-title">PAYMENT DETAILS</div>
        <div class="info-row">
            <span class="info-label">Payment Date:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($receipt->payment_date)->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Mode:</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $receipt->payment_mode)) }}</span>
        </div>
        @if($receipt->fee_month)
            <div class="info-row">
                <span class="info-label">Fee Period:</span>
                <span class="info-value">{{ $receipt->fee_month }}</span>
            </div>
        @endif
        @if($receipt->remarks)
            <div class="info-row">
                <span class="info-label">Remarks:</span>
                <span class="info-value">{{ $receipt->remarks }}</span>
            </div>
        @endif
    </div>

    <!-- Amount Box -->
    <div class="amount-box">
        <div class="amount-label">TOTAL AMOUNT PAID</div>
        <div class="amount-value">₹ {{ number_format($receipt->amount, 2) }}</div>
    </div>

    <!-- Footer with Signature -->
    <div class="footer">
        <div>
            <div style="font-size: 12px; color: #666;">Generated on:</div>
            <div style="font-size: 12px;">{{ now()->format('M d, Y \a\t h:i A') }}</div>
        </div>
        <div class="signature">
            @if($school->signature_image)
                <img src="{{ public_path('storage/uploads/signatures/' . $school->signature_image) }}" class="signature-img" alt="Signature">
            @endif
            <div class="signature-line">Authorized Signature</div>
        </div>
    </div>

    <!-- Note -->
    <div class="note">
        This is a computer-generated receipt and does not require a physical signature.
        @if($receipt->cancelled)
            <br><strong style="color: #dc2626;">THIS RECEIPT HAS BEEN CANCELLED</strong>
        @endif
    </div>
</body>
</html>
