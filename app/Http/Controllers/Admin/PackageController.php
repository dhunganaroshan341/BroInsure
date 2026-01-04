<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PackageRequest;
use App\Models\InsuranceHeading;
use App\Models\InsuranceSubHeading;
use App\Models\Package;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('packages');
        if ($request->ajax()) {
            $users = Package::select('*')->with(['headings:name'])->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('heading', function ($row) {
                    return $row->headings->pluck('name');
                })
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('packages.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('packages.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'heading'])
                ->make(true);
        }
        $data['access'] = $access;
        $data['title'] = 'Insurance Group';
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::with(['sub_headings'])->where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        $data['subheadings'] = InsuranceSubHeading::where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        return view('backend.package.list', $data);
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
    // public function storeOld(PackageRequest $request)
    // {
    //     $accessCheck = $this->checkAccess($this->accessCheck('packages'), 'isinsert');
    //     if ($accessCheck && $accessCheck['status'] == false) {
    //         return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
    //     }
    //     try {
    //         DB::beginTransaction();
    //         $validatedData = $request->validated();
    //         $includingSubHeadings = $validatedData['sub_heading_id'];

    //         $pacakge = Package::create(['name' => $validatedData['name']]);
    //         $syncData = [];

    //         foreach ($validatedData['heading_id'] as $key => $heading_id) {
    //             $heading = InsuranceHeading::where('id', $heading_id)->with('sub_headings')->first();

    //             if ($heading) {
    //                 $assignedHeading = $heading->sub_headings->pluck('id')->toArray();

    //                 // Calculate common sub headings
    //                 $commonSubHeading = array_intersect($includingSubHeadings, $assignedHeading);

    //                 // Convert to list of values and encode as JSON
    //                 $exclusiveValues = array_values($commonSubHeading);
    //                 $syncData[$heading_id] = [
    //                     'exclusive' => json_encode($exclusiveValues)
    //                 ];
    //             }
    //         }

    //         // $test=[
    //         //     3=>['exclusive' => $commonSubHeading]
    //         // ]
    //         $pacakge->headings()->sync($syncData);
    //         DB::commit();
    //         return $this->sendResponse(true, getMessageText('insert'));
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Log::error($e);
    //         return $this->sendError(getMessageText('insert', false));
    //     }
    // }

    public function store(PackageRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('packages'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $includingSubHeadings = $validatedData['sub_heading_id'];
            $pacakge = Package::create(['name' => $validatedData['name']]);
            $syncData = [];
            foreach ($validatedData['heading_id'] as $key => $heading_id) {
                $heading = InsuranceHeading::where('id', $heading_id)->with('sub_headings')->first();
                if ($heading) {
                    $assignedHeading = $heading->sub_headings->pluck('id')->toArray();
                    $commonValues = array_intersect($assignedHeading, $includingSubHeadings);
                    // Ensure it is a numerically indexed array
                    $commonValues = array_values($commonValues);
                    // Encode to JSON
                    $jsondata = json_encode($commonValues);
                    $syncData[$heading_id] = ['exclusive' => $jsondata];
                }
 
            }
            $pacakge->headings()->sync($syncData);
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError(getMessageText('insert', false));
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('packages'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Package::with('packageheadings')->find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request, $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('packages'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $includingSubHeadings = $validatedData['sub_heading_id'];
            $pacakge = Package::find($id);
            $data_save = $pacakge->update(['name' => $validatedData['name']]);
            $syncData = [];
            foreach ($validatedData['heading_id'] as $key => $heading_id) {
                $heading = InsuranceHeading::where('id', $heading_id)->with('sub_headings')->first();
                if ($heading) {
                    $assignedHeading = $heading->sub_headings->pluck('id')->toArray();
                    $commonValues = array_intersect($assignedHeading, $includingSubHeadings);
                    // Ensure it is a numerically indexed array
                    $commonValues = array_values($commonValues);
                    // Encode to JSON
                    $jsondata = json_encode($commonValues);
                    $syncData[$heading_id] = ['exclusive' => $jsondata];
                }
            }
            $pacakge->headings()->sync($syncData);
            DB::commit();
            return $this->sendResponse(true, getMessageText('update'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError(getMessageText('update', false));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('packages'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Package::find($id);
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
