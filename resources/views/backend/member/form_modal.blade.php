<div class="modal fade" id="FormModal" aria-hidden="true" data-bs-backdrop="static">
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

                            <h3>Personal Information</h3>

                            <section>
                                @include('backend.member.individual.personal')
                            </section>
                            @if ($url == 'individual')
                                <h3>Address</h3>
                                <section>
                                    @include('backend.member.individual.address')
                                </section>
                                <h3>Contact & Others </h3>
                                <section>
                                    @include('backend.member.individual.citizenship')
                                </section>
                            @endif
                            <h3>Dependents </h3>
                            <section>
                                @include('backend.member.individual.dependent')
                            </section>
                            <h3>Attachments</h3>
                            <section>
                                @include('backend.member.individual.documents')
                            </section>
                            <h3>Policy</h3>
                            @if ($url == 'individual')
                                <section>
                                    @include('backend.member.individual.individualpolicy')
                                </section>
                            @else
                                <section>
                                    @include('backend.member.individual.policy')
                                </section>
                            @endif
                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
