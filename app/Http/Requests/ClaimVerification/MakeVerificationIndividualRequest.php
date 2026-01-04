<?php

namespace App\Http\Requests\ClaimVerification;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class MakeVerificationIndividualRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "member_id" => ["required", "exists:members,id"],
            "claim_no" => ["required", "exists:claim_registers,id"],
            "relative_id" => ["nullable", "exists:member_relatives,id"],
            "type" => ["required", "in:reject_request,verify_request,approve_request"],
            "remarks" => ["nullable", "required_if:type,reject_request"],
        ];

    }
}
