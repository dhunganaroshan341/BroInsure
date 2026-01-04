<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MemberImportRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx,xls,csv',
            'client_id_list' => 'required|exists:clients,id'
        ];
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $file = $this->file('file');
    //         $rows = $this->parseExcel($file);
    //         foreach ($rows as $index => $row) {
    //             $data = $this->preparedForValidation($row);
    //             $rules = $this->rowRules($index);
    //             $rowValidator=validator($data,$rules);
    //             if($rowValidator->fails()){
    //                 foreach ($rowValidator->errors()->all() as $message) {
    //                     $validator->errors()->add("row_{$index}", "Row " . ($index + 1) . ": " . $message);
    //                 }
    //             }
    //             // $validator->getMessageBag()->merge(
    //             //     validator($data, $rules)->getMessageBag()
    //             // );
    //         }
    //     });
    // }

    // public function preparedForValidation(array $data): array
    // {
        
    //     $dateFields = [
    //         'date_of_birth',
    //         'father_date_of_birth',
    //         'mother_date_of_birth',
    //         'spouse_date_of_birth',
    //         'child_1_date_of_birth',
    //         'child_2_date_of_birth',
    //     ];

    //     foreach ($dateFields as $field) {
    //         if (isset($data[$field]) && is_numeric($data[$field])) {
    //             try {
    //                 $data[$field] = Date::excelToDateTimeObject($data[$field])->format('Y-m-d');
    //             } catch (\Exception $e) {
    //                 Log::error("Date conversion error for field {$field}: " . $e->getMessage());
    //                 $data[$field] = null; // Set to null or handle it according to your requirement
    //             }
    //         } else {
    //             $data[$field] = null; // Set to null if the value is not numeric
    //         }
    //     }
    //     // dd($data);
    //     return $data;
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rowRules(): array
    // {
    //     return [
    //         'employee_id' => 'required|unique:members,employee_id',
    //         'group_id' => 'required|exists:groups,id',
    //         'first_name' => 'required|string',
    //         'middle_name' => 'nullable|string',
    //         'last_name' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'gender' => 'required|string|in:male,female,other',
    //         'date_of_birth' => 'required|date|after:1900-01-01',
    //         'father_name' => 'nullable|string',
    //         'father_date_of_birth' => 'nullable|required_with:father_name|after:1900-01-01',
    //         'mother_name' => 'nullable|string',
    //         'mother_date_of_birth' => 'nullable|required_with:mother_name|after:1900-01-01',
    //         'spouse_name' => 'nullable|string',
    //         'spouse_gender' => 'nullable|required_with:spouse_name|in:male,female,other',
    //         'spouse_date_of_birth' => 'nullable|required_with:spouse_name|after:1900-01-01',
    //         'child_1_name' => 'nullable|string|required_with:child_1_name',
    //         'child_1_date_of_birth' => 'nullable|required_with:child_1_name|after:1900-01-01',
    //         'child_1_gender' => 'nullable|required_with:child_1_name|in:male,female,other',
    //         'child_2_name' => 'nullable|string|required_with:child_2_name',
    //         'child_2_date_of_birth' => 'nullable|required_with:child_2_name|after:1900-01-01',
    //         'child_2_gender' => 'nullable|in:male,female,other|required_with:child_2_name',
    //     ];
    // }
    // protected function parseExcel($file): array
    // {
    //     // Implement a method to parse the Excel file and return an array of rows
    //     // Example code using PhpSpreadsheet (assuming $file is an UploadedFile instance):
    //     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
    //     $worksheet = $spreadsheet->getActiveSheet();
    //     $rows = [];
    //     foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
    //         if ($rowIndex == 1) {
    //             continue; // Skip header row
    //         }
    //         $cells = [];
    //         foreach ($row->getCellIterator() as $cell) {
    //             $cells[] = $cell->getValue();
    //         }
    //         $rows[] = array_combine($this->getHeader(), $cells);
    //     }
    //     return $rows;
    // }

    // protected function getHeader(): array
    // {
    //     // Define the header mapping based on your Excel file
    //     return [
    //         'employee_id',
    //         'group_id',
    //         'first_name',
    //         'middle_name',
    //         'last_name',
    //         'email',
    //         'gender',
    //         'date_of_birth',
    //         'father_name',
    //         'father_date_of_birth',
    //         'mother_name',
    //         'mother_date_of_birth',
    //         'spouse_name',
    //         'spouse_gender',
    //         'spouse_date_of_birth',
    //         'child_1_name',
    //         'child_1_date_of_birth',
    //         'child_1_gender',
    //         'child_2_name',
    //         'child_2_date_of_birth',
    //         'child_2_gender',
    //     ];
    // }
}
