<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;

use App\Models\Module;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class MenuController extends BaseController
{
    public $folder;
    public function __construct()
    {

        $this->folder = 'backend.menu';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $users = Module::select('*')->orderBy('id', 'asc')->get();
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('menu.show', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('menu.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $data['menu'] = Module::where('parentmoduleid', 0)->get();
            $data['title'] = 'Menu List';
            $data['form_title'] = 'Add Menu';
            $data['extraCss'] = commonDatatableFiles('css');
            $data['extraJs'] = commonDatatableFiles();
            return view($this->folder . '.list', $data);

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
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'modulename' => 'required|string',
            'url' => 'required|string',
            'icon' => 'required|string',
            'orderby' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return $this->sendError($validator->errors()->all()[0], $validator->errors());

        } else {
            $savedata = $request->except('id');


            $data_save = Module::create($savedata);

            if ($data_save) {
                return $this->sendResponse(true, getMessageText('insert'));

            } else {
                return $this->sendError(getMessageText('insert', false));

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $menu)
    {
        if (isset($menu->id)) {
            return $this->sendResponse($menu, getMessageText('fetch'));

        } else {
            return $this->sendError(getMessageText('fetch', false));


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $menu)
    {
        //
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'modulename' => 'required|string',
            'url' => 'required|string',
            'icon' => 'required|string',
            'orderby' => 'required|integer',
        ]);

        if ($validator->fails()) {

            return $this->sendError($validator->errors()->all()[0], $validator->errors());

        } else {

            $data_save = $menu->update($request->all());

            if ($data_save) {
                return $this->sendResponse(true, getMessageText('update'));

            } else {
                return $this->sendError(getMessageText('update', false));

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $menu)
    {
        //
        $isdel = $menu->delete();
        if ($isdel) {
            return $this->sendResponse(true, getMessageText('delete'));

        } else {
            return $this->sendError(getMessageText('delete', false));

        }
    }
}
