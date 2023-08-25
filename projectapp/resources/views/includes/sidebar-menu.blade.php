  <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          
		  <li class="nav-item {{ setactive_custom('admin/dashboard', 'active') }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
		   @if(Auth::user()->hasRole('candidate'))
			<li class="nav-item {{ setactive_custom('admin/events/my-events', 'active') }}">
            <a class="nav-link" href="{{ route('admin.events') }}/my-events">
			  <i class="menu-icon mdi mdi-floor-plan"></i>
			  <span class="menu-title">My Events</span>
            </a>
          </li>
		    @endif 
			@if(Auth::user()->hasRole('event_admin'))
			<li class="nav-item nav-category">User Settings</li>
          <li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#user-options" aria-expanded="false" aria-controls="user-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Users</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="user-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item  {{ setactive_custom('admin/users/evaluator', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/evaluator">Evaluators</a></li>
              </ul>
            </div>
          </li> 
		  <li class="nav-item nav-category">Other Settings</li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#department-options" aria-expanded="false" aria-controls="department-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Departments</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="department-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/department/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.department') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/department', 'active') }}"> <a class="nav-link" href="{{ route('admin.department') }}">List</a></li>
              </ul>
            </div>
          </li>
		  <li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#posts-options" aria-expanded="false" aria-controls="posts-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Posts</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="posts-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/post/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.post') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/post', 'active') }}"> <a class="nav-link" href="{{ route('admin.post') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#country-options" aria-expanded="false" aria-controls="country-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Country</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="country-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/country/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.country') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/country', 'active') }}"> <a class="nav-link" href="{{ route('admin.country') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#state-options" aria-expanded="false" aria-controls="state-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">State</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="state-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/state/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.state') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/state', 'active') }}"> <a class="nav-link" href="{{ route('admin.state') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#city-options" aria-expanded="false" aria-controls="city-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">City</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="city-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/city/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.city') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/city', 'active') }}"> <a class="nav-link" href="{{ route('admin.city') }}">List</a></li>
              </ul>
            </div>
          </li>
		    @endif
		    @if(Auth::user()->hasRole('super_admin'))
          <li class="nav-item nav-category">User Settings</li>
          <li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#user-options" aria-expanded="false" aria-controls="user-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Users</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="user-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item  {{ setactive_custom('admin/users/event_admin', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/event_admin">Event Admins</a></li>
                <li class="nav-item  {{ setactive_custom('admin/users/evaluator', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/evaluator">Evaluators</a></li>
                <li class="nav-item {{ setactive_custom('admin/users/candidate', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/candidate">Candidates</a></li>
                <li class="nav-item {{ setactive_custom('admin/users/hr_manager', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/hr_manager">Hr Manager</a></li>
                <li class="nav-item {{ setactive_custom('admin/users/interviewer', 'active') }}"> <a class="nav-link" href="{{ route('admin.users') }}/interviewer">Interviewer</a></li>
              </ul>
            </div>
          </li> 
		  <li class="nav-item nav-category">Comapny Settings</li>
          <li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#company-options" aria-expanded="false" aria-controls="company-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Company</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="company-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/company/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.company') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/company', 'active') }}"> <a class="nav-link" href="{{ route('admin.company') }}/">List</a></li>
              </ul>
            </div>
          </li> 
		  <li class="nav-item nav-category">Event Settings</li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#event-options" aria-expanded="false" aria-controls="event-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Events</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="event-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/events/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.events') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/events', 'active') }}"> <a class="nav-link" href="{{ route('admin.events') }}">List</a></li>
              </ul>
            </div>
          </li>
		  	<li class="nav-item nav-category">Other Settings</li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#department-options" aria-expanded="false" aria-controls="department-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Departments</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="department-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/department/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.department') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/department', 'active') }}"> <a class="nav-link" href="{{ route('admin.department') }}">List</a></li>
              </ul>
            </div>
          </li>
		  <li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#posts-options" aria-expanded="false" aria-controls="posts-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Posts</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="posts-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/post/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.post') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/post', 'active') }}"> <a class="nav-link" href="{{ route('admin.post') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#country-options" aria-expanded="false" aria-controls="country-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">Country</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="country-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/country/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.country') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/country', 'active') }}"> <a class="nav-link" href="{{ route('admin.country') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#state-options" aria-expanded="false" aria-controls="state-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">State</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="state-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/state/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.state') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/state', 'active') }}"> <a class="nav-link" href="{{ route('admin.state') }}">List</a></li>
              </ul>
            </div>
          </li>
			<li class="nav-item nav_item_main">
            <a class="nav-link" data-bs-toggle="collapse" href="#city-options" aria-expanded="false" aria-controls="city-options">
              <i class="menu-icon mdi mdi-floor-plan"></i>
              <span class="menu-title">City</span>
              <i class="menu-arrow"></i> 
            </a>
            <div class="collapse" id="city-options">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ setactive_custom('admin/city/add', 'active') }}"> <a class="nav-link" href="{{ route('admin.city') }}/add">Add</a></li>
                <li class="nav-item {{ setactive_custom('admin/city', 'active') }}"> <a class="nav-link" href="{{ route('admin.city') }}">List</a></li>
              </ul>
            </div>
          </li>
		   @endif
          
        </ul>
      </nav>
    