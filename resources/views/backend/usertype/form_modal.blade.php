<div class="modal fade" id="FormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Registration Form</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('usertype.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-12">
                            <label for="input3" class="form-label">Usertype Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="typename" placeholder="Enter Usertype Name"
                                name="typename" required>
                        </div>
                        <div class="col-md-12">
                            <label for="input3" class="form-label">Redirect Url </label>
                            <input type="text" class="form-control" id="redirect_url"
                                placeholder="Enter Redirect Url" name="redirect_url">
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
