<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Usertype;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{

    public function index(Request $request)
    {
        //check button access
        $access = checkAccessPrivileges('users');
        if ($request->ajax()) {

            $users = User::join('usertype', 'usertype.id', '=', 'users.usertype')->with('member.client')
                ->when($request->has('client_id') && !is_null($request->client_id), function ($q) use ($request) {
                    $q->whereHas('member', function ($qq) use ($request) {
                        $qq->where('client_id', $request->client_id);
                    });
                })
                ->get(['users.*', 'usertype.typename']);
            return Datatables::of($users)

                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('user.show', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('user.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }
                    return $btn;
                })
                ->addColumn('client_name', function ($row) {
                    return $row->member?->client?->name;
                })->addColumn('full_name', function ($row) {
                    return $row->fname . ' ' . $row->lname;
                })->editColumn('is_active', function ($row) {
                    $active = '';
                    $active .= $row->is_active == 'Y' ? 'Active' : 'Inactive';

                    return $active;
                })

                ->rawColumns(['action', 'is_active', 'client_name'])
                ->make(true);
        } else {
            $data['title'] = 'Users List';
            $data['form_title'] = 'Add User';
            $data['usertypes'] = Usertype::get(['id', 'typename']);
            $data['clients'] = Client::get(['id', 'name']);
            $data['access'] = $access;
            $data['extraCss'] = commonDatatableFiles('css');
            $data['extraJs'] = commonDatatableFiles();
            $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
            $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
            $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
            return view('backend.user.list', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $savedata = $request->except('id');
        $savedata['fname'] = ucfirst($request->fname);
        $savedata['lname'] = ucfirst($request->lname);
        $savedata['password'] = bcrypt($savedata['password']);

        if (isset($request->profile_pic) && !is_null($request->profile_pic)) {
            $folder = 'admin/uploads/user/profile';
            $file = $request->profile_pic;
            $filename = $this->uploadfile($file, $folder);
            $savedata['profile_pic'] = $filename;
        }
        if (isset($request->signature) && !is_null($request->signature)) {
            $folder = 'admin/uploads/user/signature';
            $file = $request->signature;
            $filename = $this->uploadfile($file, $folder);
            $savedata['signature'] = $filename;
        }

        // Begin database transaction
        DB::beginTransaction();
        $data_save = User::create($savedata);



        // Check database transaction
        $transactionStatus = DB::transactionLevel();

        if ($transactionStatus > 0) {
            // Database transaction success
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } else {
            // Throw error
            DB::rollback();

            return $this->sendError(getMessageText('insert', false));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        if (isset($user->id)) {


            return $this->sendResponse($user, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        $savedata = $request->validated();
        if (isset($request['password']) && $request['password'] != '') {
            $savedata['password'] = bcrypt($request['password']);
        }
        $savedata['fname'] = ucfirst($request->fname);
        $savedata['lname'] = ucfirst($request->lname);
        $savedata['employee_id'] = ucfirst($request->employee_id);
        if (isset($request->profile_pic) && !is_null($request->profile_pic)) {
            $folder = 'admin/uploads/user/profile';
            $file = $request->profile_pic;
            $filename = $this->uploadfile($file, $folder);
            $savedata['profile_pic'] = $filename;
        }
        if (isset($request->signature) && !is_null($request->signature)) {
            $folder = 'admin/uploads/user/signature';
            $file = $request->signature;
            $filename = $this->uploadfile($file, $folder);
            $savedata['signature'] = $filename;
        }
        // Begin database transaction
        DB::beginTransaction();
        $data_save = $user->update($savedata);



        // Check database transaction
        $transactionStatus = DB::transactionLevel();

        if ($transactionStatus > 0) {
            // Database transaction success
            DB::commit();
            return $this->sendResponse(true, getMessageText('update'));
        } else {
            // Throw error
            DB::rollback();

            return $this->sendError(getMessageText('update', false));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $isdel = $user->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));
        } else {
            return $this->sendError(getMessageText('delete', false));
        }
    }


    public function changepassword()
    {
        $title = 'Change Password';
        $form_title = $title;
        $folder = $this->folder;
        return view($this->folder . '.changepassword', compact('title', 'form_title', 'folder'));
    }

    // public function submitnewpassword(UpdatePasswordRequest $request)
    // {

    //     $userinfo = getUserDetail();

    //     $savedata['id'] = $userinfo->id;
    //     $savedata['default_password'] = null;
    //     $savedata['password'] = bcrypt($request->password);

    //     $user = User::find($userinfo->id);

    //     $data_save = $user->update($savedata);

    //     if ($data_save) {
    //         return $this->sendResponse(true, getMessageText('passwordupdate'));
    //     } else {
    //         return $this->sendError(getMessageText('update', false));
    //     }
    // }

    public function uploadfile($file, $folder)
    {
        $filename = $folder . '/' . str_replace(' ', '', date('y-m-d-h-i-s') . '' . $file->getClientOriginalName());
        $file->move($folder, $filename);
        return str_replace('admin/', '', $filename);
    }
}
