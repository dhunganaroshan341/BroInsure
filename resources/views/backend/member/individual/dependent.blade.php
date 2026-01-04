<div class="row ">
    <div id="dependentDiv">
        <div class="newEntry row">
            <div class="col-md-2">
                <label for="input3" class="form-label">Relation </label>
                {{-- <input type="text" class="form-control" id="rel_relation" placeholder="Enter Relation"
                    name="rel_relation[]" > --}}
                    <select name="rel_relation[]" id="rel_relation" class="form-select">
                        <option value=""  selected disabled>select relation</option>
                        <option value="father">Father</option>
                        <option value="mother">Mother</option>
                        <option value="mother-in-law">Mother-in-law</option>
                        <option value="father-in-law">Father-in-law</option>
                        <option value="spouse">Spouse</option>
                        <option value="child1">child 1</option>
                        <option value="child2">child 2</option>
                    </select>
            </div>
            <div class="col-md-3">
                <label for="input3" class="form-label">Full Name </label>
                <input type="text" class="form-control" id="rel_name" placeholder="Enter Full Name"
                    name="rel_name[]" >
            </div>
            <div class="col-md-3">
                <label for="rel_dob" class="form-label">Date of Birth </label>
                <input type="date" class="form-control" id="rel_dob" placeholder="Enter AGE" name="rel_dob[]"
                    >
            </div>
            <div class="col-md-2">
                <label for="input3" class="form-label">Gender </label>
                <select name="rel_gender[]" id="rel_gender" class="form-select">
                    <option value=""  selected>select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-2 pt-2">
                <br>
                <button type="button" type="button" class="btn btn-sm btn-primary addBtn"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>
