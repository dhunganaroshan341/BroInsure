<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'country'       => ['nullable', 'string', 'max:100'],
            'country_code'  => ['nullable', 'string', 'max:10'],
            'phone'         => ['required', 'string', 'max:50'],

            // Multi-room validation
            'rooms'         => ['required', 'array'],
            'rooms.*'       => ['integer', 'exists:rooms,id'],

            'message'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'rooms.required' => 'Please select at least one room.',
            'rooms.*.exists' => 'One of the selected rooms does not exist.',
        ];
    }
}
