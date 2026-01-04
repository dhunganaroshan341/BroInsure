<?php

namespace App\Http\Requests\FiscalYear;

use App\Http\Requests\CustomFormRequest;
use App\Models\FiscalYear;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 */
class StoreFiscalYearRequest extends CustomFormRequest
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
            "name" => ["required"],
            "start_date" => ["required", "date"],
            "end_date" => ["required", "date"],
            // "status" => ["required", Rule::in(FiscalYear::STATUS_NO, FiscalYear::STATUS_YES)]
        ];
    }
}
