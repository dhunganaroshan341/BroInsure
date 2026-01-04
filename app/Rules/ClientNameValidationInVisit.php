<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientNameValidationInVisit implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
        // dd($this->data);
    }
    public function passes($attribute, $value)
    {
        // dd($this->data['support_type']);
        if (in_array($this->data['support_type'], ['Break'])) {
            // dd( dd($this->data['support_type']));
            return true;
        }
        if (isset($this->data['client_name_custom']) && $this->data['client_name_custom'] === '1') {
        //    dd($this->data['support_type']);
            return true;
        }
        if (!isset($this->data['client_name_custom']) || $this->data['client_name_custom'] === '0') {

            $validator = Validator::make([$attribute => $value], [
                $attribute => 'required|exists:clients,id'
            ]);
            Log::info('here');
            return !$validator->fails();
            // return false;
        }
        return true;
    }

    public function message()
    {
        return 'The :attribute field is required.';
    }
}
