<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenderReferenceExport implements FromArray,WithTitle,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function array(): array
    {
        return [
            ['id'=>'male','name'=>'Male'],
            ['id'=>'female','name'=>'Female'],
            ['id'=>'other','name'=>'Other'],
        ];
    }

    public function headings(): array
    {
        return [
            'Gender ID',
            'Gender Name',
        ];
    }
    public function title(): string
    {
        return 'Gender';
    }
}
