<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

class ClaimStatusChangeRequest extends CustomFormRequest
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
            'member_id' => 'required|exists:insurance_claims,member_id',
            'claim_id' => 'required|exists:insurance_claims,claim_id',
            'relative_id' => 'nullable|exists:insurance_claims,relative_id',
            'remarks' => 'required|string',
            'type' => 'required|in:document_correction,resubmission,hold,release,reject_claim',
        ];
    }
}
