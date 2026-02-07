<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'admission_no' => [
                'required',
                'string',
                'max:50',
                'unique:students,admission_no,NULL,id,school_id,' . $schoolId
            ],
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date|before:today',
            'class' => 'nullable|string|max:50', // Keep for backward compatibility
            'section' => 'nullable|string|max:50', // Keep for backward compatibility
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'roll_no' => 'nullable|integer|min:1',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
            'status' => 'required|in:active,inactive',

            // Optional parent linking fields
            'link_parent' => 'nullable|boolean',
            'parent_name' => 'required_if:link_parent,true|string|max:255',
            'parent_email' => 'required_if:link_parent,true|email|max:255',
            'parent_phone' => 'required_if:link_parent,true|string|max:20',
            'relationship' => 'required_if:link_parent,true|in:father,mother,guardian,other',
            'create_parent_account' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'admission_no.unique' => 'This admission number is already taken in your school.',
            'dob.before' => 'Date of birth must be in the past.',
            'photo.max' => 'Photo size must not exceed 2MB.',
        ];
    }
}
