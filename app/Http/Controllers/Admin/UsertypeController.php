<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Usertype;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\UsertypeStoreRequest;
use App\Http\Requests\UsertypeUpdateRequest;



class UsertypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return view('backend.usertype.list2');
        //check button acce ss
        $access = checkAccessPrivileges('user-group');
        if ($request->ajax()) {
            $users = Usertype::select('*')->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('usertype.show', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";

                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('usertype.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";

                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['access']= $access;
        $data['title'] = 'User Type List';
        $data['form_title'] = 'Add Usertype';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        return view('backend.usertype.list', $data);
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
    public function store(UsertypeStoreRequest $request)
    {

        // dd($request->all());
        $validatedData = (object) $request->validated();

        $savedata = [
            "typename" => $validatedData->typename,
            "redirect_url" => $validatedData->redirect_url
        ];

        $data_save = Usertype::create($savedata);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('insert'));

        } else {
            return $this->sendError(getMessageText('insert', false));

        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function show(Usertype $usertype)
    {
        //
        if (isset($usertype->id)) {
            return $this->sendResponse($usertype, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function edit(Usertype $usertype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function update(UsertypeUpdateRequest $request, Usertype $usertype)
    {
        $validatedData = $request->validated();


        $data_save = $usertype->update($validatedData);

        if ($data_save) {
            return $this->sendResponse(true, getMessageText('update'));

        } else {
            return $this->sendError(getMessageText('update', false));

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usertype  $usertype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usertype $usertype)
    {
        //
        $isdel = $usertype->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));

        } else {
            return $this->sendError(getMessageText('delete', false));

        }
    }
}
