<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenewPolicyRequest extends CustomFormRequest
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
                $rules = [
                'name' => 'required|unique:insurance_headings,name',
            ];
        return $rules;
    }
}
