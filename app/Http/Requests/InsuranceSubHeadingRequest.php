<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceSubHeadingRequest extends CustomFormRequest
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
        $rules = [];
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = [
                'id' => 'required|exists:insurance_sub_headings,id',
                'heading_id' => 'required|exists:insurance_headings,id',
                'name' => 'required|unique:insurance_sub_headings,name,' . $this->id,
            ];
        } else {
            $rules = [
                'name' => 'required|unique:insurance_sub_headings,name',
                'heading_id' => 'required|exists:insurance_headings,id',
            ];
        }
        return $rules;
    }
}
