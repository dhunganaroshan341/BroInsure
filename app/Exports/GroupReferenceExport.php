<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GroupReferenceExport implements FromQuery,WithHeadings,WithTitle,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function query()
    {
        return Group::with(['client','policy'])->where('status','Y')->where('id','!=',1);

    }

    public function headings(): array
    {
        return [
            'Group ID',
            'Group Name',
            'Policy ID',
            'Policy Name',
            'Client ID',
            'Client Name',
            'Group Code',
            'Insurance Amount',
        ];
    }

    public function title(): string
    {
        return 'Groups';
    }

    public function map($data):array
    {

        return [
            $data->id,
            $data->name,
            $data->policy?->id,
            $data->policy?->policy_no,
            $data->client->id,
            $data->client->name,
            $data->code,
            $data->insurance_amount,
        ];
    }
}
