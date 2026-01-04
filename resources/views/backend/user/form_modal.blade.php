<div class="modal fade" id="FormModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Data</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('user.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">First Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                name="fname">
                        </div>
                        <div class="col-md-6">
                            <label for="lname" class="form-label">Last Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                name="lname">
                        </div>
                        <div class="col-md-6">
                            <label for="fname" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="email" placeholder="Enter Email"
                                name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="lname" class="form-label">Mobile Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobilenumber"
                                placeholder="Enter Mobile Number" name="mobilenumber">
                        </div>
                        <div class="col-md-6 password-container">
                            <label for="lname" class="form-label">Password <span
                                    class="text-danger editNullable">*</span></label>
                            <input type="password" autocomplete="off" class="form-control passwordInput" id="password"
                                placeholder="Password" name="password">
                            <span class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label for="usertype" class="form-label">User Type</label>
                            <select id="usertype" class="form-select" name="usertype">
                                <option selected="" disabled>Choose...</option>
                                @foreach ($usertypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->typename }}</option>
                                @endforeach
                            </select>
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
