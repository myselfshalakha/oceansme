@extends('layouts.frontapp')
@section('content')
<!----- Banner---->
<div class="banner">
  <section class="banner-container">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="{{ asset('/assets/images/frontpage/banner-1.jpg') }}" alt="First slide">
	  
	  <div class="carousel-caption d-none d-md-block">
  <div class="banner-content">
    <div class="row banner-conent-part">
	
      <div class="col-md-7 col-12 banner-left">
	     <span class="banner-subtitle">
		   <!-- breadcrumb listing -->
		   <ul class="breadcrumb-listing">
			 <li class="breadcrumb_item"><a target="_blank" href="{{ route('home')}}">Home</a></li>>
			 <li class="breadcrumb_item"><a target="_blank" href="{{ route('home.department')}}">Department</a></li>>
			 <li class="breadcrumb_item">
			  <?php 
			   // extracted name
			     echo str_replace(Request::getPathInfo(),"jobevents",Request::getPathInfo());
				?>
				
			 </li>
			</ul>
		 </span> 
	  </div>
    </div>
  </div>
  </div>
  
    </div>
  </div>
</div>
</section>
</div>
<!----- Banner ends---->



<!--- Services ---->
<div class="services">
  <div class="services-container">
    <div class="container">
     <div class="row">
	    
		<div class="col-md-8 col-md-offset-2 services-heading">
		   <h2 class="services-head">Events</h2>
		</div>
		
		<div class="services-features-content">
		  <div class="row">
		     @if(isset($jobs) && !empty($jobs))
			  @foreach($jobs as $job) 
				<div class="col-xs-12 col-md-4 choose-feature-box">
				 <div class="features-content-box">
				 
				   <img src="{{ asset('/assets/images/frontpage/Private-Party-1.jpg') }}">
				   <p class="features-para">{{ $job->name }}</p>
				  
				 </div>
				</div>
			  @endforeach
			@endif
			
			 
		  </div>
		</div>
		
	 </div>
	</div>
  </div>
</div>
<!--- Services Ends Here ---->





@endsection

