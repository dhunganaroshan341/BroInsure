<?php

namespace App\Rules;

use App\Models\Client;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ClientMemberLimit implements ValidationRule
{
    protected $client_id;

    public function __construct($client_id)
    {
        $this->client_id=$client_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $client=Client::with(['policies'=>function($q){
            // $q->where('status','Y');
        }])->withCount('members')->where('id',$this->client_id)->first();
        // dd($client->policies[0]?->member_no,$client->members_count);
        if ( isset($client->policies[0]) && ($client->policies[0]->member_no <= $client->members_count)) {
            $fail('The Employee Limit ('.$client->policies[0]?->member_no.') is Exceeded.');
        }
    }
}
