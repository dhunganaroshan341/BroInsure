<!--start footer-->
<footer class="page-footer">
    <p class="mb-0">IMs all rights reserved - rd-bishal </p>
</footer>
<!--end footer-->


<!--start switcher-->

<!--bootstrap js-->

<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!--plugins-->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<!--plugins-->
{{--
<script src="{{asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/metismenu/metisMenu.min.js') }}"></script>
{{--
<script src="{{asset('admin/assets/plugins/apexchart/apexcharts.min.js')}}"></script> --}}
<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
{{--
<script src="{{asset('admin/assets/plugins/peity/jquery.peity.min.js')}}"></script> --}}

<script src="{{ asset('admin/assets/js/c.main.js') }}?v={{ $assetVersion }}"></script>
<script src="{{ asset('admin/assets/js/main.js') }}?v={{ $assetVersion }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('admin/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
<!-- <script src="assets/plugins/notifications/js/notifications.min.js') }}"></script> -->
{{--
<script src="{{ asset('admin/assets/plugins/notifications/js/notification-custom-script.js') }}"></script> --}}
@isset($extraJs)
@foreach ($extraJs as $js)
<script src="{{ asset($js) }}?v={{ $assetVersion }}"></script>
@endforeach
@endisset
@php
$path = Request::path();
$dir_path = public_path() . '/assets/js/' . $path;
if (is_dir($dir_path)) {
$directory = new DirectoryIterator($dir_path);

// Loop runs while directory is valid
while ($directory->valid()) {
// Check the file is not directory
if (!$directory->isDir()) {
// Display the filename
//echo $directory->getFilename() . "<br>";
$filename = url('assets/js/' . $path . '/' . $directory->getFilename());
echo '
<script src="' . $filename .'?v=' . $assetVersion . '"></script>';
}

// Move to the next element
$directory->next();
}
}
@endphp
@stack('scripts')