<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeReceiptRequest extends FormRequest
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
            'student_id' => [
                'required',
                'exists:students,id,school_id,' . $schoolId
            ],
            'amount' => 'required|numeric|min:0.01|max:9999999.99',
            'payment_mode' => 'required|in:cash,online,cheque,bank_transfer',
            'payment_date' => 'required|date|before_or_equal:today',
            'fee_month' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'student_id.exists' => 'The selected student does not belong to your school.',
            'amount.min' => 'Amount must be greater than zero.',
            'payment_date.before_or_equal' => 'Payment date cannot be in the future.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'student_id' => 'student',
            'payment_mode' => 'payment method',
            'fee_month' => 'fee period',
        ];
    }
}
