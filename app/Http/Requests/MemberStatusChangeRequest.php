<?php

namespace App\Http\Requests;

class MemberStatusChangeRequest extends CustomFormRequest
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
        $data = [
            'member_id' => 'required|exists:members,id',
            'is_active' => 'required|in:Y,N',
        ];

        return $data;
    }


}
