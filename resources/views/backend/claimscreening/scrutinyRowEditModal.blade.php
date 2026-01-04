<div class="modal fade" id="scrutinyRowEditModal">
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
                    <input type="hidden" id="current_scrutiny_edit_row_no">
                    <form class="row g-3 form" id="scrutinyEditRowForm" enctype="multipart/form-data"
                        data-is_disabled="false">
                        @csrf
                        {{-- <input type="hidden" name="id" id="insurance_claim_id"/> --}}
                        <div class="row my-1">
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Bill No <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    placeholder="Bill No" id="scrutiny_edit_bill_no" required>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">File <span class="text-danger"></span>: <span
                                        id="scrutiny_file_section"></span> </label>
                                <input data-required="true" type="file" name="files"
                                    class="form-control  form-control-sm" placeholder="File" id="scrutiny_edit_file"
                                    required>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Title <span class="text-danger">*</span>:</label>
                                <select class="labelsmaller form-select form-select-sm" data-required="true"
                                    id="scrutiny_edit_title_id" required>
                                    <option value="" selected>Select Title</option>
                                    @foreach ($headings as $heading)
                                        <option value="{{ $heading->id }}">{{ $heading->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Bill Amount <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="number" class="form-control  form-control-sm"
                                    placeholder="Bill Amount" id="scrutiny_edit_bill_amount" required>
                                <small id="misMatchSpanModal" hidden><span class="text-danger">* approved amount can not
                                        be more than bill amount</span></small>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Approved Amount <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="number" class="form-control  form-control-sm"
                                    placeholder="Approved Amount" id="scrutiny_edit_approved_amount" required>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Deduction <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="number" class="form-control  form-control-sm"
                                    placeholder="Approved Amount" id="scrutiny_edit_deduction" readonly required>
                            </div>
                            <div class="form-group col-md-6 mb-1">
                                <label class="labelsmaller">Remarks <span class="text-danger">*</span>:</label>
                                <input data-required="true" type="text" class="form-control  form-control-sm"
                                    placeholder="Remarks" id="scrutiny_edit_remarks" required>
                            </div>
                        </div>
                        <div class="col-md-12" id="scrutinyEditModalButtons">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-sm btn-success px-4 text-white"
                                    id="btnRecordUpdate">Update</button>
                                <button type="button" class="btn btn-sm btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
