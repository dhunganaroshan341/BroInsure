<div class="modal fade" id="FormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Fiscal Year </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('fiscal-years.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                name="name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date"
                                placeholder="Start Date"name="start_date">
                        </div>
                        <div class="col-md-12">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date"
                                placeholder="Start Date"name="end_date">
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
