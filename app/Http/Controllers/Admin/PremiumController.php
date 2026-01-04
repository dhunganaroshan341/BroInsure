<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\CompanyPolicy;
use App\Models\PremiumCalculation;
use App\Http\Controllers\Controller;
use App\Http\Requests\PremiumRequest;
use App\Http\Controllers\BaseController;

class PremiumController extends BaseController
{
    public function index()
    {
        $data['premium'] = PremiumCalculation::first();
        $data['groups'] = Group::pluck('name', 'id');
        $data['policies'] = CompanyPolicy::pluck('policy_no', 'id');
        // $data['extraCss'][] = 'admin/cdns/select2-bootstrap-5/dist/select2-bootstrap-5-theme.min.css';
        // $data['extraCss'][] = 'admin/cdns/select2@4.1/dist/css/select2.min.css';
        // $data['extraJs'][] = 'admin/cdns/select2@4.1/dist/js/select2.min.js';

        return view('premium', $data);
    }

    public function premium()
    {
        $access = $this->accessCheck('premium');
        $premium = PremiumCalculation::first();
        $title = "Premium Factors";
        return view('backend.premium.premium-factor', compact('premium', 'title'));
    }

    public function updatePremium(PremiumRequest $request)
    {
        $accessCheck = $this->checkAccess($this->accessCheck('premium'), 'isupdate');
        if ($accessCheck && $accessCheck['status'] == false) {
            return response()->json(['status' => $accessCheck['status'], 'message' => $accessCheck['message'], 403]);
        }
        $first = PremiumCalculation::first();
        if ($first != null) {
            $first->update($request->validated());
            return $this->sendResponse(true, getMessageText('update'));
        } else {
            return $this->sendError(getMessageText('update'), false);
        }
    }

    // Get group from policy
    public function getGroup($id = null)
    {
        if ($id != null) {
            $group = Group::with('policy')->where('policy_id', $id)->get();
        } else {
            $group = Group::all();
        }
        if (!$group->isEmpty()) {
            return $this->sendResponse($group, getMessageText('fetch'));
        } else {
            return $this->sendResponse(getMessageText('fetch'), false);
        }
    }

    // Get Insured Amount
    public function getInsuredAmount($id = null)
    {
        if ($id != null) {
            $group = Group::with('policy')->find($id);
            if ($group) {
                return $this->sendResponse($group, getMessageText('fetch'));
            }
        } else {
            $group = CompanyPolicy::all();
            if (!$group->isEmpty()) {
                return $this->sendResponse($group, getMessageText('fetch'));
            }
        }
         return $this->sendResponse([], false);
    }
}
