<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AddressReferenceExport implements FromQuery,WithHeadings,WithTitle,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    public function __construct($id)
    {
        $this->id=$id;
    }
    public function query()
    {
        return City::with(['province','district'])->orderBy('state_id','asc')->where('state_id',$this->id)->orderBy('district_id','asc');

    }

    public function headings(): array
    {
        return [
            'City Name',
            'City ID',
            'District Name',
            'District ID',
            'Province Name',
            'Province ID',
        ];
    }

    public function title(): string
    {
        switch ($this->id) {
            case '1':
                # code...
                return 'Koshi Province Reference';
                break;
            case '2':
                # code...
                return 'Madhesh Province Reference';
                break;
            case '3':
                # code...
                return 'Bagmati Province Reference';
                break;
            case '4':
                # code...
                return 'Gandaki Province Reference';
                break;
            case '5':
                # code...
                return 'Lumbini Province Reference';
                break;
            case '6':
                # code...
                return 'Karnali Province Reference';
                break;
            case '7':
                # code...
                return 'Sudurpashchim Province Reference';
                break;
            
            default:
                # code...
                break;
        }
    }

    public function map($city):array
    {

        return [
            $city->name,
            $city->id,
            $city->district->name,
            $city->district->id,
            $city->province->name,
            $city->province->id,
        ];
    }
}
