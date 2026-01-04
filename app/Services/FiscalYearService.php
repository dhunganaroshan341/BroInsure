<?php

namespace App\Services;

use App\Models\FiscalYear;
use Yajra\DataTables\DataTables;

class FiscalYearService
{
    /**
     * @param mixed $access
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataTable($access)
    {
        $fiscal_years = FiscalYear::oldest("id");
        return DataTables::of($fiscal_years)
                ->addIndexColumn()
                ->addColumn('isActive', function ($row) {
                    return "
                        <div class='form-check form-switch'>
                            <input class='form-check-input permission_all is_active_checkbox' value='$row->id' type='checkbox' id='flexSwitchCheckDefault' " . ($row->status == FiscalYear::STATUS_YES ? "checked" : "") . ">
                        </div>
                        ";
                })
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('fiscal-years.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('fiscal-years.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'isActive'])
                ->make(true);
    }
}
