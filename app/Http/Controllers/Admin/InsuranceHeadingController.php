<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\InsuranceHeadingRequest;
use App\Models\InsuranceHeading;
use App\Models\InsuranceSubHeading;
use App\Models\Member;
use App\Models\MemberPolicy;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceHeadingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('insurance_heading');
        if ($request->ajax()) {
            $users = InsuranceHeading::select('*')->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('headings.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('headings.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Insurance Heading';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        return view('backend.heading.list', $data);
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
    public function store(InsuranceHeadingRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('insurance_heading'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        $data_save = InsuranceHeading::create($validatedData);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('insert'));
        } else {
            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InsuranceHeading $insuranceHeading)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('insurance_heading'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = InsuranceHeading::find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceHeadingRequest $request, $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('insurance_heading'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();

        $group = InsuranceHeading::find($id);
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
        $accessCheck = $this->checkAccess($this->accessCheck('insurance_heading'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = InsuranceHeading::find($id);
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

    public function sub_headings(Request $request, $id)
    {
        $empGroup = MemberPolicy::where('is_current', 'Y')->where('member_id', $request->employee_id)->with('group.headings', function ($q) use ($id) {
            $q->where('heading_id', $id);
        })->first();
        // $subheadings = InsuranceSubHeading::where('heading_id', $id)
        //     ->whereIn('id', json_decode($empGroup?->group?->headings[0]?->exclusive, true))
        //     ->get(['id', 'name']);

        $exclusive = null;
        // Check if empGroup and its group and headings exist and are not empty
        if ($empGroup?->group?->headings && count($empGroup->group->headings) > 0) {
            $exclusive = json_decode($empGroup->group->headings[0]->exclusive, true);
        }
        if ($exclusive) {
            $subheadings = InsuranceSubHeading::where('heading_id', $id)
                ->whereIn('id', $exclusive)
                ->get(['id', 'name']);
        } else {
            // Handle the case where exclusive is null or empty
            $subheadings = collect(); // or handle as needed
        }
        if ($subheadings) {
            return $this->sendResponse($subheadings, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }
}
