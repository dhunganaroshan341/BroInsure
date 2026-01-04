<!doctype html>
<html lang="en" data-bs-theme="blue-theme">


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/auth-basic-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2024 06:17:31 GMT -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Insurance Login</title>
  <!--favicon-->
	<link rel="icon" href="{{asset('admin/assets/images/favicon-32x32.png')}}" type="image/png">
  <!-- loader-->
	<link href="{{asset('admin/assets/css/pace.min.css')}}" rel="stylesheet">
	<script src="{{asset('admin/assets/js/pace.min.js')}}"></script>

  <!--plugins-->
  <link href="{{asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/plugins/metismenu/metisMenu.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/plugins/metismenu/mm-vertical.css')}}">
  <!--bootstrap css-->
  <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="{{asset('admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
  <link href="{{asset('admin/sass/main.css')}}" rel="stylesheet">
  {{-- <link href="{{asset('admin/sass/dark-theme.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('admin/sass/blue-theme.css')}}" rel="stylesheet"> --}}
  <link href="{{asset('admin/sass/responsive.css')}}" rel="stylesheet">

  </head>

  <body>

    <!--authentication-->
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
      <div class="container-fluid my-5 my-lg-0">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                <div class="d-flex justify-content-center pb-1">

                  <img src="{{asset('admin/assets/images/igi-logo.png')}}" class="mb-4 " width="145" alt="">
                </div>
                  <h4 class="fw-bold">Insurnace Login</h4>
                  
                  <div class="form-body my-5">
										<form class="row g-3" method="post" action="{{route('login.store')}}">
                      @csrf
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email</label>
												<input type="email" class="form-control" id="inputEmailAddress" placeholder="jhon@example.com" name="email" required>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password" name="password" required> 
                          <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="#">Forgot Password ?</a>
											</div>
                      @if ($errors->any())
                  @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                              {{ $error }}
                        </div>
                 @endforeach
             @endif
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-grd-primary">Login</button>
												</div>
											</div>
										</form>
									</div>

              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
    </div>
    <!--authentication-->


    <!--plugins-->
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>

    <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
      });
    </script>
  
  </body>

<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/auth-basic-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Jun 2024 06:17:31 GMT -->
</html>