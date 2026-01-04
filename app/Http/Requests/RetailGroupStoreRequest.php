<?php

namespace App\Http\Requests;

use App\Rules\GroupPackageHeadingRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RetailGroupStoreRequest extends CustomFormRequest
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
        // dd($this->heading_id);
        $rules = [
            'name' => [
                'required',
                'string',
                Rule::unique('groups')->where(function ($q) {
                    return $q->where('client_id', 1);
                })
            ],
            'code' => 'nullable|string|unique:groups,code',
            // 'client_id' => 'required|exists:clients,id',
            'insurance_amount' => 'required|numeric',
            'policy_id' => 'required|exists:company_policies,id',
            'heading_id' => 'required|array',
            'heading_id.*' => ['required', 'exists:insurance_headings,id'],
            'sub_heading_id' => 'required|array',
            'sub_heading_id.*' => 'required|exists:insurance_sub_headings,id',
            // 'access_type' => 'nullable|array',
            // 'access_type.*' => 'nullable|in:fixed,percentage',
            // 'limit_number' => 'nullable|array',
            // 'limit_number.*' => 'nullable|numeric',
            'is_employee.*' => 'in:Y,N',
            'is_spouse.*' => 'in:Y,N',
            'is_child.*' => 'in:Y,N',
            'is_parent.*' => 'in:Y,N',
            'amountNew' => 'required|array',
            // 'amount.*'=>['required','numeric', 'min:1'],
            'is_employee' => 'nullable|array',
            'is_spouse' => 'nullable|array',
            'is_child' => 'nullable|array',
            'is_parent' => 'nullable|array',
            'is_spouse_amount' => 'nullable|array',
            'is_spouse_amount.*' => 'nullable|numeric',
            'is_child_amount' => 'nullable|array',
            'is_child_amount.*' => 'nullable|numeric',
            'is_parent_amount' => 'nullable|array',
            'is_parent_amount.*' => 'nullable|numeric',
            'is_amount_different' => 'nullable|in:Y',
            'is_imitation_days_different' => 'required|in:Y,N',
        ];
        foreach ($this->input('heading_id', []) as $index => $headingId) {
            if ($headingId) {
                $rules["amountNew.$index"] = ['required', 'numeric', 'min:1'];
                if ($this->is_imitation_days_different == 'Y') {
                    $rules["imitation_days.$index"] = ['required', 'numeric', 'min:1'];
                }
            } else {
                $rules["amountNew.$index"] = ['nullable'];
                $rules["imitation_days.$index"] = ['nullable'];
            }
        }
        return $rules;
    }
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // $headingIds = $this->input('heading_id', []);
            // $amounts = $this->input('amount', []);

            // if (count($headingIds) !== count($amounts)) {
            //     $validator->errors()->add('amount', 'Every Headings Should Have Amount.');
            // }
            $amounts = $this->input('amountNew', []);
            $totalAmt = 0;
            foreach ($this->input('heading_id', []) as $key => $headingId) {
                if ($headingId && isset($amounts[$key])) {
                    $totalAmt += $amounts[$key];
                }
            }
            $insuranceAmount = (float) $this->input('insurance_amount');
            if ($totalAmt != $insuranceAmount) {
                $validator->errors()->add('total_amount', 'The sum of selected heading should be equal to insured amount');
            }
        });
    }
    public function attributes()
    {
        return [
            'amountNew' => 'Heading Amout'
        ];
    }
}
