<div class="row">
    <h4>Permanent Address :</h4>
    <div class="col-md-4">
        <label for="providence" class="form-label">Province<span class="text-danger">*</span> </label>
        <select name="address[perm_province]" id="providence" class="form-select " data-placeholder="Select province" required>
            <option value="" selected disabled>select province </option>
            @foreach ($provinces as $province)
                <option value="{{ $province->id }}" data-id="{{ $province->id }}">
                    {{ $province->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label for="district" class="form-label"> District <span class="text-danger">*</span> </label>
        <select id="district" class="form-select" name="address[perm_district]" required>
            <option value="" selected disabled>select district</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="city" class="form-label"> City <span class="text-danger">*</span> </label>
        <select id="city" class="form-select" name="address[perm_city]" required>
            <option value="" selected disabled>select district</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="city" class="form-label"> Ward No <span class="text-danger">*</span> </label>
        <input type="number" name="address[perm_ward_no]" id="perm_ward_no" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label for="city" class="form-label"> Street/Tole/Village <span class="text-danger">*</span> </label>
        <input type="text" name="address[perm_street]" id="perm_street" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label for="city" class="form-label"> House No </label>
        <input type="text" name="address[perm_house_no]" id="perm_house_no" class="form-control">
    </div>

    <div class="form-check form-switch pt-3">
        <input class="form-check-input" type="checkbox" role="switch" id="is_address_same" name="address[is_address_same]" value="Y"
            checked>
        <label class="form-check-label" for="is_address_same">Is Present Address Same</label>
    </div>
    {{-- temporary address --}}
    <div class="is_address_sameDiv row" hidden>
        <h4>Present Address :</h4>
        <div class="col-md-4">
            <label for="providence" class="form-label">Province<span class="text-danger">*</span> </label>
            <select name="address[present_province]" id="present_province" class="form-select presentRequired"
                data-placeholder="Select province">
                <option value="" selected disabled>select province </option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" data-id="{{ $province->id }}">
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="district" class="form-label"> District <span class="text-danger">*</span> </label>
            <select id="present_district" class="form-select presentRequired" name="address[present_district]">
                <option selected="" value="" disabled>select district</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label"> City <span class="text-danger">*</span> </label>
            <select id="present_city" class="form-select presentRequired" name="address[present_city]" >
                <option selected="" value="" disabled>select city</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label"> Ward No <span class="text-danger">*</span> </label>
            <input type="number" name="address[present_ward_no]" id="present_ward_no" class="form-control presentRequired">
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label"> Street/Tole/Village <span class="text-danger">*</span> </label>
            <input type="text" name="address[present_street]" id="present_street" class="form-control presentRequired">
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label"> House No </label>
            <input type="text" name="address[present_house_no]" id="present_house_no" class="form-control">
        </div>
    </div>
</div>
