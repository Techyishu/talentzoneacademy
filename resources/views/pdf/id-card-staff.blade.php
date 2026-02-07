<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Staff ID Card - {{ $staff->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background: #f5f5f5;
        }
        .id-card {
            width: 350px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border: 3px solid {{ $school->primary_color ?? '#6366f1' }};
        }
        .card-header {
            background: {{ $school->primary_color ?? '#6366f1' }};
            color: white;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 80px;
            max-height: 80px;
            margin-bottom: 10px;
            background: white;
            padding: 5px;
            border-radius: 50%;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .card-type {
            font-size: 12px;
            letter-spacing: 2px;
            opacity: 0.9;
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .photo-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid {{ $school->primary_color ?? '#6366f1' }};
            background: #f0f0f0;
        }
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .staff-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .designation {
            font-size: 14px;
            color: {{ $school->primary_color ?? '#6366f1' }};
            font-weight: 600;
            margin-bottom: 15px;
        }
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px dotted #ddd;
            font-size: 13px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
            font-weight: 600;
        }
        .contact-section {
            padding: 10px;
            font-size: 11px;
            color: #666;
            text-align: center;
            background: #f0f0f0;
        }
        .validity {
            background: {{ $school->primary_color ?? '#6366f1' }};
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <!-- Card Header -->
        <div class="card-header">
            @if($school->logo)
                <img src="{{ public_path('storage/uploads/logos/' . $school->logo) }}" class="logo" alt="{{ $school->name }}">
            @endif
            <div class="school-name">{{ $school->name }}</div>
            <div class="card-type">STAFF ID CARD</div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Staff Photo -->
            <div class="photo-container">
                @if(file_exists(public_path('storage/uploads/staff-photos/' . $staff->school_id . '/' . $staff->id . '.jpg')))
                    <img src="{{ public_path('storage/uploads/staff-photos/' . $staff->school_id . '/' . $staff->id . '.jpg') }}" class="photo" alt="{{ $staff->name }}">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e0e0e0; color: #999; font-size: 14px;">
                        No Photo
                    </div>
                @endif
            </div>

            <!-- Staff Name -->
            <div class="staff-name">{{ $staff->name }}</div>

            <!-- Designation -->
            <div class="designation">{{ $staff->designation }}</div>

            <!-- Staff Information -->
            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">Staff Code:</span>
                    <span class="info-value">{{ $staff->staff_code }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Joining Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($staff->joining_date)->format('M d, Y') }}</span>
                </div>
                @if($staff->phone)
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $staff->phone }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contact Section -->
        <div class="contact-section">
            @if($school->address)
                {{ $school->address }}<br>
            @endif
            @if($school->phone)
                Phone: {{ $school->phone }}
            @endif
            @if($school->email)
                | Email: {{ $school->email }}
            @endif
        </div>

        <!-- Validity Period -->
        <div class="validity">
            VALID FOR ACADEMIC YEAR {{ now()->year }}-{{ now()->year + 1 }}
        </div>
    </div>
</body>
</html>
