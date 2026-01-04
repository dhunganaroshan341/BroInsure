<div class="modal fade" id="viewEditModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                        <div class="row my-1">
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="employee_id">Emp Id <span
                                        class="text-danger">*</span>:</label>
                                <select id="modal_employee_id" data-required="true"
                                    class="labelsmaller form-select form-select-sm" name="member_id">
                                    <option value="" selected="" disabled="">Select Employee </option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee?->user?->fname . ' ' . $employee?->user?->mname . ' ' . $employee?->user?->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">

                                <label class="labelsmaller px-0" for="destination_id">Designation <span
                                        class="text-danger">*</span>:</label>
                                <div class="px-0">
                                    <input type="text" class="form-control  form-control-sm" name="destination_id"
                                        id="destination_id" placeholder="Designation" disabled>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller " for="branch_id">Branch <span
                                        class="text-danger">*</span>:</label>
                                <div class="col-sm ">
                                    <input type="text" class="form-control  form-control-sm" name="branch_id"
                                        id="branch_id" placeholder="Branch" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="employee_name">Employee Name <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm" name="employee_name"
                                    id="employee_name" placeholder="Employee Name" readonly disabled>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="relative_id">Member :</label>
                                <select id="relative_id" class="labelsmaller form-select form-select-sm"
                                    name="relative_id" data-placeholder="select member">
                                    <option value="">Select Member </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="relation">Relation <span
                                        class="text-danger"></span>:</label>
                                <input type="text" class="form-control  form-control-sm" name="relation"
                                    id="relation" placeholder="Relation" disabled>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="policy_no">Policy No <span
                                        class="text-danger">*</span>:</label>
                                <input type="text" class="form-control  form-control-sm" name="policy_no"
                                    id="policy_no" placeholder="Policy No">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="heading_id">Claim Heading <span
                                        class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm" data-required="true"
                                    name="heading_id" id="heading_id">
                                    <option value="" selected="" disabled>Select Claim Heading
                                    </option>
                                    @foreach ($headings as $heading)
                                        <option value="{{ $heading->id }}">{{ $heading->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="sub_heading_id">Claim Sub Heading <span
                                        class="text-danger">*</span>:</label>
                                <select id="sub_heading_id" class="labelsmaller form-select form-select-sm"
                                    data-required="true" name="sub_heading_id">
                                    <option value="" selected="" disabled>Select Claim Sub Heading</option>

                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_type">Document Type <span
                                        class="text-danger">*</span>:</label>
                                <select data-required="true" class="labelsmaller form-select form-select-sm"
                                    name="document_type" id="document_type">
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
                                <input data-required="true" type="file" class="form-control  form-control-sm"
                                    name="bill_file" placeholder="File">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_file_name">File Name <span
                                        class="text-danger"></span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="bill_file_name" accept="image/png, image/jpeg, application/pdf"
                                    placeholder="File Name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="document_date">Document Date <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="date" class="form-control  form-control-sm"
                                    name="document_date" placeholder="Document Date" id="document_date">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="bill_amount">Bill Amount <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="bill_amount" placeholder="Bill Amount" id="bill_amount">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="remark">Remark <span
                                        class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="remark" placeholder="Remark" id="remark">
                            </div>
                            {{-- <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="clinical_facility_name">Clinical Facility
                                    Name <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name">
                            </div> --}}
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="clinical_facility_name">Clinical Facility Name
                                    <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="clinical_facility_name" placeholder="Clinical Facility Name"
                                    id="clinical_facility_name">
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller" for="diagnosis_treatment">Diagnosis/Treatment
                                    <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    name="diagnosis_treatment" placeholder="Diagnosis/Treatment"
                                    id="diagnosis_treatment">
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
<div class="modal fade" id="detailsCLaimsOfCLaimIdModal">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <strong class="modal-title text-dark">All claims of <span id="modalTitleClaimID"></span>
                </strong>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="table-responsive">
                        <table id="datatables-reponsive-individual"
                            class="table-striped  labelsmaller table table-striped table-bordered cell-border">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    {{-- <th>Claim Id</th>
                                    <th>Emp Id</th>
                                    <th>Emp Name</th>
                                    <th>Designation</th>
                                    <th>Branch </th>
                                    <th>Member</th>
                                    <th>Relation</th>
                                    <th>Policy No.</th> --}}
                                    <th>Bill Amount</th>
                                    <th>Document Type</th>
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Remark</th>
                                    <th>Document Date</th>
                                    <th>Heading</th>
                                    <th>Sub Heading</th>
                                    <th>Clinical Facility</th>
                                    <th>Diagnosis/Treatment</th>
                                    <th>Claim Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
