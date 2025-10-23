<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'hire_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Qualifications
            'qualifications' => 'nullable|array',
            'qualifications.*.degree' => 'required|string|max:255',
            'qualifications.*.institution' => 'required|string|max:255',
            'qualifications.*.year_completed' => 'required|integer|min:1900|max:' . (date('Y') + 10),

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
            'addresses.*.address_type' => 'required|in:Home,Work,Other',
            'addresses.*.street' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
            'addresses.*.postal_code' => 'nullable|string|max:20',

            // Family Details
            'family_details' => 'nullable|array',
            'family_details.*.name' => 'required|string|max:255',
            'family_details.*.relationship' => 'required|string|max:255',
            'family_details.*.date_of_birth' => 'nullable|date',
            'family_details.*.contact_number' => 'nullable|string|max:20',

            // Shifts
            'shifts' => 'nullable|array',
            'shifts.*.shift_name' => 'required|string|max:255',
            'shifts.*.start_time' => 'required|date_format:H:i',
            'shifts.*.end_time' => 'required|date_format:H:i',

            // Professions
            'professions' => 'nullable|array',
            'professions.*.title' => 'required|string|max:255',
            'professions.*.department_id' => 'nullable|exists:departments,id',

            // Expertise
            'expertise' => 'nullable|array',
            'expertise.*.skill' => 'required|string|max:255',
            'expertise.*.proficiency_level' => 'required|in:Beginner,Intermediate,Advanced,Expert',
            'expertise.*.years_of_experience' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'qualifications.*.degree.required' => 'Degree is required for each qualification.',
            'qualifications.*.institution.required' => 'Institution is required for each qualification.',
            'qualifications.*.year.required' => 'Year is required for each qualification.',
            'documents.*.document_type.required' => 'Document type is required for each document.',
            'addresses.*.address_type.required' => 'Address type is required for each address.',
            'addresses.*.street.required' => 'Street is required for each address.',
            'addresses.*.city.required' => 'City is required for each address.',
            'addresses.*.state.required' => 'State is required for each address.',
            'addresses.*.country.required' => 'Country is required for each address.',
            'family_details.*.name.required' => 'Name is required for each family member.',
            'family_details.*.relationship.required' => 'Relationship is required for each family member.',
            'shifts.*.shift_name.required' => 'Shift name is required for each shift.',
            'shifts.*.start_time.required' => 'Start time is required for each shift.',
            'shifts.*.end_time.required' => 'End time is required for each shift.',
            'professions.*.title.required' => 'Title is required for each profession.',
            'professions.*.department.required' => 'Department is required for each profession.',
            'expertise.*.skill.required' => 'Skill is required for each expertise.',
            'expertise.*.proficiency_level.required' => 'Proficiency level is required for each expertise.',
        ];
    }
}
