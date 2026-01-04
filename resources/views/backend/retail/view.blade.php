<div class="modal fade" id="ViewModal" data-bs-backdrop="static">
    <div class="modal-dialog  modal-dialog-scrollable  modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">View Employee Details </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body row">
                    <div class="col-md-6">
                        <label for="viewClient" class="form-label">Client :<span id="view_client"></span>
                        </label>

                    </div>

                    <div class="col-md-6">
                        <label for="view_insurance_amount" class="form-label">Insuranced Sum :<span
                                id="view_insurance_amount"></span></label>

                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Group Name : <span id="view_name"></span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="code" class="form-label">Group Code : <span id="view_code"></span> </label>
                    </div>
                    <div class="col-md-6">
                        <label class="form-check-label disabledCh" for="is_spouse">Different Insurance Amount For
                            Dependented : <span id="view_is_amount_different"></span></label>
                    </div>
                    <div class="col-md-6">
                        <label class="form-check-label disabledCh" for="view_is_imitation_days_different">Different
                            Imitation Days : <span id="view_is_imitation_days_different"></span></label>
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
                                                    <label for="amount" class="form-label">Amount :</label>
                                                    <input type="number"
                                                        class="form-control form-control-sm headingAmount"
                                                        id="amount" name="view_amount[]" placeholder="Amount"
                                                        value="" disabled>
                                                    <div class="form-check form-switch appendLimit mt-3">
                                                        <input class="form-check-input view_limit_check" type="checkbox"
                                                            value="Y" name="limit_check" disabled
                                                            id="view_limit_check{{ $heading->id }}">
                                                        <label class="form-check-label" for="limit_check">Apply
                                                            Limit check</label>
                                                    </div>
                                                </div>
                                                <!-- Imitation Days Field -->
                                                <div class="col-md-2 differentImitationDaysDiv" hidden>
                                                    <label for="imitation_days{{ $heading->id }}"
                                                        class="form-label">Imitation Days <span
                                                            class="text-danger">*</span>:</label>
                                                    <input type="number"
                                                        class="form-control form-control-sm headingImitationDays"
                                                        id="imitation_days{{ $heading->id }}" name="imitation_day[]"
                                                        placeholder="Imitation Days" value=""
                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                        disabled>
                                                </div>
                                                <!-- Employee Checkbox -->
                                                <div class="col-md-2">
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input disabledCh" type="checkbox"
                                                            value="Y" name="view_is_employee[]" checked disabled>
                                                        <label class="form-check-label disabledCh"
                                                            for="is_employee">Employee</label>
                                                    </div>

                                                </div>

                                                <!-- Spouse Amount Field -->

                                                <!-- Spouse Checkbox -->
                                                <div class="col-md-2">
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input disabledCh" type="checkbox"
                                                            value="Y" name="view_is_spouse[]" disabled>
                                                        <label class="form-check-label disabledCh"
                                                            for="is_spouse">Spouse</label>
                                                    </div>
                                                    <div class="viewDifferentInpDiv" hidden>
                                                        <label for="is_spouse_amount" class="form-label">Spouse
                                                            Amount ::</label>
                                                        <input type="number"
                                                            class="form-control form-control-sm differentInp "
                                                            id="is_spouse_amount" name="view_is_spouse_amount[]"
                                                            placeholder="Spouse Amount" disabled>
                                                    </div>
                                                </div>

                                                <!-- Child Amount Field -->

                                                <!-- Child Checkbox -->
                                                <div class="col-md-2">
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input disabledCh" type="checkbox"
                                                            value="Y" name="view_is_child[]" disabled>
                                                        <label class="form-check-label disabledCh"
                                                            for="is_child">Child</label>
                                                    </div>
                                                    <div class="viewDifferentInpDiv" hidden>
                                                        <label for="is_child_amount" class="form-label">Child
                                                            Amount ::</label>
                                                        <input type="number"
                                                            class="form-control form-control-sm differentInp"
                                                            id="view_is_child_amount" name="view_is_child_amount[]"
                                                            placeholder="Child Amount" disabled>
                                                    </div>
                                                </div>

                                                <!-- Parent Amount Field -->


                                                <!-- Parent Checkbox -->
                                                <div class="col-md-2">
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input disabledCh" type="checkbox"
                                                            value="Y" name="view_is_parent[]" disabled>
                                                        <label class="form-check-label disabledCh"
                                                            for="is_parent">Parent</label>
                                                    </div>
                                                    <div class="viewDifferentInpDiv" hidden>
                                                        <label for="is_parent_amount" class="form-label">Parent
                                                            Amount ::</label>
                                                        <input type="number"
                                                            class="form-control form-control-sm differentInp"
                                                            id="view_is_parent_amount" name="view_is_parent_amount[]"
                                                            placeholder="Parent Amount" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <h6>Assign Sub Headings:</h6>
                                            <div class="row">

                                                @foreach ($heading->sub_headings as $subheading)
                                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 subLimitRow">

                                                        <div class="form-check">
                                                            <input class="form-check-input disabledCh sub_heading_id"
                                                                name="view_sub_heading_id[]" type="checkbox"
                                                                value="{{ $subheading->id }}"
                                                                data-heading_id="{{ $subheading->heading_id }}"
                                                                id="view_subHeading{{ $subheading->id }}_{{ $subheading->heading_id }}"
                                                                disabled>
                                                            <label class="form-check-label disabledCh"
                                                                for="view_subHeading{{ $subheading->id }}_{{ $subheading->heading_id }}">
                                                                {{ $subheading->name }}
                                                            </label>
                                                        </div>
                                                        <div class="mb-3 mt-3 appendAccessType col-md-11" disabled id="viewAccessDiv{{$subheading->id}}">
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

                </div>
            </div>
            <div class="modal-footer">
                <div class="d-md-flex d-grid align-items-center gap-3 float-end">

                    <button type="button" class="btn btn-danger px-4 text-white"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
