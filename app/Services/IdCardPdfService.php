<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Staff;
use Barryvdh\DomPDF\Facade\Pdf;

class IdCardPdfService
{
    /**
     * Generate PDF for a student ID card.
     */
    public function generateStudent(Student $student)
    {
        $student->load('school');

        $pdf = Pdf::loadView('pdf.id-card-student', [
            'student' => $student,
            'school' => $student->school,
        ]);

        // Set paper size to A4 portrait for standard ID card
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Generate PDF for a staff ID card.
     */
    public function generateStaff(Staff $staff)
    {
        $staff->load('school');

        $pdf = Pdf::loadView('pdf.id-card-staff', [
            'staff' => $staff,
            'school' => $staff->school,
        ]);

        // Set paper size to A4 portrait for standard ID card
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Download PDF for a student ID card.
     */
    public function downloadStudent(Student $student)
    {
        $filename = 'id_card_student_' . $student->admission_no . '.pdf';
        return $this->generateStudent($student)->download($filename);
    }

    /**
     * Download PDF for a staff ID card.
     */
    public function downloadStaff(Staff $staff)
    {
        $filename = 'id_card_staff_' . $staff->staff_code . '.pdf';
        return $this->generateStaff($staff)->download($filename);
    }

    /**
     * Stream PDF for a student ID card.
     */
    public function streamStudent(Student $student)
    {
        $filename = 'id_card_student_' . $student->admission_no . '.pdf';
        return $this->generateStudent($student)->stream($filename);
    }

    /**
     * Stream PDF for a staff ID card.
     */
    public function streamStaff(Staff $staff)
    {
        $filename = 'id_card_staff_' . $staff->staff_code . '.pdf';
        return $this->generateStaff($staff)->stream($filename);
    }

    /**
     * Generate bulk ID cards for all students in a class.
     */
    public function generateBulkByClass($classValue, $sectionValue = null)
    {
        $query = Student::where('school_id', session('active_school_id'))
            ->where('status', 'active')
            ->where('class', $classValue);

        if ($sectionValue) {
            $query->where('section', $sectionValue);
        }

        $students = $query->orderBy('roll_no')->get();

        if ($students->isEmpty()) {
            return null;
        }

        $students->load('school');

        $pdf = Pdf::loadView('pdf.id-card-student-bulk', [
            'students' => $students,
            'school' => $students->first()->school,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Generate bulk ID cards for all staff members.
     */
    public function generateAllStaff()
    {
        $staff = Staff::where('school_id', session('active_school_id'))
            ->where('status', 'active')
            ->orderBy('staff_code')
            ->get();

        if ($staff->isEmpty()) {
            return null;
        }

        $staff->load('school');

        $pdf = Pdf::loadView('pdf.id-card-staff-bulk', [
            'staffMembers' => $staff,
            'school' => $staff->first()->school,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }
}
