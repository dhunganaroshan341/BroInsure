<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ClientStatusChangeRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\Group;
use App\Models\Package;
use App\Models\Province;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class ClientController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $access = $this->accessCheck('clients');
        $policyAccess = $this->accessCheck('client_policy');
        if ($request->ajax()) {
            $users = Client::select('*')->with(['province'])->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('province_id', function ($row) {
                    return ucwords(strtolower($row->province?->name));
                })
                ->editColumn('name', function ($row) {
                    return ucwords(strtolower($row->name));
                })
                ->addColumn('action', function ($row) use ($access, $policyAccess) {

                    $btn = '';
                    if ($policyAccess['isinsert'] == 'Y') {
                        $btn = "<a href='javascript:void(0)' class='btn btn-success btn-sm addPolicy' data-pid='" . $row->id . "' data-name='" . $row->name . "'><i class='fas fa-plus'></i></a>";

                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-warning btn-sm viewPolicy' data-pid='" . $row->id . "' data-name='" . $row->name . "'><i class='fas fa-eye'></i></a>";
                    }
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('clients.edit', "$row->id") . "><i class='fas fa-edit'></i></a>";

                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('clients.destroy', "$row->id") . "><i class='fas fa-trash'></i></a>";

                    }

                    return $btn;
                })
                ->editColumn('status', function ($row) use ($access) {
                    $active = '';
                    if ($access['isedit'] == 'Y') {
                        $active = '<div class="form-check form-switch">
                                    <input class="form-check-input isactive" type="checkbox" data-pid="' . $row->id . '"';
                        // Check if $row->is_finised is 'Y' and add 'checked' attribute accordingly
                        $active .= $row->status == 'Y' ? ' checked' : '';
                        $active .= '></label></div>';
                    }
                    return $active;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Clients';
        $data['provinces'] = Province::get(['id', 'name']);
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraJs'][] = 'admin/assets/common/js/address.js';
        return view('backend.client.list', $data);
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
    public function store(ClientStoreRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('clients'), 'isinsert');

        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        $folder = 'uploads/clients';
        $fields = ['pan', 'registration', 'tax_clearence'];
        foreach ($fields as $field) {
            # code...
            if ($request->has($field) && $request->file($field)) {
                $filename = $this->uploadfiles($request->file($field), $folder);
                $validatedData[$field] = $filename;
            }
        }
        $data_save = Client::create($validatedData);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('insert'));

        } else {
            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('clients'), 'isedit');

        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Client::find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('clients'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $validatedData = $request->validated();
        $folder = 'uploads/clients';
        $fields = ['pan', 'registration', 'tax_clearence'];
        foreach ($fields as $field) {
            # code...
            if ($request->has($field) && $request->file($field)) {
                $filename = $this->uploadfiles($request->file($field), $folder);
                $validatedData[$field] = $filename;
            }
        }
        $group = Client::find($id);
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
        $accessCheck = $this->checkAccess($this->accessCheck('clients'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Client::find($id);
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

    public function getGroups($id)
    {
        $groups = Group::whereHas('client', function ($q) use ($id) {
            $q->where('id', $id)->withoutglobalscopes();
        })->get(['id', 'name']);
        if ($groups) {
            return $this->sendResponse($groups, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }
    }
    public function getGroupsPackage($id)
    {
        $groups = Package::whereHas('group', function ($q) use ($id) {
            $q->where('groups.id', $id);
        })->get(['id', 'name']);
        if ($groups) {
            return $this->sendResponse($groups, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }
    }

    public function policies($id)
    {
        $policies = CompanyPolicy::where('client_id', $id)->where('is_active', 'Y')->get(['id', 'policy_no']);
        if ($policies) {
            return $this->sendResponse($policies, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }
    }
    public function changeStatus(ClientStatusChangeRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('members'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        // try {
        DB::beginTransaction();
        $validatedData = $request->validated();
        $clientId = $validatedData['client_id'];
        $status = $validatedData['status'];
        $member = Client::where('id', $clientId)->firstOrFail();
        $member->update([
            'status' => $status
        ]);
        $message = 'The client has been ' . ($status === 'Y' ? 'activated' : 'deactivated') . ' with Client ID: ' . $clientId . '.';
        DB::commit();
        return $this->sendResponse(true, $message);
    }
}
