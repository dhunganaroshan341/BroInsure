<?php

namespace App\Http\Requests\ClaimList;

use App\Http\Requests\CustomFormRequest;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClaimRequest extends CustomFormRequest
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
            'member_id' => 'required|exists:members,id',
            'relative_id' => 'nullable|exists:member_relatives,id',
            'bill_file' => 'nullable|file|mimes:png,jpg,pdf,jpeg',
            'bill_file_name' => [Rule::requiredIf(!is_null($this->bill_file)), 'string', 'max:255'],
            'heading_id' => 'required|exists:insurance_headings,id',
            'sub_heading_id' => 'required|exists:insurance_sub_headings,id',
            'document_type' => 'required|in:bill,prescription,report',
            'bill_amount' => 'required|string|max:255',
            'document_date' => 'required|date',
            'remark' => 'required|string|max:255',
            'clinical_facility_name' => 'required|string|max:255',
            'diagnosis_treatment' => 'required|string|max:255',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $member = Member::where('id', $this->member_id)->with(['companyPolicies'])->first();
            if ($member) {
                $issue_date = $member?->companyPolicies[0]?->issue_date;
                $imitation_days = $member?->companyPolicies[0]?->imitation_days;
                // Check if any insurance claim ID from InsuranceClaim has register_no not null
                $hasError = false;
                $end_date = null;
                if ($imitation_days) {
                    // $parsedIssueDate = Carbon::parse($issue_date);
                    $parsedIssueDate = Carbon::now()->startOfDay();
                    $end_date = $parsedIssueDate->addDays($imitation_days);
                }
                $parsedDate = Carbon::parse($this->document_date);
                // if ($end_date && $parsedDate->gt(Carbon::parse($end_date))) {
                //     $hasError = true;
                //     $endDDate = $end_date->toDateString();
                //     $validator->errors()->add('document_date', "Document date $this->document_date must be within $imitation_days days.");

                // }
            }
        });
    }
}
