<?php

namespace App\Http\Requests\ClaimVerification;

use Illuminate\Foundation\Http\FormRequest;

class GetScrutinyDetailsRequest extends FormRequest
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
            "member_id" => ["required"],
            // "lot_id" => ["required"],
            "relative_id" => ["nullable"],
        ];
    }
}
