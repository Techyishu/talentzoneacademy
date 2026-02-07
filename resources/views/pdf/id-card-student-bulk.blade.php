<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student ID Cards - Bulk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .page-break {
            page-break-after: always;
        }
        .id-card {
            width: 350px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            border: 3px solid {{ $school->primary_color ?? '#6366f1' }};
            margin: 0 auto 30px;
        }
        .card-header {
            background: {{ $school->primary_color ?? '#6366f1' }};
            color: white;
            padding: 15px;
            text-align: center;
        }
        .logo {
            max-width: 60px;
            max-height: 60px;
            margin-bottom: 8px;
            background: white;
            padding: 4px;
            border-radius: 50%;
        }
        .school-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .card-type {
            font-size: 11px;
            letter-spacing: 1px;
        }
        .card-body {
            padding: 15px;
            text-align: center;
        }
        .photo-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 10px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid {{ $school->primary_color ?? '#6366f1' }};
            background: #f0f0f0;
        }
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .student-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .info-section {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 11px;
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
            padding: 8px;
            font-size: 9px;
            color: #666;
            text-align: center;
            background: #f0f0f0;
        }
        .validity {
            background: {{ $school->primary_color ?? '#6366f1' }};
            color: white;
            padding: 6px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @foreach($students as $index => $student)
        <div class="id-card">
            <!-- Card Header -->
            <div class="card-header">
                @if($school->logo)
                    <img src="{{ public_path('storage/uploads/logos/' . $school->logo) }}" class="logo" alt="{{ $school->name }}">
                @endif
                <div class="school-name">{{ $school->name }}</div>
                <div class="card-type">STUDENT ID CARD</div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Student Photo -->
                <div class="photo-container">
                    @if($student->photo)
                        <img src="{{ public_path('storage/uploads/student-photos/' . $student->photo) }}" class="photo" alt="{{ $student->name }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e0e0e0; color: #999; font-size: 12px;">
                            No Photo
                        </div>
                    @endif
                </div>

                <!-- Student Name -->
                <div class="student-name">{{ $student->name }}</div>

                <!-- Student Information -->
                <div class="info-section">
                    <div class="info-row">
                        <span class="info-label">Admission No:</span>
                        <span class="info-value">{{ $student->admission_no }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Class:</span>
                        <span class="info-value">{{ $student->class }}{{ $student->section ? ' - ' . $student->section : '' }}</span>
                    </div>
                    @if($student->roll_no)
                        <div class="info-row">
                            <span class="info-label">Roll No:</span>
                            <span class="info-value">{{ $student->roll_no }}</span>
                        </div>
                    @endif
                </div>

                <!-- Guardian Contact -->
                @if($student->guardian_phone)
                    <div class="info-section">
                        <div class="info-row">
                            <span class="info-label">Emergency Contact:</span>
                            <span class="info-value">{{ $student->guardian_phone }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                @if($school->phone)
                    Phone: {{ $school->phone }}
                @endif
            </div>

            <!-- Validity Period -->
            <div class="validity">
                VALID {{ now()->year }}-{{ now()->year + 1 }}
            </div>
        </div>

        @if(($index + 1) % 3 == 0 && $index + 1 < count($students))
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
