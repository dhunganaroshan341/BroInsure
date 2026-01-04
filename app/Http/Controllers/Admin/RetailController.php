<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Group;
use App\Models\GroupHeading;
use Illuminate\Http\Request;
use App\Models\CompanyPolicy;
use App\Models\InsuranceHeading;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RetailGroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Requests\RetailGroupUpdateRequest;

class RetailController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $access = $this->accessCheck('retail-policy');
        if ($request->ajax()) {
            $users = Group::select('*')->whereHas('policy', function ($q) {
                $q->where('policy_type', 'retail');
            })->with([
                'client' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ])->orderBy('id', 'asc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('client_id', function ($row) {
                    return $row->client->name;
                })
                ->addColumn('action', function ($row) use ($access) {

                    $btn = '';
                    $btn .= "<a href='javascript:void(0)' class='btn btn-warning btn-sm viewData mx-1' data-pid='" . $row->id . "' data-url=" . route('retail-groups.edit', "$row->id") . "><i class='fas fa-eye'></i> View</a>";
                    if ($access['isedit'] == 'Y') {
                        $btn .= "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm editData' data-pid='" . $row->id . "' data-url=" . route('retail-groups.edit', "$row->id") . "><i class='fas fa-edit'></i> Edit</a>";
                    }
                    if ($access['isdelete'] == 'Y') {
                        $btn .= "&nbsp;<a href='javascript:void(0)' class='edit btn btn-danger btn-sm deleteData' data-pid='" . $row->id . "' data-url=" . route('retail-groups.destroy', "$row->id") . "><i class='fas fa-trash'></i> Delete</a>";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['access'] = $access;
        $data['title'] = 'Retail Policy';
        // $data['clients'] = Client::get(['id', 'name']);
        $data['policies'] = CompanyPolicy::where('policy_type', 'retail')->pluck('policy_no', 'id');
        $data['extraCss'] = commonDatatableFiles('css');
        $data['extraJs'] = commonDatatableFiles();
        $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';
        $data['headings'] = InsuranceHeading::with(['sub_headings'])->where('status', 'Y')->orderBy('name', 'asc')->get(['id', 'name']);
        return view('backend.retail.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(RetailGroupStoreRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('retail-policy'), 'isinsert');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        // dd($request->all());
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $groupData = [
                'insurance_amount' => $validatedData['insurance_amount'],
                'client_id' => 1,
                'policy_id' => $validatedData['policy_id'],
                'name' => $validatedData['name'],
                'code' => $validatedData['code'],
                'is_amount_different' => array_key_exists('is_amount_different', $validatedData) ? 'Y' : 'N',
                'is_imitation_days_different' => $validatedData['is_imitation_days_different'],
            ];
            $group = Group::create($groupData);
            $includingSubHeadings = $validatedData['sub_heading_id'];
            $filteredLimitTypeArray = [];
            foreach ($request->access_type as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subKey => $value) {
                        if (!is_null($value)) {
                            $filteredLimitTypeArray[$subKey] = $value;
                        }
                    }
                } elseif (!is_null($item)) {
                    $filteredLimitTypeArray[$key] = $item;
                }
            }
            $filteredLimitArray = [];
            foreach ($request->limit_number as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subKey => $value) {
                        if (!is_null($value)) {
                            $filteredLimitArray[$subKey] = $value;
                        }
                    }
                } elseif (!is_null($item)) {
                    $filteredLimitArray[$key] = $item;
                }
            }
            // dd( $request->access_type,$filteredLimitTypeArray);
            if ($validatedData['is_imitation_days_different'] !== 'Y') {
                $imitation_days = CompanyPolicy::where('id', $validatedData['policy_id'])->value('imitation_days');
            }
            // dump($validatedData['heading_id'] );
            foreach ($validatedData['heading_id'] as $key => $heading_id) {
                $heading = InsuranceHeading::where('id', $heading_id)->with('sub_headings')->first();
                $current_imitation_days = $validatedData['is_imitation_days_different'] === 'Y'
                    ? $validatedData['imitation_days'][$key]
                    : $imitation_days;
                $groupHeadingData = [
                    'group_id' => $group->id,
                    'heading_id' => $heading_id,
                    'is_employee' => $validatedData['is_employee'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_spouse' => $validatedData['is_spouse'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_child' => $validatedData['is_child'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_parent' => $validatedData['is_parent'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'limit' => isset($validatedData['limit_check'][$key]) ? 'Y' : 'N',
                    'amount' => $validatedData['amountNew'][$key],
                    'imitation_days' => $current_imitation_days,
                    'is_spouse_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_spouse_amount'][$key] : null,
                    'is_child_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_child_amount'][$key] : null,
                    'is_parent_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_parent_amount'][$key] : null,
                ];

                if ($heading) {
                    $assignedHeading = $heading->sub_headings->pluck('id')->toArray();
                    $commonValues = array_intersect($assignedHeading, $includingSubHeadings);
                    $commonValues = array_values($commonValues);
                    $jsondata = json_encode($commonValues);
                    $groupHeadingData['exclusive'] = $jsondata;
                    $groupHeadingData['limit_type'] = json_encode($filteredLimitTypeArray);
                    $groupHeadingData['limit'] = json_encode($filteredLimitArray);
                }
                // dump($groupHeadingData);
                GroupHeading::create($groupHeadingData);
            }
            DB::commit();
            return $this->sendResponse(true, getMessageText('insert'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
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
        $accessCheck = $this->checkAccess($this->accessCheck('retail-policy'), 'isedit');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Group::with(['headings', 'client'])->find($id);
        if ($group) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendError(getMessageText('fetch', false));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RetailGroupUpdateRequest $request, string $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('retail-policy'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();

            $group = Group::with(['headings'])->find($id);
            $groupData = [
                'client_id' => 1,
                'insurance_amount' => $validatedData['insurance_amount'],
                'name' => $validatedData['name'],
                'code' => $validatedData['code'],
                'is_amount_different' => array_key_exists('is_amount_different', $validatedData) ? 'Y' : 'N',
                'is_imitation_days_different' => $validatedData['is_imitation_days_different'],
            ];
            $group->update($groupData);
            $includingSubHeadings = $validatedData['sub_heading_id'];
            if ($validatedData['is_imitation_days_different'] !== 'Y') {
                $imitation_days = CompanyPolicy::where('id', $validatedData['policy_id'])->value('imitation_days');
            }
            GroupHeading::where('group_id', $id)->whereNotIn('heading_id', $validatedData['heading_id'])->delete();
            $filteredLimitTypeArray = [];
            foreach ($request->access_type as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subKey => $value) {
                        if (!is_null($value)) {
                            $filteredLimitTypeArray[$subKey] = $value;
                        }
                    }
                } elseif (!is_null($item)) {
                    $filteredLimitTypeArray[$key] = $item;
                }
            }
            $filteredLimitArray = [];
            foreach ($request->limit_number as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subKey => $value) {
                        if (!is_null($value)) {
                            $filteredLimitArray[$subKey] = $value;
                        }
                    }
                } elseif (!is_null($item)) {
                    $filteredLimitArray[$key] = $item;
                }
            }
            foreach ($validatedData['heading_id'] as $key => $heading_id) {
                $heading = InsuranceHeading::where('id', $heading_id)->with('sub_headings')->first();
                $current_imitation_days = $validatedData['is_imitation_days_different'] === 'Y'
                    ? $validatedData['imitation_days'][$key]
                    : $imitation_days;
                $groupHeadingData = [
                    'is_employee' => $validatedData['is_employee'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_spouse' => $validatedData['is_spouse'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_child' => $validatedData['is_child'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'is_parent' => $validatedData['is_parent'][$heading_id] === 'Y' ? 'Y' : 'N',
                    'amount' => $validatedData['amountNew'][$key],
                    'imitation_days' => $current_imitation_days,
                    'is_spouse_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_spouse_amount'][$key] : null,
                    'is_child_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_child_amount'][$key] : null,
                    'is_parent_amount' => array_key_exists('is_amount_different', $validatedData) ? $validatedData['is_parent_amount'][$key] : null,
                    'limit_type' => json_encode($filteredLimitTypeArray),
                    'limit' => json_encode($filteredLimitArray),
                ];
                if ($heading) {
                    $assignedHeading = $heading->sub_headings->pluck('id')->toArray();
                    $commonValues = array_intersect($assignedHeading, $includingSubHeadings);
                    // Ensure it is a numerically indexed array
                    $commonValues = array_values($commonValues);
                    // Encode to JSON
                    $jsondata = json_encode($commonValues);
                    $groupHeadingData['exclusive'] = $jsondata;
                }
                GroupHeading::updateOrCreate([
                    'group_id' => $id,
                    'heading_id' => $heading_id
                ], $groupHeadingData);
            }
            DB::commit();
            return $this->sendResponse(true, getMessageText('update'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->sendError(getMessageText('update', false));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('retail-policy'), 'isdelete');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $group = Group::find($id);
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
