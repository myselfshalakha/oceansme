<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('/assets/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}" />
  <link href="{{ asset('/assets/css/custom-login.css') }}" rel="stylesheet">
</head>
<body class="{{$view_name}}">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
				@yield('content')
				
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
	  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ asset('/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('/assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('/assets/js/template.js') }}"></script>
  <script src="{{ asset('/assets/js/settings.js') }}"></script>
  <script src="{{ asset('/assets/js/todolist.js') }}"></script>
     <script type="text/javascript" src="{{ asset('/assets/js/form-builder.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/assets/js/form-render.min.js') }}"></script>
  @yield('footer')
</div>
</body>
</html>
