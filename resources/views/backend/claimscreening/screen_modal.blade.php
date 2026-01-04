<div class="modal fade" id="scrutinyModal" tabindex="-1" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header py-0">
                <strong class="modal-title text-dark labelsmaller " id="modalTitle">View Data</strong>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body py-0">
                <div class="form-body">
                    {{-- <form class="row g-3 scrutinyForm" id="scrutinyForm" enctype="multipart/form-data"> --}}
                    @csrf
                    <input type="hidden" name="id" id="insurance_claim_id" />
                    <div class="toBeAdeedDynamically">


                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
