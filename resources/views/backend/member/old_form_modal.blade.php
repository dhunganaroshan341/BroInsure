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
                    <form class="row g-3 form" id="dataForm" action="{{ route('members.store') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="col">
                            <hr>
                            <div class="card">
                                <div class="card-body " id="jquery-steps">
                                    <ul class="nav nav-tabs nav-success" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalInfo"
                                                role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="fas fa-user me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Personal Information</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#AddressInfo" role="tab"
                                                aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class="fas fa-address-book me-1 fs-6"></i>
                                                    </div>
                                                    <div class="tab-title">Address</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#contactInfo" role="tab"
                                                aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i
                                                            class='fas fa-phone-square-alt me-1 fs-6'></i>
                                                    </div>
                                                    <div class="tab-title">Contact</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#citizenshipInfo"
                                                role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class='far fa-address-card me-1 fs-6'></i>
                                                    </div>
                                                    <div class="tab-title">Citizenship</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#addRelativeInfo"
                                                role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class='fas fa-users me-1 fs-6'></i>
                                                    </div>
                                                    <div class="tab-title">Relatives</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#documentationInfo"
                                                role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-icon"><i class='fas fa-file-alt me-1 fs-6'></i>
                                                    </div>
                                                    <div class="tab-title">Documentations</div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content py-3">
                                        <div class="tab-pane fade show active" id="personalInfo" role="tabpanel">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label">First Name <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="first_name"
                                                        placeholder="Enter First Name" name="first_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label">First Name </label>
                                                    <input type="text" class="form-control" id="middle_name"
                                                        placeholder="Enter Middle Name" name="middle_name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label">Last Name <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="last_name"
                                                        placeholder="Enter Last Name" name="last_name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label">Nationality <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="nationality"
                                                        placeholder="Enter Nationality" name="nationality" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label">Date of Birth (BS) <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control" id="dateofbirth_bs"
                                                        placeholder="Enter dateofbirth_bs" name="dateofbirth_bs"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="input3" class="form-label"> Date of Birth (AD) :
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="date" class="form-control" id="nationality"
                                                        placeholder="Enter Nationality" name="nationality" required>
                                                </div>

                                                <div class="d-flex align-items-center gap-3">
                                                    <label class="form-check-label">Gender <span
                                                            class="text-danger">*</span>: </label>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="male" value="male" checked>
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="female" value="male">
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            id="other" value="male">
                                                        <label class="form-check-label" for="other">Other</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <label class="form-check-label">Marital Status <span
                                                            class="text-danger">*</span>: </label>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio"
                                                            name="marital_status" id="unmarried" value="unmarried"
                                                            checked>
                                                        <label class="form-check-label"
                                                            for="unmarried">Unmarried</label>
                                                    </div>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio"
                                                            name="marital_status" id="married" value="married">
                                                        <label class="form-check-label" for="married">Married</label>
                                                    </div>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input" type="radio"
                                                            name="marital_status" id="maritalOther"
                                                            value="maritalOther">
                                                        <label class="form-check-label"
                                                            for="maritalOther">Other</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="AddressInfo" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="providence" class="form-label">Province<span
                                                            class="text-danger">*</span> </label>
                                                    <select name="perm_province" id="providence" class="form-select "
                                                        data-placeholder="Select province">
                                                        <option value="" selected disabled>select province
                                                        </option>
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->id }}">{{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="district" class="form-label"> District <span
                                                            class="text-danger">*</span> </label>
                                                    <select id="district" class="form-select" name="perm_district">
                                                        <option selected="" disabled>select district</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label"> City <span
                                                            class="text-danger">*</span> </label>
                                                    <select id="city" class="form-select" name="perm_city">
                                                        <option selected="" disabled>select district</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label"> Ward No <span
                                                            class="text-danger">*</span> </label>
                                                    <input type="text" name="perm_ward_no" id="perm_ward_no"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label"> Street/Tole/Village
                                                        <span class="text-danger">*</span> </label>
                                                    <input type="text" name="perm_street" id="perm_street"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label"> House No
                                                        <input type="text" name="perm_house_no" id="perm_house_no"
                                                            class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contactInfo" role="tabpanel">
                                            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out
                                                mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
                                                Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                                                locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR
                                                banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                                banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                                them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth
                                                chambray yr.</p>
                                        </div>
                                        <div class="tab-pane fade" id="citizenshipInfo" role="tabpanel">
                                            <p> citizenshipInfo Etsy mixtape wayfarers, ethical wes anderson tofu before
                                                they sold out
                                                mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
                                                Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                                                locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR
                                                banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                                banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                                them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth
                                                chambray yr.</p>
                                        </div>
                                        <div class="tab-pane fade" id="occupationInfo" role="tabpanel">
                                            <p>occupationInfo Etsy mixtape wayfarers, ethical wes anderson tofu before
                                                they sold out
                                                mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
                                                Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                                                locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR
                                                banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                                banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                                them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth
                                                chambray yr.</p>
                                        </div>
                                        <div class="tab-pane fade" id="addRelativeInfo" role="tabpanel">
                                            <p>occupationInfo Etsy mixtape wayfarers, ethical wes anderson tofu before
                                                they sold out
                                                mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
                                                Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                                                locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR
                                                banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                                banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                                them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth
                                                chambray yr.</p>
                                        </div>
                                        <div class="tab-pane fade" id="documentationInfo" role="tabpanel">
                                            <p>occupationInfo Etsy mixtape wayfarers, ethical wes anderson tofu before
                                                they sold out
                                                mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
                                                Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                                                locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR
                                                banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg
                                                banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy
                                                retro mlkshk vice blog. Scenester cred you probably haven't heard of
                                                them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth
                                                chambray yr.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
