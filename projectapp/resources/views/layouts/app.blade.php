<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'OceansMe BackOffice') }}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('/assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  
  <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/assets/vendors/datepicker/datepicker.css') }}">

  <link rel="stylesheet" href="{{ asset('/assets/js/select.dataTables.min.css') }}">
  
 <link rel="stylesheet" href="{{ asset('/assets/vendors/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
  <!-- End plugin css for this page -->
  
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('/assets/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  
  <!--link
		href=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
		rel="stylesheet"-->

	
  <!-- messenger -->
   <link href="{{ asset('/assets/vendors/messenger/messenger.css') }}" rel="stylesheet">
   <link href="{{ asset('/assets/vendors/messenger/messenger-theme-flat.css') }}" rel="stylesheet">
  <!-- endmessenger -->
	  
	
  <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

  <link href="{{ asset('/assets/vendors/data-table/datatables.min.css') }}" rel="stylesheet">
  
    <link rel="stylesheet" href="{{ asset('/assets/vendors/datepicker/datepicker.css') }}">

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <link href="{{ asset('/assets/css/custom-admin.css') }}" rel="stylesheet">
</head>
<?php
$bodyroleclass="role_";
if(Auth::user()->hasRole('super_admin')){
$bodyroleclass=$bodyroleclass."super_admin";	
}elseif(Auth::user()->hasRole('event_admin')){
	$bodyroleclass=$bodyroleclass."event_admin";	

}
elseif(Auth::user()->hasRole('evaluator')){
	$bodyroleclass=$bodyroleclass."evaluator";	

}
elseif(Auth::user()->hasRole('candidate')){
	$bodyroleclass=$bodyroleclass."candidate";	

}
elseif(Auth::user()->hasRole('hr_manager')){
	$bodyroleclass=$bodyroleclass."super_admin";	

}
elseif(Auth::user()->hasRole('interviewer')){
	$bodyroleclass=$bodyroleclass."interviewer";	

}
elseif(Auth::user()->hasRole('subscriber'))
{
	$bodyroleclass=$bodyroleclass."subscriber";	

}
?>
<body  class="{{$bodyroleclass}}  {{$view_name}}">
  <div class="container-scroller">
	@auth
		@include('includes.navbar')
	@endauth
   <!-- partial -->
    <div class="container-fluid page-body-wrapper">
	@auth
		@include('includes.sidebar-menu')
	@endauth
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
		 <!-- HTML --> 
		 @if(Auth::user()->hasRole('candidate') && !Auth::user()->hasVerifiedEmail())
										
			<div class="row">
					<div class="col-lg-12 d-flex flex-column">
						<div class="card">
						<div class="card-header">Email Verification <span class="badge badge-warning">Pending</span>
						</div>
						
						<div class="card-body">
							<div class="rounded">						
								

								Before proceeding, please check your email for a verification link. If you did not receive the email,
								<form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
									@csrf
									<button type="submit" class="d-inline btn btn-link p-0">
										click here to request another
									</button>.
									@if (session('resent'))
									<div class="text-success" role="alert">
										A fresh verification link has been sent to your email address.
									</div>
									@endif 
								</form>
							</div>
						</div>
					</div>		
				</div>
			</div>
		
		@endif
			@yield('content')
		</div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Oceans ME</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

<script>
var resumePlaceholder='{{ asset("/assets/files/user/resume/resume-placeholder.gif") }}';
</script>
 <script src="{{ asset('/assets/vendors/bootstrap/jquery.slim.min.js') }}"></script>
 <script src="{{ asset('/assets/vendors/bootstrap/popper.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/assets/vendors/bootstrap/bootstrap.min.js') }}"></script>
  
   <!-- plugins:js -->
  <script src="{{ asset('/assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
    <script src="{{ asset('/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
  <!-- Plugin js for this page -->
  
  
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="{{ asset('/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>





  <script src="{{ asset('/assets/vendors/chart-js/Chart.min.js') }}"></script>
  <script src="{{ asset('/assets/vendors/data-table/datatables.min.js') }}"></script>

  <script src="{{ asset('/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <script src="{{ asset('/assets/vendors/select2/select2.min.js') }}"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('/assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('/assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('/assets/js/template.js') }}"></script>
  <script src="{{ asset('/assets/js/settings.js') }}"></script>
  <script src="{{ asset('/assets/js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('/assets/js/Chart.roundedBarCharts.js') }}"></script>
  <!-- endinject -->
  
    <!--Message alert-->
    <script src="{{ asset('/assets/vendors/messenger/messenger.min.js') }}"></script>
    <script src="{{ asset('/assets/vendors/messenger/messenger-theme-flat.js') }}"></script>
    <script src="{{ asset('/assets/vendors/messenger/sweetalert2.all.min.js') }}"></script>
	
   <script type="text/javascript" src="{{ asset('/assets/js/canvasjs.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/assets/js/form-builder.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/assets/js/form-render.min.js') }}"></script>
   
   <!-- Doc Viewer  -->
   <script type="text/javascript" src="{{ asset('/assets/js/jquery.gdocsviewer.min.js') }}"></script>

   <!-- Custom Script  -->
    <script src="{{ asset('/assets/js/data-table.js') }}"></script>
    <script src="{{ asset('/assets/js/custom-admin.js') }}"></script>
	
	
	<!-- Custom Snippet Footer Inject  -->
	@yield('footer')
	
	
	<!-- Show Loader icon on load ajax  -->
	<div id="loading" style="display:none">
	  <img id="loading-image" src="{{ asset('/assets/images/loading.gif') }}" alt="Loading..." />
	</div>
	
</body>
</html>
