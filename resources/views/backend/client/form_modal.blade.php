<div class="modal fade" id="FormModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 form" id="dataForm" action="{{ route('clients.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Client Name"name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="code" class="form-label">Client Code </label>
                            <input type="text" class="form-control" id="code" placeholder="Phone"name="code">
                        </div>
                        <div class="col-md-6">
                            <label for="providence" class="form-label">Province <span
                                    class="text-danger">*</span></label>
                            <select id="providence" class="form-select" name="province_id" required>
                                <option selected="" disabled>select province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" data-id="{{ $province->id }}">
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                            <select id="district" class="form-select" name="district_id" required>
                                <option selected="" disabled>select district</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <select id="city" class="form-select" name="city_id" required>
                                <option selected="" value="" disabled>City</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address"
                                name="address">
                        </div>
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile"
                                name="mobile" required>
                        </div>
                        <div class="col-md-6">
                            <label for="land_line" class="form-label">Land Line</label>
                            <input type="text" class="form-control" id="land_line" placeholder="Enter Land Line"
                                name="land_line">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="pan" class="form-label">Pan</label>
                            <input type="file" class="form-control" id="pan" name="pan">
                            <div class="imgCl" hidden>
                                <a href="" target="_blank" class="panA"><img src="" alt=""
                                        height="90" class="panImg"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="registration" class="form-label">Registration</label>
                            <input type="file" class="form-control" id="registration" name="registration">
                            <div class="imgCl" hidden>
                                <a href="" target="_blank" class="registrationA"><img src=""
                                        alt="" height="90" class="registrationImg"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tax_clearence" class="form-label">Tax Clearence File</label>
                            <input type="file" class="form-control" id="tax_clearence" name="tax_clearence">
                            <div class="imgCl" hidden>
                                <a href="" target="_blank" class="tax_clearenceA"><img src=""
                                        alt="" height="90" class="tax_clearenceImg"></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="Mobile" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="contact_person"
                                placeholder="Enter Contact Person" name="contact_person">
                        </div>
                        <div class="col-md-6">
                            <label for="Mobile" class="form-label">Contact Person No.</label>
                            <input type="text" class="form-control" id="contact_person_contact"
                                placeholder="Enter Contact Person No." name="contact_person_contact">
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
