<div class="modal fade" id="FormModal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('packages.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Package Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Package Name"
                                name="name" required>
                        </div>

                        <div class="col-md-12">
                            <label for="redirect_url" class="form-label">Heading</label>
                            <label for="redirect_url" class="form-label">Amount</label>
                            <label for="redirect_url" class="form-label">Employee </label>
                            <label for="redirect_url" class="form-label">Spouse</label>
                            <label for="redirect_url" class="form-label">Children</label>
                            <label for="redirect_url" class="form-label">Parents</label>
                            @foreach ($headings as $heading)
                                <div class="accordion" id="accordionExample{{ $heading->id }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header d-flex align-items-center justify-content-between"
                                            id="heading{{ $heading->id }}" style="background: #cfe2ff;">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $heading->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $heading->id }}">
                                                {{ $heading->name }}
                                            </button>
                                            <input type="number"
                                                class="form-control form-control-sm headingAmount ms-3" id="amount"
                                                name="amount[]" placeholder="Amount" required value=""
                                                style="width: 15%">
                                            <div class="form-check form-check-info">
                                                <input class="form-check-input customCheckClass " type="checkbox"
                                                    value="Y" style=" name="is_employee[]">
                                            </div>

                                            <input class="form-control form-control-sm" type="text"
                                                name="spouse_amount[]" style="width: 15%">
                                            <div class="form-check form-check-info">
                                                <input class="form-check-input customCheckClass " type="checkbox"
                                                    value="Y" name="is_spouse[]">
                                            </div>
                                            <div class="form-check form-check-info">
                                                <input class="form-check-input customCheckClass " type="checkbox"
                                                    value="Y" name="is_child[]">
                                            </div>
                                            <input class="form-control  form-control-sm" type="text"
                                                name="child_amount[]" style="width: 15%">
                                            <div class="form-check form-check-info">
                                                <input class="form-check-input customCheckClass " type="checkbox"
                                                    value="Y" name="is_parent[]">
                                            </div>
                                            <input class="form-control form-control-sm" type="text"
                                                name="parent_amount[]" style="width: 15%">
                                        </h2>
                                        <div id="collapse{{ $heading->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $heading->id }}"
                                            data-bs-parent="#accordionExample{{ $heading->id }}">
                                            <div class="accordion-body">
                                                <div class="row">

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

                        <div class="col-md-12">
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
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
