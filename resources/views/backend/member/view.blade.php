<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title text-dark">View Employee Details</h6>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="col">

                        <h6 style="background: #86e4f7;">Personal Information</h6>

                        <div class="row">

                            <div class="col-md-4">
                                <label for="span3" class="form-label">First Name :</label>
                                <span id="view_first_name"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Middle Name </label>
                                <span id="view_middle_name"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Last Name :<span
                                        id="view_last_name"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Nationality : <span
                                        id="view_nationality"></span> </label>
                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Date of Birth (BS) : <span
                                        id="view_dateofbirth_bs"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label"> Date of Birth (AD) : <span type="date"
                                        id="view_dateofbirth_ad"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Employee ID : <span
                                        id="view_employee_id"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email : <span id="view_email"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Branch : <span id="view_branch"
                                        class="text-capitalize"></span></label>

                            </div>
                            <div class="col-md-4">
                                <label for="span3" class="form-label">Designation : <span id="view_designation"
                                        class="text-capitalize"></span></label>

                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <label class="form-check-label">Gender : <span id="view_gender"
                                        class="text-capitalize"></span>
                                </label>

                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <label class="form-check-label">Marital Status : <span id="view_married_status"
                                        class="text-capitalize"></span> </label>

                            </div>
                        </div>

                        @if ($url == 'individual')
                            <h6 style="background: #86e4f7;">Address</h6>
                            <div class="row">
                                <h6 style="background: #86e4f7;">Permanent Address :</h6>
                                <div class="col-md-4">
                                    <label for="providence" class="form-label">Province : <span
                                            id="view_providence"></span></label>

                                </div>
                                <div class="col-md-4">
                                    <label for="district" class="form-label"> District : <span
                                            id="view_district"></span></label>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label"> City : <span
                                            id="view_city"></span></label>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label"> Ward No : <span
                                            id="view_perm_ward_no"></span></label>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label"> Street/Tole/Village : <span
                                            id="view_perm_street"></span></label>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label"> House No : <span
                                            id="view_perm_house_no"></span></label>
                                </div>

                                <div class="form-check form-switch pt-3">

                                    <label class="form-check-label" for="is_address_same">Is Present Address Same :
                                        <span id="view_is_address_same"></span></label>
                                </div>
                                {{-- temporary address --}}
                                <div class="is_address_sameDiv row" hidden>
                                    <h6 style="background: #86e4f7;">Present Address :</h6>
                                    <div class="col-md-4">
                                        <label for="providence" class="form-label">Province : <span
                                                id="view_present_province"></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="district" class="form-label"> District : <span
                                                id="view_present_district"></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label"> City : <span
                                                id="view_present_city"></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label"> Ward No : <span
                                                id="view_present_ward_no"></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label"> Street/Tole/Village : <span
                                                id="view_present_street"></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city" class="form-label"> House No : <span
                                                id="view_present_house_no"></span></label>
                                    </div>
                                </div>
                            </div>

                            {{-- <h6 style="background: #86e4f7;">Contact & Others </h6> --}}
                            <div class="row">
                                <h6 style="background: #86e4f7;">Citizenship:</h6>
                                <div class="col-md-4">
                                    <label for="input3" class="form-label">Citizenship Number : <span
                                            id="view_citizenship_no"></span> </label>
                                </div>
                                <div class="col-md-4">
                                    <label for="input3" class="form-label">Citizenship Issued District : <span
                                            id="view_citizenship_district"></span> </label>

                                </div>
                                <div class="col-md-4">
                                    <label for="input3" class="form-label">Citizenship Issued Date (AD) : <span
                                            id="view_citizenship_issued_date"></span> </label>
                                </div>
                                <h6 style="background: #86e4f7;">Contact Information : </h6>
                                <div class="col-md-4">
                                    <label for="mobile_number" class="form-label">Mobile Number : <span
                                            id="view_mobile_number"></span> </label>
                                </div>


                                <h6 style="background: #86e4f7;">Occupation Information :</h6>
                                <div class="d-flex align-items-center gap-3">
                                    <label class="form-check-label">Occupation : <span id="view_occupation"></span>
                                    </label>

                                    <div class="form-check form-check-info">
                                        <label class="form-check-label" for="Other">Other : <span
                                                id="view_other_occupation"></span></label>
                                    </div>

                                </div>
                                <div class="col-md-4 otherDiv" hidden>
                                    <label for="email" class="form-label">Other : <span id="view_other"></span>
                                    </label>
                                </div>

                            </div>
                        @endif
                        <h6 style="background: #86e4f7;">Dependents </h6>
                        <div class="row ">
                            <div id="viewdependentDiv">

                            </div>
                        </div>
                        <h6 style="background: #86e4f7;">Attachments</h6>
                        <div class="row ">
                            <div id="viewAttachmentDiv">

                            </div>
                        </div>
                        <h6 style="background: #86e4f7;">Policy</h6>
                        <div class="row ">
                            <div class="col-md-4 onlyGroup">
                                <label for="client_id" class="form-label">Client : <span
                                        id="view_client_id"></span></label>
                            </div>
                            <div class="col-md-4 ">
                                <label for="group_id" class="form-label">Group : <span
                                        id="view_group_id"></span></label>
                            </div>
                            <div class="col-md-4 onlyGroup">
                                <label for="type" class="form-label">Type : <span id="view_type"></span></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
