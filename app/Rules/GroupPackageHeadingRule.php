<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class GroupPackageHeadingRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $packageId;

    public function __construct($packageId)
    {
        $this->packageId=$packageId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists=DB::table('package_headings')
                    ->where('package_id',$this->packageId)
                    ->where('heading_id',$value)
                    ->exists();
        if (!$exists) {
            $fail('The selected heading is invalid for the specified package.');
        }
    }
}
