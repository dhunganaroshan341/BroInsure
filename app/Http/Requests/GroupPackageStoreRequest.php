<?php

namespace App\Http\Requests;

use App\Rules\GroupPackageHeadingRule;
use Illuminate\Foundation\Http\FormRequest;

class GroupPackageStoreRequest extends CustomFormRequest
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
            'group_id'=>'required|exists:groups,id',
            'package_id'=>'required|exists:packages,id',
            'heading_id'=>'required|array',
            'heading_id.*'=>['required', new GroupPackageHeadingRule($this->package_id)],
            'amount'=>'required|array',
            'amount.*'=>['required','numeric', 'min:1'],
            'is_employee'=>'nullable|array',
            'is_spouse'=>'nullable|array',
            'is_child'=>'nullable|array',
            'is_parent'=>'nullable|array'
        ];
    }
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $headingIds = $this->input('heading_id', []);
            $amounts = $this->input('amount', []);

            if (count($headingIds) !== count($amounts)) {
                $validator->errors()->add('amount', 'Every Headings Should Have Amount.');
            }
        });
    }
}
