<style>
    #submissionSection,
    #scrunitySection {
        width: 100%;
        max-height: 80vh;
        /* Set max height to 80% of viewport height */
        overflow: auto;
        /* Enable scrolling */
        position: relative;
        border: 1px solid #ccc;
        /* Optional: Add a border for visual effect */
    }

    #submission-slider-image,
    #scrunity-slider-image {
        max-width: 100%;
        /* Ensure image width is responsive */
        height: auto;
        transition: transform 0.25s ease;
        /* Smooth zoom transition */
    }

    .sticky-sidebar {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        z-index: 1060;
        /* Ensure it's above any modal */
        width: 60px;
        /* Adjust width for vertical alignment */
        background-color: #f8f9fa;

        border: 1px solid #ddd;
        padding: 15px 5px;
        /* Adjust padding for vertical button */
    }

    .toggle-btn {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        /* Rotate to make the text readable */
        width: 100%;
        text-align: center;
        /* margin-bottom: 15px; */
        /* Add margin for spacing */
    }

    .nav-link {
        text-align: center;
    }

    .collapse-vertical {
        background: white;
        width: 250px;
        position: absolute;
        left: -250px;
        top: 0;
        height: auto;
    }
</style>
<div class="sticky-sidebar" hidden>
    <button class="btn btn-primary toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
        aria-expanded="false" aria-controls="sidebarMenu">
        Remaining Balance
    </button>
    <div class="collapse collapse-vertical" id="sidebarMenu"
        style="background: #eff1f3;padding:20px 10px ; border: 2px solid var(--bs-modal-header-border-color);">
        <div class="">
            <div class="">
                <p>Balance Details</p>
                <div class="balance-detail-info row" id="balance-detail-info">

                </div>
                <div class="col-md-12 text-center fw-bold text-decoration-underline mt-3" id="total-balance">
                    <!-- Total balance will be injected here -->
                </div>
            </div>

        </div>
    </div>
</div>
