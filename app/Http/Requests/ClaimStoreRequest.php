<?php

namespace App\Http\Requests;

use App\Models\Member;
use App\Models\MemberPolicy;
use App\Models\MemberRelative;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ClaimStoreRequest extends CustomFormRequest
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
            'policy_id' => 'required_if:type,old',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($this->type) && $this->type == 'old') {
                $memberId = $this->member_id;
                $relative_id = $this->relative_id;
                $policy_id = $this->policy_id;
                $type = null;
                if ($relative_id) {
                    $dependent = MemberRelative::where('id', $relative_id)->first();
                    switch ($dependent->rel_relation) {
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
                }
                $memberPolicy = MemberPolicy::with([
                    'group.headings' => function ($query) use ($relative_id, $type) {
                        $query->when($relative_id, function ($q1) use ($type) {
                            $q1->where($type, 'Y');
                        });
                    }
                ])
                    ->where('member_id', $memberId)
                    ->whereHas('companyPolicy', function ($q) use ($policy_id) {
                        $q->where('id', $policy_id)
                        ;
                    })
                    ->first();
                if (is_null($memberPolicy)) {
                    $validator->errors()->add('member_id', "Company policy has not been created");
                    return;
                }
                if ($memberPolicy) {
                    $issue_date = $memberPolicy?->companyPolicy?->issue_date;
                    $imitation_days = $memberPolicy?->companyPolicy?->imitation_days;
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
                }

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
                    if ($this->relative_id) {
                        if ($memberPolicy->group->is_amount_different !== 'Y') {
                            $insurancedAmount = $heading->amount;
                        } else {
                            $amountColumn = $type . '_amount';
                            $insurancedAmount = $heading->$amountColumn;
                        }
                        $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId, $dependent->id);
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
            } else {
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
                    // foreach ($this->document_date as $index => $date) {
                    //     $parsedDate = Carbon::parse($date);
                    //     if ($end_date && $parsedDate->gt(Carbon::parse($end_date))) {
                    //         $hasError = true;
                    //         $validator->errors()->add('document_date', "Document date $date must be within $imitation_days days in row " . ($index + 1) . ".");
                    //         break;
                    //     }
                    // }
                }
                if ($this->relative_id) {
                    $dependent = MemberRelative::where('id', $this->relative_id)->first();
                    $type = null;
                    switch ($dependent->rel_relation) {
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
                    $otherDetails = Member::whereHas('relatives', function ($q) {
                        $q->where('id', $this->relative_id);
                    })->with([
                                'currentMemberPolicy.group.headings' => function ($query) use ($type) {
                                    $query->where($type, 'Y');
                                },
                                'companyPolicies'
                            ])->first();
                } else {
                    $otherDetails = Member::where('id', $this->member_id)
                        ->with(['currentMemberPolicy.group.headings', 'companyPolicies'])
                        ->first();
                }
                if (is_null($otherDetails)) {
                    $validator->errors()->add('member_id', "Member not found");
                    return;
                }
                if (is_null($otherDetails->companyPolicies->first())) {
                    $validator->errors()->add('member_id', "Company policy has not been created");
                    return;
                }
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
                    $heading = $otherDetails->currentMemberPolicy->group->headings->where('heading_id', $headingId)->first();
                    $groupPackageHeadingId = $heading->id;
                    $headingData = $heading->heading;
                    $headingId = $headingData->id;
                    $headingName = $headingData->name;
                    if ($this->relative_id) {
                        if ($otherDetails->currentMemberPolicy->group->is_amount_different !== 'Y') {
                            $insurancedAmount = $heading->amount;
                        } else {
                            $amountColumn = $type . '_amount';
                            $insurancedAmount = $heading->$amountColumn;
                        }
                        $claimedAmount = claimedAmount($memberId, $groupPackageHeadingId, $headingId, $dependent->id);
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
