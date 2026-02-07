<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $schoolId = $this->route('school')->id;

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                "unique:schools,code,{$schoolId}",
                'regex:/^[A-Z0-9]+$/',
            ],
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'receipt_prefix' => 'required|string|max:10|regex:/^[A-Z]+$/',
            'signature_image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.regex' => 'School code must contain only uppercase letters and numbers.',
            'code.unique' => 'This school code is already in use.',
            'primary_color.regex' => 'Primary color must be a valid hex color code (e.g., #6366f1).',
            'secondary_color.regex' => 'Secondary color must be a valid hex color code (e.g., #10b981).',
            'receipt_prefix.regex' => 'Receipt prefix must contain only uppercase letters.',
        ];
    }
}
