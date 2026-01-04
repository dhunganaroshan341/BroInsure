<?php

namespace App\Http\Requests;

use App\Models\MemberRelative;
use App\Rules\ClientMemberLimit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberStoreRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if (!$this->has('member_type')) {
            $this->merge(['member_type' => 'individual']);
        }
        if (!$this->has('personal.client_id')) {
            $this->merge(['personal' => array_merge($this->get('personal', []), ['client_id' => 1])]);
        }
        if (!$this->has('policy.type')) {
            $this->merge(['policy' => array_merge($this->get('policy', []), ['type' => 'individual'])]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        $member_type = $this->input('member_type');
        if ($member_type == 'group') {
            $data = [
                'personal.first_name' => 'required|string|max:255',
                'personal.middle_name' => 'nullable|string|max:255',
                'personal.last_name' => 'required|string|max:255',
                'personal.nationality' => 'required|string|max:255',
                'personal.date_of_birth_ad' => 'required|date',
                'personal.date_of_birth_bs' => 'required|string|max:255',
                'personal.gender' => 'required|string|in:male,female,other',
                'personal.marital_status' => 'required|string|in:single,married,unmarried,maritalOther',
                // 'personal.mail_address' => 'required|string|max:255',
                // 'personal.phone_number' => 'nullable|regex:/^\d{9,10}$/',
                // 'personal.mobile_number' => 'required|regex:/^\d{9,10}$/',
                'personal.email' => 'required|email',
                'personal.employee_id' => 'required|string',
                'personal.branch' => 'nullable|string',
                'personal.designation' => 'nullable|string',

                // 'address.perm_province' => 'required|string|max:255',
                // 'address.perm_district' => 'required|string|max:255',
                // 'address.perm_city' => 'required|string|max:255',
                // 'address.perm_ward_no' => 'required|string|max:255',
                // 'address.perm_street' => 'required|string|max:255',
                // 'address.perm_house_no' => 'nullable|string|max:255',
                // 'address.is_address_same' => 'nullable|in:on',
                // 'address.present_province' => 'nullable|string|max:255',
                // 'address.present_district' => 'nullable|string|max:255',
                // 'address.present_city' => 'nullable|string|max:255',
                // 'address.present_ward_no' => 'nullable|string|max:255',
                // 'address.present_street' => 'nullable|string|max:255',
                // 'address.present_house_no' => 'nullable|string|max:255',

                // 'citizenship.citizenship_no' => 'required|string|max:255',
                // 'citizenship.citizenship_district' => 'required|string|max:255',
                // 'citizenship.citizenship_issued_date' => 'required|date',
                // 'citizenship.occupation' => 'required|string|max:255',
                // // 'citizenship.income_source' => 'required|string|max:255',
                // 'citizenship.occupation_other' => 'nullable|string|max:255',

                'rel_relation' => 'nullable|array',
                'rel_relation.*' => 'nullable|string|in:father,mother,mother-in-law,father-in-law,spouse,child1,child2',
                'rel_name' => 'nullable|array',
                'rel_name.*' => 'nullable|string|max:255',
                'rel_dob' => 'nullable|array',
                'rel_dob.*' => 'nullable|date',
                'rel_gender' => 'nullable|array',
                'rel_gender.*' => 'nullable|string|in:male,female,other',

                'attachment_name' => 'nullable|array',
                'attachment_name.*' => 'nullable|string|max:255',

                'files' => 'nullable|array',
                'files.*' => 'nullable|file|mimes:pdf|max:2048',

                'personal.policy_id' => ['required', 'exists:company_policies,id'],
                // 'policy.package_id' => 'required|exists:packages,id',
                // 'policy.group_id' => 'nullable|exists:groups,id',
                'policy.type' => 'required|in:hr,member,individual',
                'member_type' => 'required|in:group,individual'
            ];
        } else {
            $data = [
                'personal.first_name' => 'required|string|max:255',
                'personal.middle_name' => 'nullable|string|max:255',
                'personal.last_name' => 'required|string|max:255',
                'personal.nationality' => 'required|string|max:255',
                'personal.date_of_birth_ad' => 'required|date',
                'personal.date_of_birth_bs' => 'required|string|max:255',
                'personal.gender' => 'required|string|in:male,female,other',
                'personal.marital_status' => 'required|string|in:single,married,unmarried,maritalOther',
                // 'personal.mail_address' => 'required|string|max:255',
                // 'personal.phone_number' => 'nullable|regex:/^\d{9,10}$/',
                'personal.mobile_number' => 'required|regex:/^\d{9,10}$/',
                'personal.email' => 'required|email',
                'personal.employee_id' => 'required|string',
                'personal.branch' => 'nullable|string',
                'personal.designation' => 'nullable|string',

                'address.perm_province' => 'required|string|max:255',
                'address.perm_district' => 'required|string|max:255',
                'address.perm_city' => 'required|string|max:255',
                'address.perm_ward_no' => 'required|string|max:255',
                'address.perm_street' => 'required|string|max:255',
                'address.perm_house_no' => 'nullable|string|max:255',
                'address.is_address_same' => 'nullable|in:Y,N',
                'address.present_province' => 'nullable|string|max:255',
                'address.present_district' => 'nullable|string|max:255',
                'address.present_city' => 'nullable|string|max:255',
                'address.present_ward_no' => 'nullable|string|max:255',
                'address.present_street' => 'nullable|string|max:255',
                'address.present_house_no' => 'nullable|string|max:255',

                'citizenship.citizenship_no' => 'required|string|max:255',
                'citizenship.citizenship_district' => 'required|string|max:255',
                'citizenship.citizenship_issued_date' => 'required|date',
                'citizenship.occupation' => 'required|string|max:255',
                // 'citizenship.income_source' => 'required|string|max:255',
                'citizenship.occupation_other' => 'nullable|string|max:255',

                'rel_relation' => 'nullable|array',
                'rel_relation.*' => 'nullable|string|in:father,mother,mother-in-law,father-in-law,spouse,child1,child2',
                'rel_name' => 'nullable|array',
                'rel_name.*' => 'nullable|string|max:255',
                'rel_dob' => 'nullable|array',
                'rel_dob.*' => 'nullable|date',
                'rel_gender' => 'nullable|array',
                'rel_gender.*' => 'nullable|string|in:male,female,other',

                'attachment_name' => 'nullable|array',
                'attachment_name.*' => 'nullable|string|max:255',

                'files' => 'nullable|array',
                'files.*' => 'nullable|file|mimes:pdf|max:2048',

                'personal.client_id' => ['required', 'exists:clients,id', new ClientMemberLimit($this->personal['client_id'])],
                // 'policy.package_id' => 'required|exists:packages,id',
                'policy.group_id' => 'nullable|exists:groups,id',
                'policy.start_date' => 'required|date',
                'policy.type' => 'required|in:hr,member,individual',
                // 'policy.policy_id' => ['required', 'exists:company_policies,id'],
                'member_type' => 'required|in:group,individual',
            ];
        }
        if (request()->isMethod("PUT")) {
            $data['personal.email'] .= '|' . Rule::unique('users', 'email')->ignore($this->member->user->id);
            $data['personal.employee_id'] .= '|unique:members,employee_id,' . $this->member->id;
        } else {
            $data['personal.email'] .= '|unique:users,email';
            $data['personal.employee_id'] .= '|unique:members,employee_id';
        }

        return $data;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hasError = true;
            if (!is_null(request()->rel_relation)) {
                # code...
                foreach (request()->rel_relation as $index => $rel_relation) {
                    if (request()->rel_relation[$index] || request()->rel_name[$index] || request()->rel_dob[$index] || request()->rel_gender[$index])
                        if (!request()->rel_relation[$index] || !request()->rel_name[$index] || !request()->rel_dob[$index] || !request()->rel_gender[$index]) {
                            $validator->errors()->add('rel_relation', 'Please fill all the dependent data');
                        }
                }
            }
        });
    }
}
