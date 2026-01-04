<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupPackageDeleteRequest extends CustomFormRequest
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
            'group_id'=>'required|exists:group_packages,group_id',
            'package_id'=>'required|exists:group_packages,package_id',
        ];
    }
    public function attributes()
    {
        return [

            'group_id'=>'Group',
            'package_id'=>'Package',
        ];
    }
    public function messages()
    {
        return  [
            'group_id.exists'=>'Provided Group Has Not Been Assigned To Provided package',
            'package_id.exists'=>'Provided Package Has Not Been Assigned To Provided Group',
        ];
    }
}
