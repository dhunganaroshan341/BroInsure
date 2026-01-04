<div class="col-md-6 submissionEdit marginTopMQ {{ $type !== 'screening' ? 'extraMargin' : '' }}">
    @php
        $scrunityFilesDetails = $claims[0]?->scrunity?->details;
    @endphp
    <div class="row">
        <div class="">
            <p class="row">
                <span class="col">
                    {{-- <strong>Document Name:</strong> <span class="text-capitalize" id="documentName">Bill File
                    name</span> --}}
                    <select id="submissionSelect" class="form-select">

                    </select>
                </span>
                <span class="col">
                    <strong> Claim Submission Files</strong>
                    {{-- <strong> Document Type:</strong> <span class="text-capitalize"
                    id="documentType">document_type</span> --}}
                </span>
            </p>
            <!-- Embed element where the content will change -->
            <div class="ratio ratio-16x9" id="submissionSection">
                <img id="submission-slider-image" class="img-fluid" src="" alt="Image Slider">
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button id="submissionprevBtn" class="btn btn-sm btn-primary" disabled>
                    <i class="fas fa-arrow-left"></i> Previous
                </button>

                <span class="text-center"><span id="submissionCounterSpan">1</span></span>
                <button id="submissionNextBtn" class="btn btn-sm btn-primary">
                    Next <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 scrunityEdit marginTopMQSec {{ $type !== 'screening' ? 'extraMargin' : '' }}">
    <div class="row">
        <div class="">
            <p class="row">
                <span class="col">
                    <select id="scrunitySelect" class="form-select">

                    </select>
                </span>
                <span class="col">
                    <strong> Scrunity Files </strong>
                </span>
            </p>
            <div class="ratio ratio-16x9" id="scrunitySection">
                <img id="scrunity-slider-image" class="img-fluid" src="" alt="Image Slider">
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button id="scrunityPrevBtn" class="btn btn-sm btn-primary" disabled>
                    <i class="fas fa-arrow-left"></i> Previous
                </button>
                <span class="text-center"><span id="scrunityCounterSpan">1</span></span>
                <button id="scrunityNextBtn" class="btn btn-sm btn-primary">
                    Next <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        const allClaims = @json($claims);
        const scrunityFiles = @json($scrunityFilesDetails);
        $('#submissionSelect option[value!=""]').remove();
        $('#scrunitySelect option[value!=""]').remove();

        let newtotalClaimAMount = 0;
        let invoiceIndex = 0;
        let scrunityIndex = 0;
        const baseURL = '{{ url('/') }}';
        let incoiceSelectIndex = 0;
        let scrunitySelectIndex = 0;
        //for select options
        $.each(allClaims, function(index, claim) {

            $("#submissionSelect").append(
                '<option value="' +
                claim.id +
                '" data-id="' +
                incoiceSelectIndex +
                '"' +
                ">" +
                claim.bill_file_name +
                "</option>"
            );
            incoiceSelectIndex++;
            newtotalClaimAMount += parseInt(claim.bill_amount);
        })
        $('#newTotalClaimAmt').html(newtotalClaimAMount.toLocaleString('en-IN'));
        $.each(scrunityFiles, function(index, scrunity) {

            $("#scrunitySelect").append(
                '<option value="' +
                scrunity.id +
                '" data-id="' +
                scrunitySelectIndex +
                '"' +
                ">" +
                scrunity.bill_no +
                "</option>"
            );
            scrunitySelectIndex++;

        })
        //for bill

        function invoiceSlider() {
            const invoiceCurrentImage = allClaims[invoiceIndex];
            $('#submission-slider-image').attr('src', baseURL + '/' + invoiceCurrentImage.file_path);
            $('#submissionCounterSpan').text((invoiceIndex + 1) + '/' + allClaims.length);
            $('#submissionprevBtn').prop('disabled', invoiceIndex === 0);
            $('#submissionNextBtn').prop('disabled', invoiceIndex === allClaims.length - 1);
        }

        $(document).on('change', '#submissionSelect', function() {
            let currentlySelected = $(this).find(':selected').attr('data-id');
            invoiceIndex = parseInt(currentlySelected);
            $('#submissionCounterSpan').text(' ');
            invoiceSlider();
        });

        $('#submissionprevBtn').click(function() {
            if (invoiceIndex > 0) {
                invoiceIndex--;
                invoiceSlider();
            }
        });
        $('#submissionNextBtn').click(function() {
            if (invoiceIndex < allClaims.length - 1) {
                invoiceIndex++;
                invoiceSlider();
            }
        });
        //for scrunityFiles

        function scrunityUpdateSlider() {
            const scrunityCurrentImage = scrunityFiles[scrunityIndex];
            $('#scrunity-slider-image').attr('src', baseURL + '/' + scrunityCurrentImage.file);
            $('#scrunityCounterSpan').text((scrunityIndex + 1) + '/' + scrunityFiles.length);
            $('#scrunityPrevBtn').prop('disabled', scrunityIndex === 0);
            $('#scrunityNextBtn').prop('disabled', scrunityIndex === scrunityFiles.length - 1);
        }

        $('#scrunityPrevBtn').click(function() {
            if (scrunityIndex > 0) {
                scrunityIndex--;
                scrunityUpdateSlider();
            }
        });

        $('#scrunityNextBtn').click(function() {
            if (scrunityIndex < scrunityFiles.length - 1) {
                scrunityIndex++;
                scrunityUpdateSlider();
            }
        });
        let invoiceZoomLevel = 1;

        $('#submissionSection').on('wheel', function(event) {
            event.preventDefault();
            if (event.originalEvent.deltaY < 0) {
                // Scroll up, zoom in
                invoiceZoomLevel += 0.1;
            } else {
                // Scroll down, zoom out
                invoiceZoomLevel -= 0.1;
            }
            invoiceZoomLevel = Math.min(Math.max(1, invoiceZoomLevel),
            3); // Limit zoom between 1x and 3x
            $('#submission-slider-image').css('transform', `scale(${invoiceZoomLevel})`);
        });

        function dataURLToBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const byteString = atob(parts[1]);
            const mimeString = parts[0].split(':')[1];
            const buffer = new ArrayBuffer(byteString.length);
            const uintArray = new Uint8Array(buffer);
            for (let i = 0; i < byteString.length; i++) {
                uintArray[i] = byteString.charCodeAt(i);
            }
            return new Blob([buffer], {
                type: mimeString
            });
        }

        $(document).on('change', '#scrunitySelect', function() {
            let currentlySelected = $(this).find(':selected').attr('data-id');
            scrunityIndex = parseInt(currentlySelected);
            $('#scrunityCounterSpan').text('');
            scrunityUpdateSlider();
        });
        let scrunityZoomLevel = 1;
        $('#scrunitySection').on('wheel', function(event) {
            event.preventDefault();
            if (event.originalEvent.deltaY < 0) {
                scrunityZoomLevel += 0.1;
            } else {
                scrunityZoomLevel -= 0.1;
            }
            scrunityZoomLevel = Math.min(Math.max(1, scrunityZoomLevel),
                3);
            $('#scrunity-slider-image').css('transform', `scale(${scrunityZoomLevel})`);
        });
        if (allClaims.length > 0) {
            invoiceSlider();
        }
        if (scrunityFiles.length > 0) {
            scrunityUpdateSlider();
        }
    });
</script>
