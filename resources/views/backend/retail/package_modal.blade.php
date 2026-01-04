<div class="modal fade" id="PackageFormModal" data-bs-backdrop="static" style="z-index: 1090">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="package-modal-title text-dark">Add New Data </h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <form class="row g-3 packageForm" id="PackagedataForm" action="{{ route('store-group-packages') }}">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="group_id" name="group_id" value="">
                        <div class="col-md-6">
                            <label for="input3" class="form-label">Package <span class="text-danger">*</span>
                            </label>
                            <select name="package_id" id="package_id" class="form-select" required>
                                <option value="" selected>--select package--</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for=""></label>
                            <p><b>Total Amount</b>: <span id="totalAmt">0</span></p>
                        </div>
                        <div class="packageTable" style="overflow-x: auto;">

                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                                <button type="submit" class="btn btn-success px-4 text-white"
                                    id="PackageBtnSubmit">Submit</button>
                                @if ($access['isupdate'] == 'Y')
                                    <button type="submit" class="btn btn-success px-4 text-white"
                                        id="PackageBtnUpdate">Update</button>
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
