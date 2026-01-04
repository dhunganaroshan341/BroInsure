<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomFormRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        // This method will be overridden, but it must be present.
        // You can leave it empty.
        $errors = $validator->errors()->toArray();
        $list_err='';
        foreach($errors as $li)
        {
            $list_err.=$li[0].'<br/>';
        }

        // Modify the response as needed
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'message' => $list_err,
            'errors' => $errors,
        ], 200));
    }

    /**
     * Customize the response format for validation errors.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
       

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ], 422);
    }
}
