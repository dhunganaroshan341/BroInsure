<div class="modal fade" id="viewEditModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <strong class="modal-title text-dark" id="modalTitle">View Data</strong>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="viewEditRecordForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="insurance_claim_id" />
                        <input type="hidden" name="serial_number" id="serial_number" />
                        <div class="row my-1">
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="heading_id">Claim Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm heading_select"
                                    data-required="true" name="heading_id" id="edit_heading_id">
                                    <option value="" selected="" disabled>Select Claim Heading
                                    </option>
                                    {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="sub_heading_id">Claim Sub Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm" data-required="true"
                                    name="sub_heading_id" id="edit_sub_heading_id">
                                    <option value="" selected="" disabled>Select Claim Sub Heading
                                    </option>
                                    {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_type">Document Type <span
                                        class="text-danger">*</span>:</label>
                                <select data-required="true" class="labelsmaller form-select form-select-sm"
                                    name="document_type" id="edit_document_type">
                                    <option value="" selected="" disabled>Select Document Type
                                    </option>
                                    <option value="bill">Bill/Invoices </option>
                                    <option value="prescription">
                                        Prescriptions/Clinical Notes </option>
                                    <option value="report">Reports </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_file">File <span class="text-danger">*</span>:
                                    <span id="fileUrl"></span></label>
                                <input type="file" class="form-control  form-control-sm" name="bill_file"
                                    placeholder="File">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_file_name">File Name <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm" name="bill_file_name"
                                    accept="image/png, image/jpeg, application/pdf" placeholder="File Name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_date">Document Date <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="date" class="form-control  form-control-sm"
                                    name="document_date" placeholder="Document Date" id="edit_document_date">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_amount">Bill Amount <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="bill_amount" placeholder="Bill Amount" id="edit_bill_amount">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="remark">Remark:</label>
                                <input type="text" class="form-control  form-control-sm" name="remark"
                                    placeholder="Remark" id="edit_remark">
                            </div>
                            {{-- <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="clinical_facility_name">Clinical Facility
                                    Name <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name">
                            </div> --}}
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="diagnosis_treatment">Clinical Facility Name:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name"
                                    id="edit_clinical_facility_name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="diagnosis_treatment">Diagnosis/Treatment:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="diagnosis_treatment" placeholder="Diagnosis/Treatment"
                                    id="edit_diagnosis_treatment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="button" class="btn btn-sm btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                                <span id="submitBtn">

                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="resubmission_viewEditModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <strong class="modal-title text-dark" id="modalTitle">View Data</strong>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="resubmission_viewEditRecordForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="insurance_claim_id" />
                        <input type="hidden" name="serial_number" id="resubmission_serial_number" />
                        <div class="row my-1">
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_heading_id">Claim Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm resubmission_heading_select"
                                    data-required="true" name="heading_id" id="resubmission_edit_heading_id">
                                    <option value="" selected="" disabled>Select Claim Heading
                                    </option>
                                    {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_sub_heading_id">Claim Sub Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm" data-required="true"
                                    name="sub_heading_id" id="resubmission_edit_sub_heading_id">
                                    <option value="" selected="" disabled>Select Claim Sub Heading
                                    </option>
                                    {{-- @foreach ($headings as $heading)
                                        <option value="{{$heading->id}}">{{$heading->name}}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_document_type">Document Type <span
                                        class="text-danger">*</span>:</label>
                                <select data-required="true" class="labelsmaller form-select form-select-sm"
                                    name="document_type" id="resubmission_edit_document_type">
                                    <option value="" selected="" disabled>Select Document Type
                                    </option>
                                    <option value="bill">Bill/Invoices </option>
                                    <option value="prescription">
                                        Prescriptions/Clinical Notes </option>
                                    <option value="report">Reports </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_bill_file">File <span
                                        class="text-danger">*</span>:
                                    <span id="resubmission_fileUrl"></span></label>
                                <input type="file" class="form-control  form-control-sm" name="bill_file"
                                    placeholder="File">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_bill_file_name">File Name <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm" name="bill_file_name"
                                    accept="image/png, image/jpeg, application/pdf" placeholder="File Name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_document_date">Document Date <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="date" class="form-control  form-control-sm"
                                    name="document_date" placeholder="Document Date"
                                    id="resubmission_edit_document_date">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_bill_amount">Bill Amount <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="bill_amount" placeholder="Bill Amount" id="resubmission_edit_bill_amount">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_remark">Remark:</label>
                                <input type="text" class="form-control  form-control-sm" name="remark"
                                    placeholder="Remark" id="resubmission_edit_remark">
                            </div>
                            {{-- <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_clinical_facility_name">Clinical Facility
                                    Name <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name">
                            </div> --}}
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="resubmission_diagnosis_treatment">Clinical Facility
                                    Name:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name"
                                    id="resubmission_edit_clinical_facility_name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller"
                                    for="resubmission_diagnosis_treatment">Diagnosis/Treatment:</label>
                                <input type="text" class="form-control  form-control-sm"
                                    name="diagnosis_treatment" placeholder="Diagnosis/Treatment"
                                    id="resubmission_edit_diagnosis_treatment">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="button" class="btn btn-sm btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                                <span id="resubmission_submitBtn">

                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="confirmSubmitBtn">
                    <label class="form-check-label" for="confirmSubmitBtn"> Are you sure you want to proceed
                        with this action?</label>
                </div>
                <div class="savePDFPrint">

                </div>
            </div>
        </div>
    </div>
</div>
