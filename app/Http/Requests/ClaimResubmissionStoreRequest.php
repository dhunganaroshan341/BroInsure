<?php

namespace App\Http\Requests;

use App\Models\InsuranceClaim;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
class ClaimResubmissionStoreRequest extends CustomFormRequest
{
    protected $firstClaim;
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
            'memberId' => 'required|exists:members,id|same:member_id',
            'heading_id' => 'required|exists:insurance_headings,id',
            'sub_heading_id' => 'required|exists:insurance_sub_headings,id',
            'relative_id' => 'nullable|exists:member_relatives,id',
            'document_type' => 'required|array',
            'document_type.*' => 'required|in:bill,prescription,report',
            'bill_file_name' => 'required|array',
            'bill_file_name.*' => 'required|string',
            'bill_file' => 'required|array',
            'bill_file.*' => 'required|file|mimes:png,jpg,jpeg',
            'document_date' => 'required|array',
            'document_date.*' => 'required|string',
            'remark' => 'required|array',
            'remark.*' => 'nullable|string',
            'bill_amount' => 'required|array',
            'bill_amount.*' => 'required|string',
            'clinical_facility_name' => 'required|array',
            'clinical_facility_name.*' => 'nullable|string',
            'diagnosis_treatment' => 'required|array',
            'diagnosis_treatment.*' => 'nullable|string',
            'bill_file_size' => 'required|array',
            'bill_file_size.*' => 'required|string',
            'save_type' => 'required|string',
        ];
    }
    protected function prepareForValidation()
    {
        $this->firstClaim = InsuranceClaim::with('relation')->where('claim_id', $this->claim_id)
            ->where('status', InsuranceClaim::STATUS_RESUBMISSION)
            ->firstOrFail();
        // Check if the member_id from firstClaim does not match with the request member_id
        $this->merge([
            'memberId' => (int) $this->firstClaim->member_id,
            'member_id' => (int) $this->member_id,
            'relative_id' => $this->firstClaim->relative_id,
        ]);
    }
    public function withValidator($validator)
    {
        $firstClaim = $this->firstClaim;
        $validator->after(function ($validator) use ($firstClaim) {
            $member = Member::where('id', $this->member_id)->with(['companyPolicies', 'allMemberPolicy'])->first();
            $memberPolicy =
                $member?->allMemberPolicy?->where('group_id', $firstClaim->group_id)->first() ?? collect();
            if ($member) {
                $issue_date = $memberPolicy?->issue_date;
                $imitation_days = $memberPolicy?->imitation_days;
                // Check if any insurance claim ID from InsuranceClaim has register_no not null
                $hasError = false;
                $end_date = null;
                if ($imitation_days) {
                    // $parsedIssueDate = Carbon::parse($issue_date);
                    $parsedIssueDate = Carbon::now()->startOfDay();
                    $end_date = $parsedIssueDate->addDays($imitation_days);
                }
                // foreach ($this->document_date as $index => $date) {
                //     $parsedDate = Carbon::parse($date);
                //     if ($end_date && $parsedDate->gt(Carbon::parse($end_date))) {
                //         $hasError = true;
                //         $validator->errors()->add('document_date', "Document date $date must be within $imitation_days days in row " . ($index + 1) . ".");
                //         break;
                //     }
                // }

                $sumByHeading = [];
                foreach ($this->bill_amount as $index => $amount) {
                    $headingId = $this->heading_id[$index];
                    if (!isset($sumByHeading[$headingId])) {
                        $sumByHeading[$headingId] = 0;
                    }
                    // Convert amount to numeric and sum it based on heading_id
                    $sumByHeading[$headingId] += (float) $amount;
                }
                foreach ($sumByHeading as $headingId => $amount) {
                    $memberId = $this->member_id;
                    $heading = $memberPolicy->group->headings->where('heading_id', $headingId)->first();
                    $groupPackageHeadingId = $heading->id;
                    $headingData = $heading->heading;
                    $headingId = $headingData->id;
                    $headingName = $headingData->name;
                    if ($firstClaim->relative_id) {
                        $type = null;
                        switch ($firstClaim->relation->rel_relation) {
                            case 'father':
                            case 'mother':
                            case 'mother-in-law':
                            case 'father-in-law':
                                $type = 'is_parent';
                                break;
                            case 'child1':
                            case 'child2':
                                $type = 'is_child';
                                break;
                            case 'spouse':
                                $type = 'is_spouse';
                                break;
                            default:
                                break;
                        }
                        if ($memberPolicy->group->is_amount_different !== 'Y') {
                            $insurancedAmount = $heading->amount;
                        } else {
                            $amountColumn = $type . '_amount';
                            $insurancedAmount = $heading->$amountColumn;
                        }
                        $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId, $firstClaim->relative_id);
                    } else {
                        $insurancedAmount = $heading->amount;
                        $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId);
                    }
                    $remainingAmount = $insurancedAmount - $claimedAmount;
                    if ($amount > $remainingAmount) {
                        $validator->errors()->add(
                            'bill_amount',
                            "Claimed amount $amount exceeds remaining $remainingAmount for '$headingName'."
                        );

                        break;
                    }
                }
            }
        });
    }
}
