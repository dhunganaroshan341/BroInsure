<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FiscalYear\StoreFiscalYearRequest;
use App\Http\Requests\FiscalYear\UpdateFiscalYearStatusRequest;
use App\Services\FiscalYearService;
use App\Models\FiscalYear;
use Illuminate\Support\Facades\DB;

class FiscalYearController extends BaseController
{
    public function __construct(private FiscalYearService $fiscal_year_service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $access = checkAccessPrivileges('clients');
        if (request()->ajax()) {
            return $this->fiscal_year_service->getDataTable($access);
        }
        return view("backend.fiscal-year.list", [
            "title" => "Fiscal Year",
            "access" => $access,
            "extraCss" => commonDatatableFiles('css'),
            "extraJs" => commonDatatableFiles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFiscalYearRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('fiscal_year'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        /** @var FiscalYear */
        $fiscal_year = FiscalYear::create($request->validated());
        return $fiscal_year
            ? $this->sendResponse(true, getMessageText("insert"))
            : $this->sendError(getMessageText("insert", false));
    }

    public function edit(int $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('fiscal_year'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        /** @var FiscalYear */
        $fiscal_year = FiscalYear::find($id);
        if ($fiscal_year) {
            return $this->sendResponse($fiscal_year, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFiscalYearRequest $request, int $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('fiscal_year'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        /** @var FiscalYear */
        $fiscal_year = FiscalYear::find($id);
        $data_save = $fiscal_year->update($request->validated());

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('update'));
        } else {
            return $this->sendError(getMessageText('update', false));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('fiscal_year'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        /** @var FiscalYear */
        $fiscal_year = FiscalYear::find($id);
        if (!$fiscal_year) {
            return $this->sendError(getMessageText('delete', false));
        }
        $isdel = $fiscal_year->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));
        } else {
            return $this->sendError(getMessageText('delete', false));
        }
    }

    public function updateStatus(FiscalYear $fiscal_year, UpdateFiscalYearStatusRequest $request)
    {
        return DB::transaction(function () use ($fiscal_year, $request) {
            if ($request->status == FiscalYear::STATUS_YES)
                FiscalYear::query()->update(["status" => FiscalYear::STATUS_NO]);
            $fiscal_year->status = $request->status;
            return $fiscal_year->save()
                ? $this->sendResponse(true, getMessageText('update'))
                : $this->sendError(getMessageText('update', false));
        });

    }
}
