<div class="modal fade" id="FormModal" data-bs-backdrop="static">
    <div class="modal-dialog  modal-dialog-scrollable  modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <form class="row g-3 form" id="dataForm" action="{{ route('groups.store') }}">
                    <div class="form-body row">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-lg-3 col-sm-6">
                            <label for="input3" class="form-label">Client <span class="text-danger">*</span>
                            </label>
                            <select name="client_id" id="client_id" class="form-select form-select-sm" required>
                                <option value="" selected>--select client--</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="input3" class="form-label">Policy <span class="text-danger">*</span>
                            </label>
                            <select id="policy_id" class="form-select form-select-sm" name="policy_id"
                                data-placeholder="select policy">
                                <option value="">Select Policy </option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <label for="insurance_amount" class="form-label">Insuranced Sum <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" id="insurance_amount"
                                placeholder="Enter Insuranced Sum" name="insurance_amount" required>
                            <span class="totalAmountErrorDIv"> <small class="text-danger">*Total Insured Amount Sould Be
                                    Equal To Heading Amount</small> </span>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="name" class="form-label">Group Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="name"
                                placeholder="Enter Group Name" name="name" required>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <label for="code" class="form-label">Group Code </label>
                            <input type="text" class="form-control form-control-sm" id="code"
                                placeholder="Enter Group Code" name="code">
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input is_amount_different" type="checkbox" value="Y"
                                    name="is_amount_different" id="is_amount_different">
                                <label class="form-check-label" for="is_amount_different">Different Insurance Amount For
                                    Dependented ?</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input is_imitation_days_different" type="checkbox"
                                    value="Y" name="is_imitation_days_different" id="is_imitation_days_different">
                                <label class="form-check-label" for="is_imitation_days_different">Different Imitation
                                    Days ?</label>
                            </div>
                        </div>
                        <div class="col-md-12">

                            @foreach ($headings as $heading)
                                <div class="accordion" id="accordionExample{{ $heading->id }}"
                                    data-id="{{ $heading->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header d-flex align-items-center justify-content-between"
                                            id="heading{{ $heading->id }}" style="background: #cfe2ff;">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $heading->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $heading->id }}">
                                                {{ $heading->name }}
                                            </button>

                                        </h2>
                                        <div id="collapse{{ $heading->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $heading->id }}"
                                            data-bs-parent="#accordionExample{{ $heading->id }}">
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <!-- Amount Field -->
                                                    <div class="col-md-2">
                                                        <label for="amount" class="form-label">Amount <span
                                                                class="text-danger">*</span>:</label>
                                                        <input type="number"
                                                            class="form-control form-control-sm headingAmount"
                                                            id="amount" name="amount[]" placeholder="Amount"
                                                            value="">
                                                    </div>
                                                    <!-- Imitation Days Field -->
                                                    <div class="col-md-2 differentImitationDaysDiv" hidden>
                                                        <label for="imitation_days{{ $heading->id }}"
                                                            class="form-label">Imitation Days <span
                                                                class="text-danger">*</span>:</label>
                                                        <input type="number"
                                                            class="form-control form-control-sm headingImitationDays"
                                                            id="imitation_days{{ $heading->id }}"
                                                            name="imitation_day[]" placeholder="Imitation Days"
                                                            value=""
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                    </div>

                                                    <!-- Employee Checkbox -->
                                                    <div class="col-md-2">
                                                        <div class="form-check form-check-info">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Y" name="is_employee[]" checked>
                                                            <label class="form-check-label"
                                                                for="is_employee">Employee</label>
                                                        </div>

                                                    </div>

                                                    <!-- Spouse Amount Field -->

                                                    <!-- Spouse Checkbox -->
                                                    <div class="col-md-2">
                                                        <div class="form-check form-check-info">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Y" name="is_spouse[]">
                                                            <label class="form-check-label"
                                                                for="is_spouse">Spouse</label>
                                                        </div>
                                                        <div class="differentInpDiv" hidden>
                                                            <label for="is_spouse_amount" class="form-label">Spouse
                                                                Amount <span class="text-danger">*</span>:</label>
                                                            <input type="number"
                                                                class="form-control form-control-sm differentInp "
                                                                id="is_spouse_amount" name="is_spouse_amount[]"
                                                                placeholder="Spouse Amount">
                                                        </div>
                                                    </div>

                                                    <!-- Child Amount Field -->

                                                    <!-- Child Checkbox -->
                                                    <div class="col-md-2">
                                                        <div class="form-check form-check-info">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Y" name="is_child[]">
                                                            <label class="form-check-label"
                                                                for="is_child">Child</label>
                                                        </div>
                                                        <div class="differentInpDiv" hidden>
                                                            <label for="is_child_amount" class="form-label">Child
                                                                Amount <span class="text-danger">*</span>:</label>
                                                            <input type="number"
                                                                class="form-control form-control-sm differentInp"
                                                                id="is_child_amount" name="is_child_amount[]"
                                                                placeholder="Child Amount">
                                                        </div>
                                                    </div>

                                                    <!-- Parent Amount Field -->


                                                    <!-- Parent Checkbox -->
                                                    <div class="col-md-2">
                                                        <div class="form-check form-check-info">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Y" name="is_parent[]">
                                                            <label class="form-check-label"
                                                                for="is_parent">Parent</label>
                                                        </div>
                                                        <div class="differentInpDiv" hidden>
                                                            <label for="is_parent_amount" class="form-label">Parent
                                                                Amount <span class="text-danger">*</span>:</label>
                                                            <input type="number"
                                                                class="form-control form-control-sm differentInp"
                                                                id="is_parent_amount" name="is_parent_amount[]"
                                                                placeholder="Parent Amount">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h6>Assign Sub Headings:</h6>
                                                <div class="row sub_headingRow">

                                                    @foreach ($heading->sub_headings as $subheading)
                                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                                                            <div class="form-check">
                                                                <input class="form-check-input sub_heading_id"
                                                                    name="sub_heading_id[]" type="checkbox"
                                                                    value="{{ $subheading->id }}"
                                                                    data-heading_id="{{ $subheading->heading_id }}"
                                                                    id="subHeading{{ $subheading->id }}_{{ $subheading->heading_id }}">
                                                                <label class="form-check-label"
                                                                    for="subHeading{{ $subheading->id }}_{{ $subheading->heading_id }}">
                                                                    {{ $subheading->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-success px-4 text-white"
                                    id="btnSubmit">Submit</button>
                                @if ($access['isupdate'] == 'Y')
                                    <button type="submit" class="btn btn-success px-4 text-white"
                                        id="btnUpdate">Update</button>
                                @endif
                                <button type="button" class="btn btn-danger px-4 text-white"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div> --}}

                    </div>
            </div>
            <div class="modal-footer">
                <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                    <button type="submit" class="btn btn-success px-4 text-white" id="btnSubmit">Submit</button>
                    @if ($access['isupdate'] == 'Y')
                        <button type="submit" class="btn btn-success px-4 text-white" id="btnUpdate">Update</button>
                    @endif
                    <button type="button" class="btn btn-danger px-4 text-white"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
