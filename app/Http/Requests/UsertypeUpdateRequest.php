<?php

namespace App\Http\Requests;


class UsertypeUpdateRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'typename' => 'required|string|unique:usertype,typename,'.$this->id,
            'redirect_url' => 'nullable|string|max:255',
            'id' => 'required|exists:usertype,id',
        ];
    }
}
