<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Staff;
use App\Services\IdCardPdfService;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    protected $idCardService;

    public function __construct(IdCardPdfService $idCardService)
    {
        $this->idCardService = $idCardService;
    }

    /**
     * Show image download page for a single student ID card.
     */
    public function generateStudent(Student $student)
    {
        $student->load('school');

        return view('admin.id-cards.download-student-image', [
            'student' => $student,
            'school' => $student->school,
        ]);
    }

    /**
     * Show image download page for a single staff ID card.
     */
    public function generateStaff(Staff $staff)
    {
        $staff->load('school');

        return view('admin.id-cards.download-staff-image', [
            'staff' => $staff,
            'school' => $staff->school,
        ]);
    }

    /**
     * Generate bulk ID cards for students by class and section (PDF format).
     */
    public function generateBulkByClass(Request $request)
    {
        $class = $request->input('class');
        $section = $request->input('section');

        if (!$class) {
            return back()->with('error', 'Please select a class.');
        }

        $pdf = $this->idCardService->generateBulkByClass($class, $section);

        if (!$pdf) {
            return back()->with('error', 'No active students found for the selected class/section.');
        }

        $filename = 'id_cards_' . str_replace(' ', '_', $class);
        if ($section) {
            $filename .= '_' . $section;
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Show form to select class/section for bulk student ID card generation.
     */
    public function showBulkStudentForm()
    {
        // Get distinct classes and sections
        $classes = Student::where('school_id', session('active_school_id'))
            ->where('status', 'active')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('admin.id-cards.bulk-student', compact('classes'));
    }

    /**
     * Generate bulk ID cards for all staff members (PDF format).
     */
    public function generateAllStaff()
    {
        $pdf = $this->idCardService->generateAllStaff();

        if (!$pdf) {
            return back()->with('error', 'No active staff members found.');
        }

        return $pdf->download('id_cards_all_staff.pdf');
    }
}
