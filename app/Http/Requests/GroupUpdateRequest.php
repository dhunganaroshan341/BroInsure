<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends CustomFormRequest
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
        // dd($this->input('heading_id'),$this->input('amountNew'),$this->input('sub_heading_id'));
        $rules = [
            'id' => 'required|exists:groups',
            'name' => [
                'required',
                'string',
                Rule::unique('groups')
                    ->where(function ($query) {
                        return $query->where('client_id', $this->input('client_id'));
                    })
                    ->ignore($this->id),
            ],
            'code' => 'nullable|string|unique:groups,code,' . $this->id,
            'client_id' => 'required|exists:clients,id',
            'policy_id' => 'required|exists:company_policies,id',
            'insurance_amount' => 'required|numeric',
            'heading_id' => 'required|array',
            'heading_id.*' => ['required', 'exists:insurance_headings,id'],
            'sub_heading_id' => 'required|array',
            'sub_heading_id.*' => 'required|exists:insurance_sub_headings,id',
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
                $validator->errors()->add('total_amount', 'The sum of selected heading amount should be equal to insured amount');
            }
        });
    }
    public function attributes()
    {
        return [
            'amountNew' => 'Heading Amout'
        ];
    }
    public function messages()
    {
        return [
            'amountNew.*' => 'Selected Headings Amount is required.',
        ];
    }
}
