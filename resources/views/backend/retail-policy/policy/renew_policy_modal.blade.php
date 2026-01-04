<div class="modal fade" id="RenewPolicyFormModal" data-bs-backdrop="static" style="z-index: 1090">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="renew_policy-modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 renewPolicyForm" id="renewPolicyForm" action="{{ route('renew-policies') }}">
                        <input type="hidden" id="renew_policy_id" name="renew_policy_id" value="">
                        <div class="row">

                            <div class="col-md-6">
                                <label for="code" class="form-label">New Policy Number <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" id="renew_policy_no"
                                    placeholder="New Policy Number"name="policy_no" required>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Issue Date <span
                                        class="text-danger">*</span>:</label>
                                <input type="date" class="form-control" id="renew_issue_date"
                                    placeholder="Policy"name="issue_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Valid Date <span
                                        class="text-danger">*</span>:</label>
                                <input type="date" class="form-control" id="renew_valid_date"
                                    placeholder="Policy"name="valid_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Number Of Employee <span
                                        class="text-danger">*</span>:</label>
                                <input type="number" min="1" class="form-control" id="renew_member_no"
                                    placeholder="Number Of Employee"name="member_no" required>
                            </div>
                            <div class="col-md-6">
                                <label for="code" class="form-label">Imitation Days <span
                                        class="text-danger">*</span>: <small>(*in days)</small> </label>
                                <input type="number" min="1" class="form-control" id="renew_imitation_days"
                                    placeholder="Imitation Days" name="imitation_days" required>
                            </div>
                            {{-- <div class="col-md-6 ">
                                <div class="d-flex align-items-center">
                                    <label class="form-label me-2" for="excess_type">Excess Type : Fixed</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" value="percentage" name="excess_type" id="renew_excess_type" checked>
                                        <label class="form-check-label" for="excess_type">Percentage</label>
                                    </div>
                                </div>
                                <label for="excess_value" class="form-label">Excess<span class="text-danger">*</span>:</label>
                                <input type="number" min="1" class="form-control" id="renew_excess_value" placeholder="Enter Excess Value" name="excess_value">
                            </div> --}}
                        </div>
                        {{-- <hr>
                        <h6>Reinsurance (RI) :</h6>
                        <div class="row">
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="nepal_ri" class="form-label">Nepal Ri <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_nepal_ri" placeholder="Enter Nepal Ri %" name="nepal_ri" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="himalayan_ri" class="form-label">Himalayan Ri <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_himalayan_ri" placeholder="Enter Himalayan Ri %" name="himalayan_ri" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="retention" class="form-label">Retention <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_retention" placeholder="Enter Retention %" name="retention" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="quota" class="form-label">Quota <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_quota" placeholder="Enter quota %" name="quota" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="surplus_i" class="form-label">Surplus I <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_surplus_i" placeholder="Enter Surplus I %" name="surplus_i" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="surplus_ii" class="form-label">Surplus II <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_surplus_ii" placeholder="Enter Surplus II %" name="surplus_ii" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="auto_fac" class="form-label">Auto Fac <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_auto_fac" placeholder="Enter Auto Fac %" name="auto_fac" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="facultative" class="form-label">Facultative <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_facultative" placeholder="Enter Facultative %" name="facultative" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="co_insurance" class="form-label">Co-insurance <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_co_insurance" placeholder="Enter Co-insurance %" name="co_insurance" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="xol_i" class="form-label">XOL I <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_xol_i" placeholder="Enter XOL I %" name="xol_i" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="xol_ii" class="form-label">XOL II <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_xol_ii" placeholder="Enter XOL II %" name="xol_ii" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="xol_iii" class="form-label">XOL III <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_xol_iii" placeholder="Enter XOL III %" name="xol_iii" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="xol_iiii" class="form-label">XOL IIII <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_xol_iiii" placeholder="Enter XOL IIII %" name="xol_iiii" max="100"  vlaue="0" required>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <label for="pool" class="form-label">Pool <span class="text-danger">*</span>:</label>
                                <input type="number" min="0" class="form-control ri100" id="renew_pool" placeholder="Enter Pool %" name="pool" max="100"  vlaue="0" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span id="riErr" class="text-danger " hidden><i>Sum Of Reinsurance (RI) should be 100% .</i></span>
                            </div>
                        </div> --}}

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-success px-4 text-white"
                                    id="RenewPolicyBtnSubmit">Renew</button>
                                {{-- @if ($access['isupdate'] == 'Y')
                                    <button type="submit" class="btn btn-success px-4 text-white"
                                        id="RenewPolicyBtnUpdate">Update</button>
                                @endif --}}
                                <button type="button" class="btn btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
