<?php

namespace App\Http\Requests;

use App\Rules\ConditionalRequired;
use App\Rules\UniqueTwoColumnValidation;

class UserStoreRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fname' => 'required|string',
            'mname' => 'nullable|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            // 'mobilenumber' => 'required|integer|digits:10',
            'mobilenumber' => [
                'required',
                'integer',
                'digits:10',
                new UniqueTwoColumnValidation('users', 'fname', $this->fname),
            ],
            'password' => [
                'required',
                'string',
                'min:8',             // Minimum length 8
                'regex:/[a-z]/',     // At least one lowercase letter
                'regex:/[A-Z]/',     // At least one uppercase letter
                'regex:/[0-9]/',     // At least one digit
                'regex:/[@$!%*#?&]/' // At least one special character
            ],
            'usertype' => 'required|integer|exists:usertype,id',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_id.required_if' => 'The client ID field is required when the user type is Client.',
            'client_id.exists' => 'The selected client ID is invalid.', // Custom message for exists rule
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
        ];
    }
}
