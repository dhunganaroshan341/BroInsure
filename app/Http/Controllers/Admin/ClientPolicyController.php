<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ClientPolicyRequest;
use App\Models\CompanyPolicy;
use App\Models\Group;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientPolicyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('client_policy');
        if ($request->ajax()) {
            $users = CompanyPolicy::select('*')->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('groups.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('groups.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Eompany Policies';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        return view('backend.group.list', $data);
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
    public function store(ClientPolicyRequest $request)
    {
        // dd($request->all());
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        if ($request->has('excess_value') && $request->has('excess_type')) {
            $excessdata = [
                'excess_type' => $validatedData['excess_type'],
                'excess_value' => $validatedData['excess_value'],
            ];

            $validatedData['excess'] = json_encode($excessdata);
        }
        unset($validatedData['excess_value'],$validatedData['excess_type']);

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
    public function show(CompanyPolicy $companyPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = CompanyPolicy::find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientPolicyRequest $request, $id)
    {
        // dd($request->all());
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        if ($request->has('excess_value')) {
            $excessdata = [
                'excess_type' => isset($validatedData['excess_type']) && $validatedData['excess_type']=='percentage'?$validatedData['excess_type']:'fixed',
                'excess_value' => $validatedData['excess_value'],
            ];

            $validatedData['excess'] = json_encode($excessdata);
            unset($validatedData['excess_value'],$validatedData['excess_type']);
        }
        unset($validatedData['policy_id']);
        $group = CompanyPolicy::find($id);
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
    public function destroy($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = CompanyPolicy::find($id);
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

    public function clientPolicy($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('client_policy'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $policies = CompanyPolicy::where('client_id', $id)->get();
        if ($policies) {
            return $this->sendResponse($policies, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    public function renewPolicy(Request $request){
        dd($request->all());
    }  

    public function getGroup($id){
        $policy=CompanyPolicy::with('groups')->where('policy_type','retail')->where('id',$id)->first();

        $data=$policy->groups;
        if ($policy) {
            return $this->sendResponse($data, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
}
