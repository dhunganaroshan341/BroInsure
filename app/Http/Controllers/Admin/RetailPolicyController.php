<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CompanyPolicy;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ClientPolicyRequest;
use App\Http\Requests\RetailPolicyRequest;

class RetailPolicyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('retail-policy');
        if ($request->ajax()) {
            $policy = CompanyPolicy::select('*')->where('policy_type','retail')->orderBy('id', 'asc');
            return Datatables::of($policy)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {
                    $btn = "";
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('retail-policy.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('retail-policy.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Retail Policy';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        // $data['extraJs'][] = 'admin/assets/common/js/address.js';
        return view('backend.retail-policy.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RetailPolicyRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('retail-policy'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        $validatedData['client_id'] = 1;
        $validatedData['policy_type'] = 'retail';
        // $validatedData['policy_no'] = policy_no;
        $validatedData['issue_date']=date('Y-m-d');
        $validatedData['valid_date']=date('Y-m-d');
        // $validatedData['imitation_days']=1;
        if ($request->has('excess_value') && $request->has('excess_type')) {
            $excessdata = [
                'excess_type' => $validatedData['excess_type'],
                'excess_value' => $validatedData['excess_value'],
            ];


            $validatedData['excess'] = json_encode($excessdata);
        }
        unset($validatedData['excess_value'], $validatedData['excess_type']);

        $data_save = CompanyPolicy::create($validatedData);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('insert'));
        } else {
            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = CompanyPolicy::where('policy_type','retail')->find($id);
        // dd($group);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RetailPolicyRequest $request, string $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        if ($request->has('excess_value')) {
            $excessdata = [
                'excess_type' => isset($validatedData['excess_type']) && $validatedData['excess_type'] == 'percentage' ? $validatedData['excess_type'] : 'fixed',
                'excess_value' => $validatedData['excess_value'],
            ];

            $validatedData['excess'] = json_encode($excessdata);
            unset($validatedData['excess_value'], $validatedData['excess_type']);
        }
        unset($validatedData['policy_id']);
        $group = CompanyPolicy::where('policy_type','retail')->find($id);
        // dd($validatedData);
        $data_save = $group->update($validatedData);

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
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = CompanyPolicy::where('policy_type','retail')->find($id);
        if (!$group) {
            return $this->sendError(getMessageText('delete', false));
        }
        $isdel = $group->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));
        } else {
            return $this->sendError(getMessageText('delete', false));
        }
    }
}
