<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashobardController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\InsuranceHeadingController;
use App\Http\Controllers\Admin\InsuranceSubHeadingController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UsertypeController;
use App\Http\Controllers\Admin\ClaimSubmissionController;
use App\Http\Controllers\Admin\ClaimReceivedController;
use App\Http\Controllers\Admin\ClaimRegisterController;
use App\Http\Controllers\Admin\FiscalYearController;
use App\Http\Controllers\Admin\ClientPolicyController;
use App\Http\Controllers\Admin\ClaimRegistrationController;
use App\Http\Controllers\Admin\ClaimScrutinyController;
use App\Http\Controllers\Admin\ClaimScreeningController;
use App\Http\Controllers\Admin\ClaimSettlementController;
use App\Http\Controllers\Admin\ClaimVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PremiumController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RetailController;
use App\Http\Controllers\Admin\RetailPolicyController;

Route::group(['prefix' => 'admin'], function () {



    Route::group(['middleware' => 'admin'], function () {
        Route::get('dashboard', [DashobardController::class, 'dashboard'])->name('dashboard');
        Route::get('get-claim-status-detail', [DashobardController::class, 'getClaimStatusData'])->name('getClaimStatusData');
        // Route::resource('dashboard', DashboardController::class);
        Route::get('get-districts/{id}', [DashobardController::class, 'getDistrict'])->name('getDistrict');
        Route::get('get-cities/{id}', [DashobardController::class, 'getCities'])->name('getCities');
        Route::get('get-total-members', [DashobardController::class, 'totalMember'])->name('getTotalClient');
        Route::post('get-preminum-amount', [DashobardController::class, 'preminumAmount'])->name('preminumAmount');
        Route::resource('usertype', UsertypeController::class);
        Route::resource('menu', MenuController::class);
        Route::post('permission/getSubmenuData', [PermissionController::class, 'SubmenuData']);
        Route::post('permission/getUsergroupWiseFormMenuData', [PermissionController::class, 'UsergroupWiseFormMenuData']);
        Route::post('permission/setformpermission', [PermissionController::class, 'setformpermission']);
        Route::post('storeAllSetformpermission', [PermissionController::class, 'storeAllSetformpermission']);
        Route::get('permission/form', [PermissionController::class, 'formPermission']);
        Route::post('storeAllPermission', [PermissionController::class, 'storeAllPermission']);
        Route::resource('permission', PermissionController::class);
        // Route::get('changepassword', [UserController::class, 'changepassword']);
        // Route::post('user/submitnewpassword', [UserController::class, 'submitnewpassword'])->name('updatePassword');
        Route::resource('user', UserController::class);
        Route::resource('clients', ClientController::class);
        Route::get('get-client-groups/{id}', [ClientController::class, 'getGroups']);
        Route::get('get-package-groupwise/{id}', [ClientController::class, 'getGroupsPackage']);
        Route::resource('members', MemberController::class);
        Route::get('client-members', [MemberController::class, 'clientEmployee']);
        Route::resource('member-groups', MemberController::class);
        Route::post('member/change-status', [MemberController::class, 'changeStatus']);

        Route::resource('headings', InsuranceHeadingController::class);
        Route::resource('sub-headings', InsuranceSubHeadingController::class);
        Route::resource('packages', PackageController::class);
        Route::get('package-headings/{id}', [GroupController::class, 'package_headings']);
        Route::resource('claimsubmissions', ClaimSubmissionController::class);
        Route::post('claimsubmissions/resubmission/store', [ClaimSubmissionController::class, 'storeResubmission'])->name('claimsubmissions.resubmission.store');
        Route::post('get-claimid-data/{claim_id}', [ClaimSubmissionController::class, 'getClaimIdDatas']);
        Route::post('get-claimid-confirm-view', [ClaimSubmissionController::class, 'getClaimidConfirmView']);

        Route::resource('groups', GroupController::class);
        Route::resource('retail-groups', RetailController::class);
        Route::get('get-group-packages/{id}', [GroupController::class, 'package_get']);
        Route::post('store-group-packages', [GroupController::class, 'package_post'])->name('store-group-packages');
        Route::delete('delete-group-packages', [GroupController::class, 'package_delete'])->name('delete-group-packages');
        Route::get('active-client-policies/{id}', [ClientController::class, 'policies'])->name('active.client.policies');
        Route::post('client/change-status', [ClientController::class, 'changeStatus']);

        Route::resource('claimreceived', ClaimReceivedController::class);
        //for claims routes
        Route::get('get-relatives/{id}', [MemberController::class, 'member_claim_details'])->name('get.relatives');
        Route::get('get-ralatives-amt/{id}', [MemberController::class, 'relative_claim_details'])->name('get.relative.amt');
        Route::get('get-sub-headings/{id}', [InsuranceHeadingController::class, 'sub_headings'])->name('get.sub.headings');
        Route::post('get-headings-by-policy/{policy_id}', [MemberController::class, 'headingsByPolicy'])->name('get.headings-by-policy');

        //Claim List
        Route::get('claimlist', [ClaimSubmissionController::class, 'claimlist'])->name('claim.list');
        Route::post('make-claim/{id}', [ClaimSubmissionController::class, 'makeClaim'])->name('claim.makeClaim');
        Route::post('make-claim-by-claim-id/{claim_id}', [ClaimSubmissionController::class, 'makeClaimByClaimId'])->name('claim.makeClaimByClaimId');
        Route::resource('claimregistration', ClaimRegistrationController::class);
        Route::resource('client-policies', ClientPolicyController::class);
        Route::get('get-client-policies/{id}', [ClientPolicyController::class, 'clientPolicy']);
        Route::post('review-policies', [ClientPolicyController::class, 'renewPolicy'])->name('renew-policies');
        Route::get('get-policy-group/{id}', [ClientPolicyController::class, 'getGroup'])->name('group.policies');
        //Claim Processing
        Route::get('claimverification/scrutiny', [ClaimVerificationController::class, "getScrutiny"]);
        Route::get('claimverification', [ClaimVerificationController::class, 'index']);
        Route::post('claimverification', [ClaimVerificationController::class, 'store']);
        Route::post('claimverification/individual', [ClaimVerificationController::class, 'storeIndividual']);
        //Claim Screening
        Route::get('claimscreening/claims-member', [ClaimScreeningController::class, "getInsuranceClaimsOfMember"]);
        Route::get('claimscreening/claim-sliders/{claim_id}', [ClaimScreeningController::class, "claimSlider"])->name('claimscreening.claim-sliders');
        Route::resource('claimscreening', ClaimScreeningController::class);
        Route::get('get-member-claims', [ClaimScreeningController::class, 'getClaims']);
        Route::get('get-group-lots', [ClaimScreeningController::class, 'getLots']);
        Route::get('get-group-claims-id', [ClaimScreeningController::class, 'getClaimId']);
        Route::post('claimscreening-settle', [ClaimScreeningController::class, 'settleClaims']);

        //fiscal-years
        Route::resource("fiscal-years", FiscalYearController::class)->except("show");
        Route::patch("/fiscal-years/{fiscal_year}/status", [FiscalYearController::class, "updateStatus"]);
        //Claim Scrutiny
        Route::resource('claimscrutiny', ClaimScrutinyController::class);
        //Correct / Resubmission/ Reject claim
        Route::post('claim-status-change', [ClaimSubmissionController::class, 'claimStatusChange']);


        Route::get('claim-register/{lot}/lot', [ClaimVerificationController::class, 'getClaimRegisterByLog']);
        Route::get('claimapproval', [ClaimSettlementController::class, 'index']);
        Route::get('claimapproval/{claim_note_id}/scrunity-list', [ClaimSettlementController::class, 'getScrunityTable']);
        Route::patch('claimapproval/updatestatus/{id}', [ClaimSettlementController::class, 'updatestatus'])->name('claimapproval.updatestatus');

        //Scrunity Detail Delete
        Route::delete('/scrutinydetail/{id}', [ClaimScrutinyController::class, 'destroyScrunity'])->name('scrutinydetail.destroyScrunity');
        Route::get('member-reference-excel', [MemberController::class, 'reference'])->name('member.reference');
        Route::post('member-import', [MemberController::class, 'import'])->name('member.import');
        //notification
        Route::post('mark-as-seen', [NotificationController::class, 'markAsSeen']);
        Route::get('notification', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('reports', [ReportController::class, 'index'])->name('report.index');
        Route::get('reports/claim-details', [ReportController::class, 'claim_details'])->name('report.claim_details');
        Route::get('reports/client-details', [ReportController::class, 'client_details'])->name('report.client_details');

        // Retail Policy
        Route::resource('retail-policy', RetailPolicyController::class);
        Route::get('premium', [PremiumController::class, 'premium']);
        Route::put('premium', [PremiumController::class, 'updatePremium'])->name('premium.update');
    });
});
