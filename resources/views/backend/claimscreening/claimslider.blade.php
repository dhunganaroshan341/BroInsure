<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body style="background: #eff1f3">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <p class="row">
                    <span class="col">
                        <strong>Document Name:</strong> <span class="text-capitalize"
                            id="documentName">{{ isset($sliders[0]) ? $sliders[0]->bill_file_name : '' }}</span>
                    </span>
                    <span class="col">
                        <strong> Document Type:</strong> <span class="text-capitalize"
                            id="documentType">{{ isset($sliders[0]) ? $sliders[0]->document_type : '' }}</span>
                    </span>
                    <span class="col text-end">
                        <button class="btn btn-sm btn-danger" id="closeTab"><i class="fas fa-times"></i></button>
                    </span>

                </p>
                <!-- Embed element where the content will change -->
                <div class="ratio ratio-16x9" id="embeddedSection">
                    @if (isset($sliders[0]))
                        @php
                            // Get the file extension
                            $extension = pathinfo($sliders[0]->file_path, PATHINFO_EXTENSION);
                            // Determine the MIME type based on the file extension
                            $mimeType = match ($extension) {
                                'pdf' => 'application/pdf',
                                'jpg' => 'image/jpg',
                                'jpeg' => 'image/jpeg',
                                'png' => 'image/png',
                                'gif' => 'image/gif',
                                'mp4' => 'video/mp4',
                                default => 'application/octet-stream',
                            };
                        @endphp
                        <embed id="dynamic-embed" class="embed-responsive-item" type="{{ $mimeType }}"
                            src="{{ asset($sliders[0]->file_path) }}" />
                    @endif
                </div>

                <!-- Buttons for navigation -->
                @if (count($sliders) > 1)
                    <div class="d-flex justify-content-between mt-3">
                        <button id="prevBtn" class="btn btn-sm btn-primary" disabled>
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <span class="text-center"><span id="counterSpan">1</span>/{{ count($sliders) }}</span>
                        <button id="nextBtn" class="btn btn-sm btn-primary">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        // List of sources (PDFs, images, or any other type of content)
        const sources = {!! json_encode($sliders) !!};
        let mimeType = `{{ count($sliders) > 0 ? $extension : '' }}`;
        // Keep track of the current source index
        let currentIndex = 0;
        // Function to update the embed src
        function updateEmbed() {
            let newMimeType = null;
            let file_path = sources[currentIndex].file_path;
            let sourceFile = '/' + file_path;

            // Optionally update the type based on the file extension
            if (file_path.endsWith('.pdf')) {
                newMimeType = 'application/pdf';
            } else if (file_path.endsWith('.jpg') || file_path.endsWith('.jpeg') || file_path.endsWith('.png')) {
                newMimeType = 'image/jpeg';
            } else {
                newMimeType = 'text/html';
            }
            $('#documentName').text(sources[currentIndex].bill_file_name);
            $('#documentType').text(sources[currentIndex].document_type);
            $("#embeddedSection").html('<embed id="dynamic-embed" class="embed-responsive-item" type="' + newMimeType +
                '"  src = "' + sourceFile + '"" / > ');
            // Enable/Disable buttons based on current index
            $('#prevBtn').prop('disabled', currentIndex === 0);
            $('#nextBtn').prop('disabled', currentIndex ===
                sources.length - 1);
            let countter = currentIndex + 1;
            $("#counterSpan").text(countter);
        }

        // Next button click handler using jQuery
        $('#nextBtn').on('click', function() {
            if (currentIndex < sources.length - 1) {
                currentIndex++;
                updateEmbed();
            }
        });

        // Previous button click handler using jQuery
        $('#prevBtn').on('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateEmbed();
            }
        });
        $('#closeTab').on('click', function() {
            if (confirm('Are you sure you want to close this tab?')) {
                window.close();
            }
        });
    </script>

</body>

</html>
