<?php

namespace App\Http\Requests\ClaimVerification;

use Illuminate\Foundation\Http\FormRequest;

class MakeVerificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "data" => ["required", "array"],
            "data.*.member_id" => ["required"],
            "data.*.claim_no" => ["required"],
            "data.*.relative_id" => ["nullable"],
        ];
    }
}
