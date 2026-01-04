<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmployeeIdValidationRule;

class StoreInsuranceInitiateRequest extends CustomFormRequest
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
            'employee_id.*' => ['required', new EmployeeIdValidationRule],
        ];
    }
    public function messages()
    {
        return [
            'employee_id.*.required' => 'Employee ID is required.',
            'employee_id.*.employee_id_validation' => 'Invalid employee ID format.',
        ];
    }
}
