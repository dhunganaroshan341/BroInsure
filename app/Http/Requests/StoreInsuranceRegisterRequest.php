<?php

namespace App\Http\Requests;

use App\Models\InsuranceClaim;
use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceRegisterRequest extends CustomFormRequest
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
            'insurance_claim_id' => 'required|array',
            'insurance_claim_id.*' => 'required|exists:insurance_claims,id',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $insuranceClaimIds = $this->input('insurance_claim_id', []);

            // Check if any insurance claim ID from InsuranceClaim has register_no not null
            $hasError = false;
            foreach ($insuranceClaimIds as $claimId) {
                $submission = InsuranceClaim::where('id', $claimId)
                    ->whereNotNull('register_no')
                    ->first();

                if ($submission) {
                    $hasError = true;
                    $validator->errors()->add('insurance_claim_id', "Insurance claim with ID $claimId has already been registered.");
                    break;
                }
            }

        });
    }

    protected function prepareForValidation()
    {
        $this->merge(["insurance_claim_id" => json_decode($this->insurance_claim_id)]);
    }

}
