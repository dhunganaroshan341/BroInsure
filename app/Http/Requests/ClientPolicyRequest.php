<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ClientPolicyRequest extends CustomFormRequest
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
        // dd($this->all());
        $rules = [
            'actual_issue_date' => 'required|date',
            'issue_date' => 'required|date',
            'valid_date' => 'required|date|after:issue_date',
            'imitation_days' => 'required|integer|min:1',
            'member_no' => 'required|integer|min:1',
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
                'policy_no' => 'required|unique:company_policies,policy_no,' . $this->policy_id,
            ]);
        } else {
            $rules = array_merge($rules, [
                'client_id' => 'required|exists:clients,id',
                'policy_no' => 'required|unique:company_policies,policy_no',
            ]);
        }
        return $rules;
    }

    public function withValidator(Validator $validator)
    {
        // $validator->after(function ($validator){
        //     $total=$this->nepal_ri+$this->input('himalayan_ri')+$this->input('retention')+$this->input('quota')+$this->input('surplus_i')+$this->input('surplus_ii')+$this->input('auto_fac')+$this->input('facultative')+$this->input('co_insurance')+$this->input('xol_i')+$this->input('xol_ii')+$this->input('xol_iii')+$this->input('xol_iiii')+$this->input('pool');
        //     if ( $total!=100) {
        //         $validator->errors()->add('Reinsurance %', 'The sum of Reinsurance should be 100%.');
        //     }

        // });
        $validator->sometimes('excess_value', 'min:0|max:99', function ($input) {
            return $input->excess_type === 'percentage';
        });
    }
    public function messages()
    {
        return [
            'excess_value.min' => 'The :attribute must be at least :min when the excess type is percentage.',
            'excess_value.max' => 'The :attribute must not exceed :max when the excess type is percentage.',
            'insured_amount.regex' => 'The :attribute must be equal to or more than 0.',
            'premium_amount.regex' => 'The :attribute must be equal to or more than 0.',
        ];
    }
    public function attributes()
    {
        return [
            'issue_date' => 'Start Date',
            'actual_issue_date' => 'Issue Date',
        ];
    }
}
