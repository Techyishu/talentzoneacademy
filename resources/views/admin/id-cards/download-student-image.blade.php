<x-layouts.admin>
    <x-slot name="title">Download ID Card</x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-heading">Download ID Card</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">Download {{ $student->name }}'s ID card as an image
                </p>
            </div>
            <a href="{{ route('admin.students.show', $student) }}"
                class="inline-flex items-center px-3 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        <!-- Download Buttons -->
        <div class="flex gap-3">
            <button id="downloadPng"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-700 hover:to-primary-600 shadow-lg transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download PNG
            </button>
            <button id="downloadJpg"
                class="inline-flex items-center px-4 py-2 border-2 border-primary-300 rounded-xl text-sm font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download JPG
            </button>
        </div>

        <!-- ID Card Preview -->
        <div class="flex justify-center p-8 bg-slate-100 rounded-xl">
            <div id="idCard" class="id-card">
                <!-- Card Header -->
                <div class="card-header" style="background: {{ $school->primary_color ?? '#6366f1' }};">
                    @if($school->logo)
                        <img src="{{ asset('storage/uploads/logos/' . $school->logo) }}" class="logo"
                            alt="{{ $school->name }}">
                    @endif
                    <div class="school-name">{{ $school->name }}</div>
                    <div class="card-type">STUDENT ID CARD</div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Student Photo -->
                    <div class="photo-container" style="border-color: {{ $school->primary_color ?? '#6366f1' }};">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" class="photo" alt="{{ $student->name }}">
                        @else
                            <div class="no-photo">No Photo</div>
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
                            <span
                                class="info-value">{{ $student->class }}{{ $student->section ? ' - ' . $student->section : '' }}</span>
                        </div>
                        @if($student->roll_no)
                            <div class="info-row">
                                <span class="info-label">Roll No:</span>
                                <span class="info-value">{{ $student->roll_no }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Date of Birth:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($student->dob)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Guardian Information -->
                    @if($student->guardian_name || $student->guardian_phone)
                        <div class="info-section">
                            @if($student->guardian_name)
                                <div class="info-row">
                                    <span class="info-label">Guardian:</span>
                                    <span class="info-value">{{ $student->guardian_name }}</span>
                                </div>
                            @endif
                            @if($student->guardian_phone)
                                <div class="info-row">
                                    <span class="info-label">Contact:</span>
                                    <span class="info-value">{{ $student->guardian_phone }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
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
                <div class="validity" style="background: {{ $school->primary_color ?? '#6366f1' }};">
                    VALID FOR ACADEMIC YEAR {{ now()->year }}-{{ now()->year + 1 }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .id-card {
            width: 350px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 3px solid
                {{ $school->primary_color ?? '#6366f1' }}
            ;
        }

        .card-header {
            color: white;
            padding: 20px;
            text-align: center;
        }

        .logo {
            max-width: 80px;
            max-height: 80px;
            margin: 0 auto 10px;
            display: block;
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
            border: 3px solid;
            background: #f0f0f0;
        }

        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-photo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e0e0e0;
            color: #999;
            font-size: 14px;
        }

        .student-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
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
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
        }
    </style>

    <!-- html2canvas Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadImage(format) {
            const element = document.getElementById('idCard');
            const filename = 'id_card_{{ $student->admission_no }}.' + format;

            html2canvas(element, {
                scale: 2, // Higher quality
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = filename;

                if (format === 'jpg' || format === 'jpeg') {
                    link.href = canvas.toDataURL('image/jpeg', 0.95);
                } else {
                    link.href = canvas.toDataURL('image/png');
                }

                link.click();
            });
        }

        document.getElementById('downloadPng').addEventListener('click', () => downloadImage('png'));
        document.getElementById('downloadJpg').addEventListener('click', () => downloadImage('jpg'));
    </script>
</x-layouts.admin>