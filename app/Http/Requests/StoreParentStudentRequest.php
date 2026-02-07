<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParentStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $schoolId = session('active_school_id');

        return [
            // Parent information
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|max:255',
            'parent_phone' => 'required|string|max:20',

            // Students array
            'students' => 'required|array|min:1',
            'students.*.admission_no' => [
                'required',
                'string',
                'max:50',
                'distinct', // Must be unique within the request
                'unique:students,admission_no,NULL,id,school_id,' . $schoolId
            ],
            'students.*.name' => 'required|string|max:255',
            'students.*.gender' => 'required|in:male,female,other',
            'students.*.dob' => 'required|date|before:today',
            'students.*.class' => 'nullable|string|max:50',
            'students.*.section' => 'nullable|string|max:50',
            'students.*.class_id' => 'required|exists:classes,id',
            'students.*.section_id' => 'nullable|exists:sections,id',
            'students.*.roll_no' => 'nullable|integer|min:1',
            'students.*.relationship' => 'required|in:father,mother,guardian,other',
            'students.*.address' => 'nullable|string|max:500',
            'students.*.status' => 'nullable|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'students.required' => 'At least one student must be added.',
            'students.min' => 'At least one student must be added.',
            'students.*.admission_no.unique' => 'This admission number is already taken in your school.',
            'students.*.admission_no.distinct' => 'Duplicate admission numbers are not allowed.',
            'students.*.dob.before' => 'Date of birth must be in the past.',
            'students.*.class_id.required' => 'Class is required for each student.',
            'students.*.class_id.exists' => 'Selected class does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure students is an array
        if (! $this->has('students')) {
            $this->merge(['students' => []]);
        }
    }
}
