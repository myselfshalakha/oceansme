<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- plugins:css -->
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/vendors/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/vendors/slick/slick.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('/assets/css/custom-front.css') }}" rel="stylesheet">
</head>
<body  class="{{$view_name}}">


<!----- Header---->
  <header class="header">
   <section class="container">
     <nav class="navbar navbar-expand-lg navbar-default navbar-fixed-top  hestia_center navbar-scroll-point">
  <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('/assets/images/frontpage/logo-brand.png') }}"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link nav-current" href="{{ url('/') }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Projects</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>
	   @guest
	   <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
      </li>
	  <!--li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">Register</a>
      </li-->
	
	  @else
		  
	<li class="nav-item">
		<div class="dropdown">
		  <a href="javascript:void(0)" class="nav-link dropdown-toggle" id="logindropdownItem" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-user"></i>
		  </a>
		  <div class="dropdown-menu" aria-labelledby="logindropdownItem">
			<a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <form id="logout-form" action="{{ route('logout') }}" method="POST" class=""> @csrf</form><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout</a>
		  </div>
		</div>
      </li>
	 @endguest
	  
    </ul>
    
	<div class="nav-social-icons">
	<div class="social-icons">
	  <div class="facebook-icon">
	    <i class="fab fa-facebook"></i>
	  </div>
	  
	  <div class="insta-icon">
	    <i class="fab fa-instagram"></i>
	</div>
	</div>
	</div>
	
  </div>
</nav>
   </section>
</header>
<!----- Header ends here---->
   
					@yield('content')
<!------ footer --->

<footer class="footer">
   <section class="footer-container">
     <div class="container">
	    <div class="row">
		
		   <div class="col-lg-3 col-md-6 col-12 footer-blocks">
		   <div class="features-content-box">
				<img src="{{ asset('/assets/images/frontpage/1in2-1.png') }}">
				<p class="features-para"><b>1 in every 2 Candidates</b></p>
				<p class="features-para">presented is selected for interview</p>
			</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-12 footer-blocks">
		   <div class="features-content-box">
				<img src="{{ asset('/assets/images/frontpage/candidatedatabase.png') }}">
				<p class="features-para"><b>10,000+ Candidate Database</b></p>
				<p class="features-para">of hospitality professionals=available</p>
			</div>
			</div>
		    
			<div class="col-lg-3 col-md-6 col-12 footer-blocks">
		   <div class="features-content-box">
				<img src="{{ asset('/assets/images/frontpage/femalecandidate.png') }}">
				<p class="features-para"><b>Female Candidates</b></p>
				<p class="features-para">with 5* hospitality background ready to relocate</p>
			</div>
			</div>
			
			<div class="col-lg-3 col-md-6 col-12 footer-blocks">
		   <div class="features-content-box">
				<img src="{{ asset('/assets/images/frontpage/screeningprocess.png') }}">
				<p class="features-para"><b>Quality Screening Process</b></p>
				<p class="features-para">Every candidate is screened in detail prior to being presented to client </p>
			</div>
			</div>
		
		</div>
	 </div> 
   </section>
</footer>

<!--- Footer ends here --->
		
    <!-- page-body-wrapper ends -->
	<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script-->

 <script src="{{ asset('/assets/vendors/bootstrap/jquery.slim.min.js') }}"></script>
 <script src="{{ asset('/assets/vendors/bootstrap/popper.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
 <script src="{{ asset('/assets/vendors/bootstrap/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/assets/vendors/slick/slick.js') }}"></script>
	<script src="{{ asset('/assets/js/custom-front.js') }}"></script>
</div>
</body>
</html>
