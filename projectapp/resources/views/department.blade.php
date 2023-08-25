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
			 <li class="breadcrumb_item">
			 
			  <?php 
			   // extracted name
				echo str_replace(Request::getPathInfo(),"department",Request::getPathInfo());
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


<!----Why Choose Us---->
<div class="Choose">
  <section class="choose-container">
   <div class="container">
     <div class="row">
	 
	    <div class="col-md-8 col-md-offset-2 choose-us-heading">
		   <!--<h2 class="choose-heading">WHY CHOSE US</h2>-->
		   <h2 class="choose-heading">All Related Posts</h2>
		</div>
		
		<div class="choose-features-content">
		  <div class="row">
		     @if(isset($department) && !empty($department))
				  @foreach($department as $deps) 
				   <div class="col-xs-12 col-md-4 choose-feature-box">
					<div class="features-content-box">
					<a href="{{ route('home.jobevents',['param'=>$deps->id] )}}" class="banner-widget-link">
					 <img src="{{ asset('/assets/images/frontpage/event-1.png') }}">
					 <p class="features-para">{{ $deps->name }}</p>
					 </a>
					</div>
				   </div>
				 @endforeach
			 @endif	
		    <!-- <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-industry"></i></a>
				  <p class="features-para">Profoundly relevant Industry and vertical project Management experience</p>
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-money-bill-wave"></i></a>
				  <p class="features-para">Value for money with open and transparent processes</p>
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-briefcase"></i></a>
				  <p class="features-para">Understanding Business Drivers and spotting professionals to run that business</p>
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-tasks"></i></a>
				  <p class="features-para">Flexibility for effective and efficient execution</p>
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-users"></i></a>
				  <p class="features-para">Ability to interact with members of company and applicant community</p>
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 choose-feature-box">
			    <div class="features-content-box">
				  <a href="#" class="choose-icon-link"><i class="fas fa-brain"></i></a>
				  <p class="features-para">Creative and innovative solutions</p>
				</div>
			 </div>-->
			 
		  </div>
		</div>
	 </div>
   </div>
  </section>
</div>
<!----- Why Choose Us ends Here----->

<!--- Services ---->
<!---<div class="services">
  <div class="services-container">
    <div class="container">
     <div class="row">
	    
		<div class="col-md-8 col-md-offset-2 services-heading">
		   <h2 class="services-head">OUR SERVICES</h2>
		</div>
		
		<div class="services-features-content">
		  <div class="row">
		     
			 <div class="col-xs-12 col-md-4 services-feature-box">
			    <div class="features-content-box">
				  <p class="features-para">Private Parties</p>
				  <img src="{{ asset('/assets/images/frontpage/Private-Party-1.jpg') }}">
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 services-feature-box">
			    <div class="features-content-box">
				  <p class="features-para">Corporate Events</p>
				  <img src="{{ asset('/assets/images/frontpage/corporate-events.jpg') }}">
				</div>
			 </div>
			 
			 <div class="col-xs-12 col-md-4 services-feature-box">
			    <div class="features-content-box">
				  <p class="features-para">Career Days</p>
				  <img src="{{ asset('/assets/images/frontpage/Career-Days.jpg') }}">
				</div>
			 </div>
			 
		  </div>
		</div>
		
	 </div>
	</div>
  </div>
</div>---->
<!--- Services Ends Here ---->


<!---- Projects ----->
<!---- <div class="Projects">
  <div class="Projects-container">
    <div class="container">
     <div class="row">
	    
		<div class="col-md-8 col-md-offset-2 Projects-heading">
		   <h2 class="Projects-head">PROJECTS</h2>
		</div>
		
		<div class="Projects-features-content">
		  <div class="row">
		     
			 <div class="col-12 Projects-feature-box">
			    <div class="features-content-box">
				  <div class="projects-features-img">
				    <img src="{{ asset('/assets/images/frontpage/Corporate-Training.jpg') }}">
				  </div>
				  <div class="projects-features-content-box">
				    <h5 class="sub-title">Corporate Training</h5>
				    <p class="para para-1">Your business is unique. Therefore, we design and deliver learning solutions that address identified gaps in skills, knowledge and behaviour to maximise the performance of your Organisation. With a strong focus on results, we help your people develop core skills to grow their careers and your business.</p>
					<p class="para para-2">Great leaders build great Businesses; we help you build a solid foundation for your existing and future leaders. With end-to-end training sessions, we empower your team to grow your Business and engage your Customers.</p>
				  </div>
				</div>
			 </div>
			 
			<div class="col-12 Projects-feature-box">
			    <div class="features-content-box">
				  <div class="projects-features-img">
				    <img src="{{ asset('/assets/images/frontpage/Recruitment-Project.jpg') }}">
				  </div>
				  <div class="projects-features-content-box">
				    <h5 class="sub-title">Recruitment Project</h5>
				    <p class="para para-1">We treat your recruitment needs as a project and specialise in strategic positioning to meet your business needs.Being your dedicated project Partner, we are committed to cater to your manpower and skillset requirements in line with the Hospitality and Cruise Line Industry standards.</p>
				  </div>
				</div>
			 </div>
			 
			 <div class="col-12 Projects-feature-box">
			    <div class="features-content-box">
				  <div class="projects-features-img">
				    <img src="{{ asset('/assets/images/frontpage/Conference-Career-Day.jpg') }}">
				  </div>
				  <div class="projects-features-content-box">
				    <h5 class="sub-title">Conference & Career Day </h5>
				    <p class="para para-1">Our team has worked on Exhibitions and Conferences of every shape and size, and with many different objectives. Whether you are planning “Half-day Meetings of colleagues”, an “International Summit” flying delegates in from across the world, “Exhibitions” or “Career Days” likely to attract thousands of visitors, it can be a daunting experience.</p>
					<p class="para para-2">It is essential that all goes to plan and with our experience at planning and designing Exhibitions and Conferences, we will take the burden from your shoulders so you can concentrate elsewhere.</p>
				  </div>
				</div>
			 </div>
			 
		  </div>
		</div>
		
	 </div>
	</div>
  </div>
</div>----->
<!---- Projects Ends Here----->



@endsection

