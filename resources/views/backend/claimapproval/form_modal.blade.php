<div class="modal fade" id="FormModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('#') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-12">
                            <label for="typename" class="form-label">Usertype Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="typename" placeholder="Enter Phone"
                                name="typename" required>
                        </div>
                        <div class="col-md-12">
                            <label for="redirect_url" class="form-label">Redirect Url </label>
                            <input type="text" class="form-control" id="redirect_url"
                                placeholder="Enter Phone"name="redirect_url">
                        </div>
                        <div class="col-md-12">
                            <label for="input7" class="form-label">Country</label>
                            <select id="input7" class="form-select" name="redirect_url">
                                <option selected="">Choose...</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="input11" class="form-label">Address</label>
                            <textarea class="form-control" id="input11" placeholder="Address ..." rows="3" name="input11"></textarea>
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
