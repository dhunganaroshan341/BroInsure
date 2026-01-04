<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    @php
        $assetVersion = config('app.asset_version');
    @endphp
    @include('backend.layout.style')

</head>

<body>

    <!--start header-->
    @include('backend.layout.header')
    <!--end top header-->


    <!--start sidebar-->
    @include('backend.layout.sidebar')
    <!--end sidebar-->

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <noscript>
                <div class="noscript-popup">
                    <div class="message">
                        <strong class="text-danger">JavaScript is Disabled</strong>
                        <p>Please enable JavaScript in your browser settings for the best experience on this site.</p>
                        <p><strong>How to enable JavaScript:</strong></p>
                        <ul>
                            <li><strong>Google Chrome:</strong>
                                <ol>
                                    <li>Click on the three dots in the upper right corner.</li>
                                    <li>Select "Settings."</li>
                                    <li>Scroll down and click on "Privacy and security."</li>
                                    <li>Click on "Site settings."</li>
                                    <li>Scroll down to "JavaScript" and turn it on.</li>
                                </ol>
                            </li>
                            <li><strong>Mozilla Firefox:</strong>
                                <ol>
                                    <li>Type `about:config` in the address bar and press Enter.</li>
                                    <li>Accept the risk and continue.</li>
                                    <li>Search for `javascript.enabled`.</li>
                                    <li>Set it to `true` to enable JavaScript.</li>
                                </ol>
                            </li>
                            <li><strong>Microsoft Edge:</strong>
                                <ol>
                                    <li>Click on the three dots in the upper right corner.</li>
                                    <li>Select "Settings."</li>
                                    <li>Click on "Cookies and site permissions."</li>
                                    <li>Scroll down to "JavaScript" and turn it on.</li>
                                </ol>
                            </li>
                            <li><strong>Safari:</strong>
                                <ol>
                                    <li>Click "Safari" in the top menu, then select "Preferences."</li>
                                    <li>Go to the "Security" tab.</li>
                                    <li>Check the box that says "Enable JavaScript."</li>
                                </ol>
                            </li>
                        </ul>
                    </div>
            </noscript>
            {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Components</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
            </ol>
          </nav>
        </div>
      </div> --}}
            @yield('main')



        </div>
    </main>
    <!--end main wrapper-->

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    @include('backend.layout.footer-script')


</body>

</html>
