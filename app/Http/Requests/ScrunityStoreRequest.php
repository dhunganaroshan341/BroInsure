<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScrunityStoreRequest extends CustomFormRequest
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

        $rules = [
            'scrunity_details_ids' => 'nullable|array',
            'scrunity_details_ids.*' => 'nullable|exists:scrunity_details,id',
            'member_id' => 'required|exists:members,id',
            'relative_id' => 'nullable',
            'claim_id' => 'required|exists:insurance_claims,claim_id',
            'heading_id' => 'required|array',
            'heading_id.*' => 'required|exists:insurance_headings,id',
            'bill_amount' => 'required|array',
            'bill_amount.*' => 'required|numeric',
            'approved_amount' => 'required|array',
            'approved_amount.*' => 'required|numeric',
            'deduct_amount' => 'required|array',
            'deduct_amount.*' => 'required|numeric',
            'bill_no' => 'required|array',
            'bill_no.*' => 'required|string',
            'remarks' => 'required|array',
            'remarks.*' => [
                'nullable'
            ],

            'type' => 'nullable|in:draft,store',
            'status' => 'required|in:draft,request',
            'scrunity_files' => 'nullable',
            // 'scrunity_files.*' => [
            //     'required',
            //     'file',
            //     'mimes:png,jpg,pdf,jpeg',
            //     function ($attribute, $value, $fail) {
            //         $index = explode('.', $attribute)[1]; // Get the index from 'file.*'

            //         // Check if the corresponding scrunity_details_id is null
            //         if (isset($this->scrunity_details_ids[$index]) && $this->scrunity_details_ids[$index] === null) {
            //             $fail("The file at index $index is required when the corresponding scrunity_details_id is null.");
            //         }
            //     },
            // ],

        ];
        // Create a collection and filter out null values
        $filteredCollection = collect($this->scrunity_details_ids)->filter(function ($value) {
            return !is_null($value);
        });
        // Check if there are any non-null values in the collection
        if ($filteredCollection->isNotEmpty()) {
            $rules['scrunity_id'] = ['required', 'exists:scrunities,id'];
        } else {
            $rules['scrunity_id'] = ['nullable', 'exists:scrunities,id'];
        }

        return $rules;
    }
}
