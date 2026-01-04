<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\InsuranceSubHeadingRequest;
use App\Models\InsuranceHeading;
use App\Models\InsuranceSubHeading;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceSubHeadingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->access();
        if ($request->ajax()) {
            $users = InsuranceSubHeading::select('*')->with(['heading'])->orderBy('name', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('heading_id',function($row){
                    return $row->heading?->name;
                })
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('sub-headings.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('sub-headings.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Insurance Sub Heading';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['headings']=InsuranceHeading::where('status','Y')->orderBy('name')->get(['id','name']);
        return view('backend.sub-heading.list', $data);
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
    public function store(InsuranceSubHeadingRequest $request)
    {
        $accessCheck = $this->checkAccess($this->access(), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();

        $data_save = InsuranceSubHeading::create($validatedData);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('insert'));
        } else {
            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InsuranceSubHeading $insuranceSubHeading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $accessCheck = $this->checkAccess($this->access(), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = InsuranceSubHeading::find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceSubHeadingRequest $request, $id)
    {
        $accessCheck = $this->checkAccess($this->access(), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();

        $group = InsuranceSubHeading::find($id);
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
        $accessCheck = $this->checkAccess($this->access(), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = InsuranceSubHeading::find($id);
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
    
    public function access()
    {
        return checkAccessPrivileges('group');
    }
}
