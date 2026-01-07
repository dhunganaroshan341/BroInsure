<?php

use App\Models\Discussion;
use App\Models\InsuranceClaim;
use App\Models\Notification;
use App\Models\Scrunity;
use App\Models\ScrunityDetail;
use Illuminate\Support\Facades\DB;
use App\Models\User;





function testhelper()
{
    return 'from helper';
}

function getMessageText($type, $issuccess = true, $message = false)
{
    if ($type == 'insert' && $issuccess === true) {
        return 'Data Successfully Inserted';
    } else if ($type == 'insert' && $issuccess === false) {
        return 'Couldnot insert a data';
    } else if ($type == 'update' && $issuccess === true) {
        return 'Data Successfully Updated';
    } else if ($type == 'update' && $issuccess === false) {
        return 'Couldnot update a data';
    } else if ($type == 'delete' && $issuccess === true) {
        return 'Data Successfully deleted';
    } else if ($type == 'delete' && $issuccess === false) {
        return 'Couldnot delete a data';
    } else if ($type == 'fetch' && $issuccess === true) {
        return 'Data Successfully fetched';
    } else if ($type == 'passwordupdate' && $issuccess === true) {
        return 'Password succesfully changed';
    } else if ($type == 'passwordupdate' && $issuccess === false) {
        return 'Couldnot update a password';
    } else if ($type == 'notification' && $issuccess === true) {
        return $message;
    } else {
        return 'Couldnot fetch data';
    }
}


function getUserDetail()
{
    $user = DB::table('users')
        ->join('usertype', 'users.usertype', '=', 'usertype.id')
        ->leftJoin('members', 'users.id', '=', 'members.user_id')
        ->select('users.id', 'users.fname', 'users.lname', 'users.mobilenumber', 'users.countrycode', 'users.email', 'typename', 'usertype', 'usertype.redirect_url', 'usertype.rolecode', DB::raw("CONCAT(fname, ' ', lname) AS full_name"), 'members.client_id', 'members.id as member_id')
        ->where('users.id', Auth::guard('admin')->id())
        ->first();
    return $user;
}
function getSideMenu()
{
    $userdata = getUserDetail();

    $menu = DB::table('modules as m')
        ->select('m.id', 'm.modulename', 'm.url', 'm.icon')
        ->join('module_permission as mp', function ($join) {
            $join->on('m.id', '=', 'mp.modulesid')->where('parentmoduleid', 0);
        })->whereNull('m.archived_at')
        ->where('mp.usertypeid', $userdata->usertype)
        ->groupBy('m.id', 'm.modulename', 'm.url', 'm.icon')
        ->orderBy('m.orderby')
        ->get();
    return $menu;
}
function getSideSubMenu($menuid)
{
    $userdata = getUserDetail();
    $menu = DB::table('modules as m')->select('m.id', 'm.modulename', 'm.url', 'm.icon')
        ->join('module_permission as mp', function ($join) {
            $join->on('m.id', 'mp.modulesid');
        })->whereNull('m.archived_at')->where('m.parentmoduleid', $menuid)->where('mp.usertypeid', $userdata->usertype)->groupBy('m.id', 'm.modulename', 'm.url', 'm.icon')->orderBy('m.orderby')->get();
    return $menu;
}

function checkmenupermission()
{
    $userdata = getUserDetail();


    $path = Request::path();
    $explode = explode('admin/', $path);
    $url = $explode[1];
    $notcheck_url = ['apply', 'changepassword', 'notification', 'reference-excel', 'discussion-export', 'member-reference-excel'];
    $match = in_array($url, $notcheck_url) || fnmatch('claimscreening/claim-sliders/*', $url);
    if ($match) {
        return 1;
    } else {
        $menuCount = DB::table('modules')
            ->join('module_permission', 'modules.id', '=', 'module_permission.modulesid')
            ->where('modules.url', $url)
            ->where('module_permission.usertypeid', $userdata->usertype)
            ->count();
        return $menuCount;
    }
}

function checkAccessPrivileges($form)
{
    $userdata = getUserDetail();

    $access = DB::table('form_permission')
        ->select('isinsert', 'isedit', 'isupdate', 'isdelete')
        ->where('usertypeid', $userdata->usertype)
        ->where('slug', $form)
        ->get();
    if (count($access) > 0) {
        return (array) $access[0];
    } else {
        return array('isinsert' => 'N', 'isedit' => 'N', 'isupdate' => 'N', 'isdelete' => 'N');
    }
}

function getUserByRoleCode($rolecodearr)
{

    $data = DB::table('users as ul')
        ->select('ul.id as userid', 'ul.fname', 'ul.lname', 'ur.typename', 'ur.rolecode', 'ul.usertype', DB::raw("CONCAT(ul.fname, ' ', ul.lname) as full_name"), 'd.name as designation', 'module_ids', 'profile_pic', 'signature')
        ->join('usertype as ur', 'ur.id', '=', 'ul.usertype');
    // Applying conditions based on the rolecode array
    if ($rolecodearr == 'notclient') {
        $data = $data->whereNotIn('ur.rolecode', ['CU']);
    } elseif ($rolecodearr != 'all') {
        $data = $data->whereIn('ur.rolecode', $rolecodearr);
    }

    $data = $data->leftJoin('designations as d', 'd.id', '=', 'ul.designation_id')
        ->orderBy('full_name')
        ->get();
    // dd($data);
    if ($data) {
        return $data;
    } else {
        return array();
    }
}
function commonDatatableFiles($type = null)
{
    if ($type == 'css') {
        $data[] = 'admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css';
    } else {

        $data[] = 'admin/assets/plugins/datatable/js/jquery.dataTables.min.js';
        $data[] = 'admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js';
        $data[] = 'admin/assets/plugins/datatable/extraTablejs.js';
    }
    return $data;
}


function getUsers($type = null, $userid = null)
{

    $users = DB::table('users as ul')
        ->when($userid, function ($q) use ($userid) {
            $q->where('id', $userid);
        })
        ->when($type, function ($q) use ($type) {
            $q->whereExists(function ($query) use ($type) {
                $query->select(DB::raw(1))
                    ->from('usertype')
                    ->whereRaw('ul.usertype = usertype.id')  // Adjust the relationship column name
                    ->whereIn('usertype.rolecode', $type);
            });
        })
        ->leftJoin('usertype', 'ul.usertype', '=', 'usertype.id')  // Adjust the relationship column name
        ->select('ul.*', 'usertype.typename', DB::raw("CONCAT(ul.fname, ' ', ul.lname) as full_name"))
        ->orderBy('ul.fname')
        ->get();
    return $users;
}




function numberFormatter($number)
{
    $numberFormatter = new NumberFormatter('en-IN', NumberFormatter::DECIMAL);
    return $numberFormatter->format($number);
}

function claimedAmount($memberId, $groupPackageHeadingId, $headingId, $relative = null, $onlyScrutiny = false)
{
    if (!$onlyScrutiny) {
        $insuranceCLaimsAmount = InsuranceClaim::whereIn('status', [
            InsuranceClaim::STATUS_RECEIVED,
            InsuranceClaim::STATUS_REGISTERED,
            InsuranceClaim::STATUS_RESUBMISSION,
        ])
            ->where('insurance_claims.heading_id', $headingId)
            ->where('insurance_claims.member_id', $memberId)
            ->where('insurance_claims.relative_id', $relative)
            ->join('group_headings', function ($join) use ($groupPackageHeadingId, $headingId) {
                $join->on('insurance_claims.group_id', '=', 'group_headings.group_id')
                    ->where('group_headings.id', $groupPackageHeadingId)
                    ->where('group_headings.heading_id', $headingId)
                ;
            })

            ->sum(DB::raw('CAST(insurance_claims.bill_amount AS NUMERIC)'));
    } else {
        $insuranceCLaimsAmount = 0;
    }


    //old
    $scrunity = ScrunityDetail::whereHas('scrunity', function ($q) use ($memberId, $relative) {
        $q->where('member_id', $memberId)
            ->where('status', '!=', Scrunity::STATUS_REJECTED)
            ->where('relative_id', $relative)
            ->whereHas('claims', function ($q1) use ($memberId, $relative) {
                $q1->where('member_id', $memberId)
                    ->when(!is_null($relative), function ($query) use ($relative) {
                        $query->where('relative_id', $relative);
                    })
                    ->whereNotIn('status', [
                        InsuranceClaim::STATUS_RECEIVED,
                        InsuranceClaim::STATUS_REGISTERED,
                        InsuranceClaim::STATUS_REJECTED,
                    ])
                ;
            })
        ;
    })
        ->where('group_heading_id', $groupPackageHeadingId)
        ->where('heading_id', $headingId)
        ->selectRaw('SUM(CAST(approved_amount AS NUMERIC)) as total_approved_amount')
        ->value('total_approved_amount');

    return $total = $insuranceCLaimsAmount + $scrunity;

}
function storeNotification($type, $user_ids, $message = null, $redirectUrl = null)
{
    $validatedData = [];
    $validatedData['type'] = $type;
    $validatedData['notification_date'] = date('Y-m-d');
    $validatedData['message'] = $message != null ? $message : 'You have been assigned new task ' . $type . ' - By ' . getUserDetail()->fname . ' ' . getUserDetail()->lname;
    $validatedData['redirect_url'] = $redirectUrl;
    foreach ($user_ids as $user_id) {
        $validatedData['user_id'] = $user_id;
        $data = Notification::create($validatedData);
    }
}
function getNotification()
{
    $userId = getUserDetail()->id;
    $notificationsData = Notification::select([
        'notifications.*',
        DB::raw('(SELECT COUNT(*)
                  FROM notifications n
                  WHERE n.user_id = notifications.user_id
                  AND n.is_seen != \'Y\') AS unseen_count')
    ])
        ->where('user_id', $userId)
        ->orderByDesc('id')
        ->take(4)
        ->get();
    return $notificationsData;
}

function numberToWordsNp($value)
{
    $fraction = round(fractionPart($value) * 100);
    $fractionText = "";

    if ($fraction > 0) {
        $fractionText = "AND " . convertNumber($fraction) . " PAISE";
    }

    return convertNumber(floor($value)) . " RUPEE " . $fractionText . " ONLY.";
}

function fractionPart($number)
{
    return $number - floor($number);
}

function convertNumber($number)
{
    if ($number < 0 || $number > 999999999) {
        return "NUMBER OUT OF RANGE!";
    }

    $crore = floor($number / 10000000); // Crore
    $number -= $crore * 10000000;

    $lakh = floor($number / 100000); // Lakhs
    $number -= $lakh * 100000;

    $thousand = floor($number / 1000); // Thousand
    $number -= $thousand * 1000;

    $hundred = floor($number / 100); // Hundred
    $number %= 100;

    $tens = floor($number / 10); // Tens
    $ones = $number % 10; // Ones

    $result = "";

    if ($crore > 0) {
        $result .= convertNumber($crore) . " CRORE";
    }
    if ($lakh > 0) {
        $result .= ($result == "" ? "" : " ") . convertNumber($lakh) . " LAKH";
    }
    if ($thousand > 0) {
        $result .= ($result == "" ? "" : " ") . convertNumber($thousand) . " THOUSAND";
    }
    if ($hundred > 0) {
        $result .= ($result == "" ? "" : " ") . convertNumber($hundred) . " HUNDRED";
    }

    $onesArray = [
        "",
        "ONE",
        "TWO",
        "THREE",
        "FOUR",
        "FIVE",
        "SIX",
        "SEVEN",
        "EIGHT",
        "NINE",
        "TEN",
        "ELEVEN",
        "TWELVE",
        "THIRTEEN",
        "FOURTEEN",
        "FIFTEEN",
        "SIXTEEN",
        "SEVENTEEN",
        "EIGHTEEN",
        "NINETEEN"
    ];
    $tensArray = [
        "",
        "",
        "TWENTY",
        "THIRTY",
        "FORTY",
        "FIFTY",
        "SIXTY",
        "SEVENTY",
        "EIGHTY",
        "NINETY"
    ];

    if ($tens > 0 || $ones > 0) {
        if ($result != "") {
            $result .= " AND ";
        }
        if ($tens < 2) {
            $result .= $onesArray[$tens * 10 + $ones];
        } else {
            $result .= $tensArray[$tens];
            if ($ones > 0) {
                $result .= "-" . $onesArray[$ones];
            }
        }
    }

    if ($result == "") {
        $result = "ZERO";
    }

    return $result;
}
