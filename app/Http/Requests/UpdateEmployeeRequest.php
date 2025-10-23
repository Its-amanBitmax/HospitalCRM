<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employeeId,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'hire_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Qualifications
            'qualifications' => 'nullable|array',
            'qualifications.*.id' => 'nullable|integer|exists:qualifications,id',
            'qualifications.*.degree' => 'nullable|string|max:255',
            'qualifications.*.institution' => 'nullable|string|max:255',
            'qualifications.*.year_completed' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),

            // Documents
            'documents' => 'nullable|array',
            'documents.*.document_type' => 'nullable|string|max:255',
            'documents.*.document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',

            // Payroll
            'payroll' => 'nullable|array',
            'payroll.salary' => 'nullable|numeric|min:0',
            'payroll.bank_account' => 'nullable|string|max:255',
            'payroll.bank_name' => 'nullable|string|max:255',
            'payroll.ifsc_code' => 'nullable|string|max:20',
            'payroll.upi_number' => 'nullable|string|max:50',
            'payroll.pf_number' => 'nullable|string|max:255',
            'payroll.payment_frequency' => 'nullable|in:Monthly,Weekly,Bi-weekly',

            // Addresses
            'addresses' => 'nullable|array',
            'addresses.*.id' => 'nullable|integer|exists:addresses,id',
            'addresses.*.address_type' => 'nullable|in:Home,Work,Other',
            'addresses.*.street' => 'nullable|string|max:255',
            'addresses.*.city' => 'nullable|string|max:255',
            'addresses.*.state' => 'nullable|string|max:255',
            'addresses.*.country' => 'nullable|string|max:255',
            'addresses.*.postal_code' => 'nullable|string|max:20',

            // Family Details
            'family_details' => 'nullable|array',
            'family_details.*.id' => 'nullable|integer|exists:family_details,id',
            'family_details.*.name' => 'nullable|string|max:255',
            'family_details.*.relationship' => 'nullable|string|max:255',
            'family_details.*.date_of_birth' => 'nullable|date',
            'family_details.*.contact_number' => 'nullable|string|max:20',

            // Shifts
            'shifts' => 'nullable|array',
            'shifts.*.id' => 'nullable|integer|exists:shifts,id',
            'shifts.*.shift_name' => 'nullable|string|max:255',
            'shifts.*.start_time' => 'nullable|date_format:H:i',
            'shifts.*.end_time' => 'nullable|date_format:H:i',

            // Professions
            'professions' => 'nullable|array',
            'professions.*.id' => 'nullable|integer|exists:professions,id',
            'professions.*.title' => 'nullable|string|max:255',
            'professions.*.department_id' => 'nullable|exists:departments,id',

            // Expertise
            'expertise' => 'nullable|array',
            'expertise.*.id' => 'nullable|integer|exists:expertise,id',
            'expertise.*.skill' => 'nullable|string|max:255',
            'expertise.*.proficiency_level' => 'nullable|in:Beginner,Intermediate,Advanced,Expert',
            'expertise.*.years_of_experience' => 'nullable|integer|min:0',
        ];
    }
}
