<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetailPolicyRequest extends FormRequest
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
        $rules = [
            'policy_no'=>'required|string',
            'actual_issue_date' => 'nullable|date',
            'issue_date' => 'nullable|date',
            'valid_date_type'=>'nullable',
            'colling_period' => 'nullable|numeric',
            'valid_date' => 'nullable|date',
            'imitation_days' => 'required|numeric',
            'nepal_ri' => 'required|integer|min:0',
            'himalayan_ri' => 'required|integer|min:0',
            'retention' => 'required|integer|min:0',
            'quota' => 'required|integer|min:0',
            'surplus_i' => 'required|integer|min:0',
            'surplus_ii' => 'required|integer|min:0',
            'auto_fac' => 'required|integer|min:0',
            'facultative' => 'required|integer|min:0',
            'co_insurance' => 'required|integer|min:0',
            'xol_i' => 'required|integer|min:0',
            'xol_ii' => 'required|integer|min:0',
            'xol_iii' => 'required|integer|min:0',
            'xol_iiii' => 'required|integer|min:0',
            'pool' => 'required|integer|min:0',
            'excess_value' => 'required|integer|min:0',
            'excess_type' => 'nullable|in:percentage',
            'premium_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'insured_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        ];
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = array_merge($rules, [
                'policy_id' => 'required|exists:company_policies,id',
                // 'client_id' => 'required|exists:clients,id',
                // 'policy_no' => 'required|unique:company_policies,policy_no,' . $this->policy_id,
            ]);
        }
        return $rules;
    }
}
