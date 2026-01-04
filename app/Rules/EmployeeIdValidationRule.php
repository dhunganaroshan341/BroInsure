<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\InsuranceClaim; // Adjust this based on your model namespace

class EmployeeIdValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Split employee_id into member_id and relative_id
        $parts = explode('__', $value);
        if (count($parts) !== 2) {
            return false;
        }

        $member_id = $parts[0];
        $relative_id = $parts[1] == "" ? null : $parts[1];
        // Check if both member_id and relative_id exist in insurance_claims
        $exists = InsuranceClaim::where('member_id', $member_id)
            ->where('relative_id', $relative_id)
            ->where('clam_type', 'claim')
            ->whereNull('lot_no')
            ->exists();

        return $exists;
    }

    public function message()
    {
        return 'The :attribute is invalid.';
    }
}
