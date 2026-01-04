<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends CustomFormRequest
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
            'name'=>'required|string',
            'code'=>'nullable|string',
            'mobile'=>'nullable|min:8,max:11|string',
            'land_line'=>'nullable|string',
            'address'=>'nullable|string',
            'email'=>'nullable|email',
            'province_id'=>'required|exists:states,id',
            'district_id'=>'required|exists:districts,id',
            'city_id'=>'required|exists:vdcmcpts,id',
            'contact_person'=>'nullable|string',
            'contact_person_contact'=>'nullable|string',
            'pan'=>'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120',
            'registration'=>'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120',
            'tax_clearence'=>'nullable|file|mimes:png,jpeg,jpg,pdf|max:5120',
        ];
    }
}
