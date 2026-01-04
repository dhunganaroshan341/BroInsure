<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PremiumRequest extends FormRequest
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
            'base_rate'=>'required|numeric',
            'dependent_factor'=>'required|numeric',
            'age_factor'=>'required|numeric',
            'period_factor'=>'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'base_rate.required'=>'Please enter the base rate.',
            'base_rate.numeric'=>'Base rate must be a type of number.',
            'dependent_factor.required'=>'Please enter dependent factor.',
            'dependent_factor.numeric'=>'Dependent factor must a type of number.',
            'age_factor.required'=>'Please enter age factor.',
            'age_factor.numeric'=>'Age factor must a type of number.',
            'period_factor.required'=>'Please enter period factor.',
            'period_factor.numeric'=>'Period factor must a type of number.',
        ];
    }
}
