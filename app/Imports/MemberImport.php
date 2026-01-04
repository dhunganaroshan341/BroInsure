<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Group;
use App\Models\Member;
use App\Models\MemberPolicy;
use App\Models\MemberRelative;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MemberImport implements ToModel,WithValidation,WithStartRow,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    use Importable,SkipsFailures,SkipsErrors;

    public function startRow(): int
    {
        return 2;   
    }

    public function prepareForValidation(array $data) : array {
        $client=Client::where('id',request()->input('client_id_list'))->with('groups')->first();
        if (empty($data['employee_id'])||empty($data['group_id'])||empty($data['first_name'])) {
            throw ValidationException::withMessages([
                'employee_id' => ['Employee ID  Is  required.'],
                'group_id' => ['Group  ID  Is  required.'],
                'employee_id' => ['Employee ID  Is  required.']
            ]);
        }
        if ($client) {
            $clientGroupids=$client->groups->pluck('id');
            if (!$clientGroupids->contains($data['group_id'])) {
                throw ValidationException::withMessages([
                    'group_id'=>['The selected group id does not belong to '. $client->name]
                ]);
            }
        }
        // if (isset($data['date_of_birth'])) {
        //     $data['date_of_birth'] = Date::excelToDateTimeObject($data['date_of_birth'])->format('Y-m-d');
           
        // }
        // if (isset($data['father_date_of_birth'])) {
        //     $data['father_date_of_birth'] = Date::excelToDateTimeObject($data['father_date_of_birth'])->format('Y-m-d');
        // }
        // if (isset($data['mother_date_of_birth'])) {
        //     $data['mother_date_of_birth'] = Date::excelToDateTimeObject($data['mother_date_of_birth'])->format('Y-m-d');
        // }
        // if (isset($data['spouse_date_of_birth'])) {
        //     
        //     $data['spouse_date_of_birth'] = Date::excelToDateTimeObject($data['spouse_date_of_birth'])->format('Y-m-d');
        // }
        // if (isset($data['child_1_date_of_birth'])) {
        //     $data['child_1_date_of_birth'] = Date::excelToDateTimeObject($data['child_1_date_of_birth'])->format('Y-m-d');
        // }
        // if (isset($data['child_2_date_of_birth'])) {
        //     $data['child_2_date_of_birth'] = Date::excelToDateTimeObject($data['child_2_date_of_birth'])->format('Y-m-d');
        // }
        $dateFields = [
            'date_of_birth',
            'father_date_of_birth',
            'mother_date_of_birth',
            'spouse_date_of_birth',
            'child_1_date_of_birth',
            'child_2_date_of_birth',
        ];
    
        foreach ($dateFields as $field) {
            if (isset($data[$field]) && is_numeric($data[$field])) {
                try {
                    $data[$field] = Date::excelToDateTimeObject($data[$field])->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::error("Date conversion error for field {$field}: " . $e->getMessage());
                    $data[$field] = null; // Set to null or handle it according to your requirement
                }
            } else {
                $data[$field] = null; // Set to null if the value is not numeric
            }
        }
        // dd($data);
        return $data;
    }

    public function model(array $row)
    {
        $currentUser = getUserDetail();
        $user = User::create([
            'fname' => $row['first_name'],
            'mname' => $row['middle_name'],
            'lname' => $row['last_name'],
            'email' => $row['email'],
            'mobilenumber' => '9800000000',
            'usertype' => 2,
            'password' => bcrypt(str_replace(' ','-',$row['first_name']).'@123'),
        ]);

        $member=Member::create([
            'client_id'=>request()->input('client_id_list'),
            'user_id'=>$user->id,
            'date_of_birth_ad'=>$row['date_of_birth'],
            'marital_status'=>$row['spouse_name']?'married':'unmarried',
            'gender'=>$row['gender'],
            'nationality'=>'Nepali',
            'employee_id'=>$row['employee_id'],
            'email' => $row['email'],
        ]);

        if ($row['father_name']) {
            MemberRelative::create([
                'member_id' => $member->id,
                'rel_relation' => 'father',
                'rel_name' => $row['father_name'],
                'rel_gender' => 'male',
                'rel_dob' => $row['father_date_of_birth'],
            ]);
        }
        if ($row['mother_name']) {
            MemberRelative::create([
                'member_id' => $member->id,
                'rel_relation' => 'mother',
                'rel_name' => $row['mother_name'],
                'rel_gender' => 'female',
                'rel_dob' => $row['mother_date_of_birth'],
            ]);
        }
        if ($row['spouse_name']) {
            MemberRelative::create([
                'member_id' => $member->id,
                'rel_relation' =>'spouse',
                'rel_name' => $row['spouse_name'],
                'rel_gender' => $row['spouse_gender'],
                'rel_dob' => $row['spouse_date_of_birth'],
            ]);
        }
        if ($row['child_1_name']) {
            MemberRelative::create([
                'member_id' => $member->id,
                'rel_relation' => 'child1',
                'rel_name' => $row['child_1_name'],
                'rel_gender' =>  $row['child_1_gender'],
                'rel_dob' => $row['child_1_date_of_birth'],
            ]);
        }
        if ($row['child_2_name']) {
            MemberRelative::create([
                'member_id' => $member->id,
                'rel_relation' => 'child2',
                'rel_name' => $row['child_2_name'],
                'rel_gender' =>  $row['child_2_gender'],
                'rel_dob' => $row['child_2_date_of_birth'],
            ]);
        }
        $poid=Group::where('id', $row['group_id'])->first()->policy_id;
        MemberPolicy::create([
            'member_id'=>$member->id,
            'group_id'=>$row['group_id'],
            'is_current'=>'Y',
            'is_active'=>'Y',
            'policy_id'=>$poid
        ]);
        return $member;
    }
    public function rules(): array
    {
        $rules=[
        //    'employee_id'=>'required|unique:members,employee_id',
           'employee_id'=>['required',
                        Rule::unique('members')->where(function($q){
                            return $q->where('client_id',request()->input('client_id_list'));
                        })
                        ],
           'group_id'=>'required|exists:groups,id',
           'first_name'=>'required|string',
           'middle_name'=>'nullable|string',
           'last_name'=>'required|string',
           'email'=>'required|email|unique:members,email',
           'gender'=>'required|string|in:male,female,other',
           'date_of_birth'=>'required|date|after:1900-01-01',
           'father_name'=>'nullable|string',
           'father_date_of_birth'=>'nullable|required_with:father_name|after:1900-01-01',
           'mother_name'=>'nullable|string',
           'mother_date_of_birth'=>'nullable|required_with:mother_name|after:1900-01-01',
           'spouse_name'=>'nullable|string',
           'spouse_gender'=>'nullable|required_with:spouse_name|in:male,female,other',
           'spouse_date_of_birth'=>'nullable|required_with:spouse_name|after:1900-01-01',
           'child_1_name'=>'nullable|string|required_with:child_1_name',
           'child_1_date_of_birth' => 'nullable|required_with:child_1_name|after:1900-01-01',
           'child_1_gender'=>'nullable|required_with:child_1_name|in:male,female,other',
           'child_2_name'=>'nullable|string|required_with:child_2_name',
           'child_2_date_of_birth'=>'nullable|required_with:child_2_name|after:1900-01-01',
           'child_2_gender'=>'nullable|in:male,female,other|required_with:child_2_name',
        ];
        return $rules; 
    }

    public function customValidationAttributes():array{
        
        return [
            'employee_id'=>'Employee Id',
            'group_id'=>'Group Id',
            'first_name'=>'Employee First Name',
            'middle_name'=>'Employee Middle Name',
            'last_name'=>'Employee Last Name',
            'email'=>'Email',
            'gender'=>'Employee Gender',
            'date_of_birth'=>'Employee Date Of Birth',
            'father_name'=>'Father  Name',
            'father_date_of_birth'=>'Father Date Of Birth',
            'mother_name'=>'Mother Name',
            'mother_date_of_birth'=>'Mother Date Of Birth',
            'spouse_name'=>'Spouse Name',
            'spouse_gender'=>'Spouse Gender',
            'spouse_date_of_birth'=>'Spouse Date Of Birth',
            'child_1_name'=>'Child 1 Name',
            'child_1_date_of_birth'=>'Child 1 Date Of Birth',
            'child_1_gender'=>'Child 1 Gender',
            'child_2_name'=>'Child 2 Name',
            'child_2_date_of_birth'=>'Child 2 Date Of Birth',
            'child_2_gender'=>'Child 2 Gender',
        ];
    }
}
