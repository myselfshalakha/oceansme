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
		    Oceans ME is a leading Project Management Company in Dubai, UAE. We operate across the Middle East and work closely with leading companies and their brand positioning. We offer end-to-end project planning solutions for all types of Corporate projects and MICE (Meetings, Incentives, Conferences and Exhibitions) along with a wide variety of services, professional skills and expertise to ensure every project we undertake is a success.
		 </span>
	  </div>
	  
	  <div class="col-md-5 col-12 banner-right">
	    <h5>What’s New</h5>
		  <div class="textwidget custom-html-widget banner-right-widget">
			@if(isset($events) && !empty($events))
		  	<div class="event_slider">
                @foreach($events as $event)
		     <a href="{{ route('candidate.registerview',['param'=>$event->id]) }}" class="banner-widget-link" target="_blank">
			    <div class="widget-inner">
				@if(isset($event) && !empty($event->featured_image))
					<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"> 
				@else
				<img src="{{ asset('/assets/images/frontpage/explora_gold_logo.png') }}">
				@endif
				<p class="banner-widget-para">Click Here to Register.</p>
				</div>
			 </a>
			 	@endforeach
			</div>
            @endif
		  </div>
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

<!---- popular searches starts--->
<div class="popular-searches">
	<section class="popular-searches-container">
		<div class="container">
			<h2 class="choose-heading">Popular Searches</h2>
			<div class="search-list">
			 @if(isset($departments) && !empty($departments))
				  @foreach($departments as $deps) 
				     <div class="pill">
							 <label class="pill-label">
							 <a target="_blank" href="{{ route('home.department',['param'=>$deps->id] )}}">{{ $deps->name }}</a>
							 </label>
					</div>
					<!----<div class="pill"><label class="pill-label"><a target="_blank" href="#">Freshers</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">IT</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">JAVA</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">HR executive</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Manual testing</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Work from home jobs</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Software engineer</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Business analyst</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Accounting</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Devops engineer</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Data analyst</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Sales</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Banking</a></label></div>
					<div class="pill"><label class="pill-label"><a target="_blank" href="#">Digital Marketing</a></label></div>--->
					@endforeach
				 @endif	
			</div>
		</div>
	</section>
</div>

<!--- popular searches ends --->

<!----Why Choose Us---->
<div class="Choose">
  <section class="choose-container">
   <div class="container">
     <div class="row">
	 
	    <div class="col-md-8 col-md-offset-2 choose-us-heading">
		   <h2 class="choose-heading">WHY CHOSE US</h2>
		</div>
		
		<div class="choose-features-content">
		  <div class="row">
		  
		     <div class="col-xs-12 col-md-4 choose-feature-box">
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
			 </div>
			 
		  </div>
		</div>
	 </div>
   </div>
  </section>
</div>
<!----- Why Choose Us ends Here----->

<!--- Services ---->
<div class="services">
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
</div>
<!--- Services Ends Here ---->


<!---- Projects ----->
<div class="Projects">
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
</div>
<!---- Projects Ends Here----->

<!---- Contact-Us ---->
<div class="Contact-Us" style = "background-image: url({{ asset('/assets/images/frontpage/contact.jpg')}})">
  <div class="Contact-Us-container">
    <div class="container">
     <div class="row">
	    
		<div class="col-md-5 Contact-Us-heading">
		   <h2 class="Contact-Us-head">Get in Touch</h2>
		   <h5 class="Contact-Us-description">You need more information about us?</h5>
		</div>
		
		<div class="col-md-5 ol-md-offset-2 Contact-Us-form">
		<!--Section: Contact v.2-->
        <section class="card">
		
		<div class="contact-form-heading">
		<h4 class="card-title">Contact Us</h4>
		</div>
		
		<div class="contact-form-card">  
        <div class="row">
        <!--Grid column-->
        <div class="col-12">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="name" name="name" class="form-control">
                            <label for="name" class=""> Your Name (required)</label>
                        </div>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="email" name="email" class="form-control">
                            <label for="email" class="">Your email (required)</label>
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="subject" name="subject" class="form-control">
                            <label for="subject" class="">Subject</label>
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">

                        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                            <label for="message">Your message</label>
                        </div>

                    </div>
                </div>
                <!--Grid row-->

            </form>

            <div class="text-center text-md-left">
                <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
            </div>
            <div class="status"></div>
        </div>
        <!--Grid column-->


    </div>
  </div>
</section>
<!--Section: Contact v.2-->
		</div>
		
	 </div>
	</div>
  </div>
</div>
<!---- Contact-Us ---->


@endsection

