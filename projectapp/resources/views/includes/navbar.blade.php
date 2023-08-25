<!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="{{ url('/') }}">
            <img src="{{ asset('/assets/images/site-logo.png') }}"  />
          </a>
          <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
            <img src="{{ asset('/assets/images/site-logo.png') }}"  />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Hi, <span class="text-black fw-bold">{{ Auth::user()->name }}</span> 
			</h1>
            <h4 class="welcome-sub-text">You are logged in as 
			@if(Auth::user()->hasRole('super_admin'))
			 <span class="badge badge-primary">Super Admin</span>
			@elseif(Auth::user()->hasRole('event_admin'))
			<span class="badge badge-primary">Event Admin</span>
			@elseif(Auth::user()->hasRole('evaluator'))
			<span class="badge badge-primary">Evaluator</span>
			@elseif(Auth::user()->hasRole('candidate'))
			<span class="badge badge-primary">Candidate</span>
			@elseif(Auth::user()->hasRole('hr_manager'))
			<span class="badge badge-primary">Hr Manager</span>
			@elseif(Auth::user()->hasRole('interviewer'))
			<span class="badge badge-primary">Interviewer</span>
			@elseif(Auth::user()->hasRole('subscriber'))
			<span class="badge badge-primary">Subscriber</span>
			@endif
			</h4>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
			<li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
			@if(!empty(Auth::user()->profileimage))
				<img src="{{ url('/') }}/assets/images/userprofile/{{Auth::user()->profileimage}}" class="img-xs rounded-circle">
			@else 
				<img src="{{ url('/') }}/assets/images/user-image.png" class="img-xs rounded-circle">
			@endif
			</a>			
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
			@if(!empty(Auth::user()->profileimage))
				<img src="{{ url('/') }}/assets/images/userprofile/{{Auth::user()->profileimage}}" class="img-xs rounded-circle" >
			@else 
				<img src="{{ url('/') }}/assets/images/user-image.png"  class="img-xs rounded-circle" >
			@endif 
                <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
              </div>
              <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <form id="logout-form" action="{{ route('logout') }}" method="POST" class=""> @csrf</form><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
   