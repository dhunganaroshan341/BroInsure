<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends CustomFormRequest
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
            'heading_id' => 'required|array',
            'heading_id.*' => 'required|exists:insurance_headings,id',
            'sub_heading_id' => 'required|array',
            'sub_heading_id.*' => 'required|exists:insurance_sub_headings,id',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = ['required', 'unique:packages,name'];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['id'] = ['required', 'exists:packages,id'];
            $rules['name'] = ['required', 'unique:packages,name,' . $this->id];
        }

        return $rules;
    }
}
