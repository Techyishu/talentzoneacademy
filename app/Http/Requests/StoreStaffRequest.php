<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'staff_code' => [
                'required',
                'string',
                'max:50',
                'unique:staff,staff_code,NULL,id,school_id,' . $schoolId
            ],
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'joining_date' => 'required|date|before_or_equal:today',
            'salary' => 'nullable|numeric|min:0|max:9999999.99',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
            'status' => 'required|in:active,inactive',
            'show_on_website' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'staff_code.unique' => 'This staff code is already taken in your school.',
            'joining_date.before_or_equal' => 'Joining date cannot be in the future.',
            'photo.max' => 'Photo size must not exceed 2MB.',
        ];
    }
}
