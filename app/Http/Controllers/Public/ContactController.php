<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\School;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'student_name' => 'nullable|string|max:255',
            'grade' => 'required|string|max:10',
            'school' => 'required|string|in:karnal,kurukshetra',
            'message' => 'nullable|string|max:5000',
        ]);

        $slugToCode = [
            'karnal' => 'TAK',
            'kurukshetra' => 'TAKK',
        ];
        $school = School::where('code', $slugToCode[$validated['school']])->firstOrFail();

        $subject = "Admission Enquiry - Class {$validated['grade']}";
        if (!empty($validated['student_name'])) {
            $subject .= " ({$validated['student_name']})";
        }

        $messageBody = "Student Name: " . ($validated['student_name'] ?: 'Not provided') . "\n";
        $messageBody .= "Grade Seeking: Class {$validated['grade']}\n";
        if (!empty($validated['message'])) {
            $messageBody .= "\n{$validated['message']}";
        }

        ContactSubmission::create([
            'school_id' => $school->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $subject,
            'message' => $messageBody,
        ]);

        return redirect()->route('contact')
            ->with('success', 'Thank you for your enquiry! We will get back to you within 24 hours.');
    }
}
