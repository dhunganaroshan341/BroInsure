<div class="old_relation_container">
    @foreach ($relations as $relation)
        <div class="newEntry row">
            <input type="hidden" name="rel_id[]" value="{{ $relation->id }}">
            <div class="col-md-2">
                <label for="input3" class="form-label">Relation </label>
                <input type="text" class="form-control" id="rel_relation" placeholder="Enter Relation"
                    value="{{ $relation->rel_relation }}" name="rel_relation[]">
            </div>
            <div class="col-md-3">
                <label for="input3" class="form-label">Full Name </label>
                <input type="text" class="form-control" id="rel_name" placeholder="Enter Full Name"
                    value="{{ $relation->rel_name }}" name="rel_name[]">
            </div>
            <div class="col-md-3">
                <label for="rel_dob" class="form-label">Date of Birth </label>
                <input type="date" class="form-control" id="rel_dob" placeholder="Enter AGE"
                    value="{{ $relation->rel_dob }}" name="rel_dob[]">
            </div>
            <div class="col-md-2">
                <label for="input3" class="form-label">Gender </label>
                <select name="rel_gender[]" id="rel_gender" class="form-select">
                    <option value="" selected>select gender</option>
                    <option value="male" {{ $relation->rel_gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $relation->rel_gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $relation->rel_gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2 pt-2">
                <br>
                <button type="button" type="button" class="btn btn-sm btn-danger removeBtn"><i
                        class="fa fa-minus"></i></button>
            </div>
        </div>
    @endforeach
</div>
