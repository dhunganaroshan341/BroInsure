<div class="row">
    <h4>Citizenship:</h4>
    <div class="col-md-4">
        <label for="input3" class="form-label">Citizenship Number <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="citizenship_no" placeholder="Enter Citizenship Number"
            name="citizenship[citizenship_no]" required>
    </div>
    <div class="col-md-4">
        <label for="input3" class="form-label">Citizenship Issued District <span class="text-danger">*</span> </label>
            <select class="form-select" id="citizenship_district"
            placeholder="Enter Citizenship Issued District" name="citizenship[citizenship_district]" required>
                <option value="" selected disabled>select district</option>
                @foreach ($districts as $district)
                <option value="{{$district->id}}">{{$district->name}}</option>
                @endforeach
            </select>
    </div>
    <div class="col-md-4">
        <label for="input3" class="form-label">Citizenship Issued Date (AD) <span class="text-danger">*</span> </label>
        <input type="date" class="form-control" id="citizenship_issued_date" placeholder="Enter Citizenship Issued Date"
            name="citizenship[citizenship_issued_date]" required>
    </div>
    <h4>Contact Information : </h4>
    {{-- <div class="col-md-4">
        <label for="mail_address" class="form-label">Mail Address <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="mail_address" placeholder="Enter Mail Address"
            name="personal[mail_address]" required>
    </div>
    <div class="col-md-4">
        <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="phone_number" placeholder="Enter Phone Number"
            name="personal[phone_number]" required>
    </div> --}}
    <div class="col-md-4">
        <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile Number"
            name="personal[mobile_number]" required>
    </div>
    

    <h4>Occupation Information :</h4>
    <div class="d-flex align-items-center gap-3">
        <label class="form-check-label">Occupation <span class="text-danger">*</span>: </label>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Salaried" value="Salaried"
                checked>
            <label class="form-check-label" for="Salaried">Salaried</label>
        </div>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Retired" value="Retired">
            <label class="form-check-label" for="Retired">Retired</label>
        </div>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Student" value="Student">
            <label class="form-check-label" for="Student">Student</label>
        </div>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Housewife"
                value="Housewife">
            <label class="form-check-label" for="Housewife">Housewife</label>
        </div>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Business" value="Business">
            <label class="form-check-label" for="Business">Business</label>
        </div>
        <div class="form-check form-check-info">
            <input class="form-check-input" type="radio" name="citizenship[occupation]" id="Other" value="Other">
            <label class="form-check-label" for="Other">Other</label>
        </div>

    </div>
    {{-- <div class="col-md-4">
        <label for="email" class="form-label">Source of Income <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="income_source" placeholder="Enter Source of Income"
            name="citizenship[income_source]" required>
    </div> --}}
    <div class="col-md-4 otherDiv" hidden>
        <label for="email" class="form-label">Other <span class="text-danger">*</span> </label>
        <input type="text" class="form-control" id="email" placeholder="Enter Other "
            name="citizenship[occupation_other]">
    </div>

</div>
