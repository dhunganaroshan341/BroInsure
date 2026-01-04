<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MemberReferenceExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function sheets(): array
    {
        $sheets=[];
        // $sheets[]=new AddressReferenceExport(1);
        // $sheets[]=new AddressReferenceExport(2);
        // $sheets[]=new AddressReferenceExport(3);
        // $sheets[]=new AddressReferenceExport(4);
        // $sheets[]=new AddressReferenceExport(5);
        // $sheets[]=new AddressReferenceExport(6);
        // $sheets[]=new AddressReferenceExport(7);
        $sheets[]=new GenderReferenceExport();
        $sheets[]=new GroupReferenceExport();

        return $sheets;
    }
}
