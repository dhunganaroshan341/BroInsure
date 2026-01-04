<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'Insurance Dashboard' }}</title>
<!--favicon-->
<link rel="icon" href="{{ asset('admin/assets/images/favicon-32x32.png') }}" type="image/png">
<!-- loader-->
<link href="{{ asset('admin/assets/css/pace.min.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

<!--plugins-->
{{-- <link href="{{asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet"> --}}
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/assets/plugins/metismenu/metisMenu.min.css') }}?v={{ $assetVersion }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/assets/plugins/metismenu/mm-vertical.css') }}?v={{ $assetVersion }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}?v={{ $assetVersion }}">
<!--bootstrap css-->
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
<!--main css-->
<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<link href="{{ asset('admin/sass/main.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<link href="{{ asset('admin/sass/dark-theme.css') }}?v={{ $assetVersion }}" rel="stylesheet">
{{-- <link href="{{asset('admin/sass/blue-theme.css')}}" rel="stylesheet"> --}}
<link href="{{ asset('admin/sass/semi-dark.css') }}?v={{ $assetVersion }}" rel="stylesheet">
{{-- <link href="{{asset('admin/sass/bordered-theme.css')}}" rel="stylesheet"> --}}
<link href="{{ asset('admin/sass/responsive.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<link href="{{ asset('admin/assets/css/main.css') }}?v={{ $assetVersion }}" rel="stylesheet">
<link rel="stylesheet"
    href="{{ asset('admin/assets/plugins/notifications/css/lobibox.min.css') }}?v={{ $assetVersion }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@isset($extraCss)
    @foreach ($extraCss as $css)
        <link href="{{ asset($css) }}" rel="stylesheet">
    @endforeach
@endisset
@php
    $path = Request::path();

    $dir_path = public_path() . '/assets/css/' . $path;
    if (is_dir($dir_path)) {
        $directory = new DirectoryIterator($dir_path);

        // Loop runs while directory is valid
        while ($directory->valid()) {
            // Check the file is not directory
            if (!$directory->isDir()) {
                // Display the filename
                //echo $directory->getFilename() . "<br>";
                $filename = url('assets/css/' . $path . '/' . $directory->getFilename());
                echo '<link class="js-stylesheet" href="' . $filename . '?v=' . $assetVersion . '" rel="stylesheet">';
            }

            // Move to the next element
            $directory->next();
        }
    }
@endphp
@stack('styles')
