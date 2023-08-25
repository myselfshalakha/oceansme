@extends('layouts.app')
@section('content') 
<?php
$tabArr=["details","add_fields","hr_manager","interviewer"];
$activeTab="details";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        ['name', 'start_date', 'end_date', 'featured_image', 'company', 'eventadmin'], 
        [], 
        ['firstname', 'lastname', 'email', 'gender', 'contactno'],
        ['firstname', 'lastname', 'email', 'gender', 'contactno']
    ];
    foreach ($fields_tabs as $tab => $fields) {
        foreach ($fields as $field) {
            if ($errorsArr->has($field)) {
                $activeTab = $tabArr[$tab];
                break;
            }
        }
    }
}
?>
<div class="container">
	<div class="row">
	  <div class="col-lg-12 grid-margin stretch-card">
				  <div class="card">
					<div class="card-body">
					  <div class="template-demo">
						<div class="btn-group">
						  <button type="button" class="btn btn-primary">Events Settings</button>
						  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
							<a class="dropdown-item" href="{{ route('admin.events') }}/add">Add</a>
							<a class="dropdown-item" href="{{ route('admin.events') }}">List</a>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
		</div>
		<div class="col-md-12 header_response_messege">
			@if ($errors->any())
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
			@endif
			@if(session()->has('success'))
				<div class="alert alert-success">
					{{ session()->get('success') }}
				</div>
			@endif
			@if(session()->has('error'))
				<div class="alert alert-danger">
					{{ session()->get('error') }}
				</div>
			@endif
		</div>
	<div class="col-md-12">
		<nav>
		  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			<button class="nav-link @if( $activeTab=='details') active @endif" id="nav-details-tab" data-bs-toggle="tab" data-bs-target="#nav-details" type="button" role="tab" aria-controls="nav-details" @if( $activeTab=='details') aria-selected="true" @else aria-selected="false" @endif>Event Details</button>
			<button class="nav-link @if( $activeTab=='add_fields') active @endif" id="nav-add_fields-tab" data-bs-toggle="tab" data-bs-target="#nav-add_fields" type="button" role="tab" aria-controls="nav-add_fields" @if( $activeTab=='add_fields') aria-selected="true" @else aria-selected="false" @endif>Additional Feilds</button>
			<button class="nav-link @if( $activeTab=='hr_manager') active @endif" id="nav-hr_manager-tab" data-bs-toggle="tab" data-bs-target="#nav-hr_manager" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='hr_manager') aria-selected="true" @else aria-selected="false" @endif>Hr Manager</button>
			<button class="nav-link @if( $activeTab=='interviewer') active @endif" id="nav-interviewer-tab" data-bs-toggle="tab" data-bs-target="#nav-interviewer" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='interviewer') aria-selected="true" @else aria-selected="false" @endif>Interviewer</button>
		 </div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
		  <div class="tab-pane fade @if( $activeTab=='details') show active @endif" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
				  <div class="card">
						<div class="card-header">Event Details</div>
						 <div class="card-body">
				  <div class="row event_info">
                    <div class="col-md-6">
                      <div class="card-description featured_image">
						  @if(isset($event) && !empty($event->featured_image))
						<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"> 
						@else
						<img src="{{ asset('/assets/images/frontpage/explora_gold_logo.png') }}">
						@endif
					  </div>
                    </div>
                    <div class="col-md-6">
                      <address class="text-primary">
                        <p class="fw-bold">
                          Event Name: 
                        </p>
                        <p class="mb-2">
						{{ $event->name }} 
							<?php echo get_event_status_badge($event->status) ?>
						
                        </p>
						<p class="fw-bold">
                          Company
                        </p>
                        <p class="mb-2">
						{{ \App\Models\Company::find($event->company_id	)->name }} 
                        </p>
						<p class="fw-bold">
                          Start Date
                        </p>
                        <p class="mb-2">
						{{ date('d M,Y',strtotime($event->start_date)) }}
                        </p>
						<p class="fw-bold">
                          End Date
                        </p>
                        <p class="mb-2">
						{{ date('d M,Y',strtotime($event->end_date)) }}
                        </p>
                        @if(!empty($event->restrictedExperience))
						<p class="fw-bold">
                          Experience Required
                        </p>
                        <p class="mb-2">
						{{ $event->restrictedExperience }} years of experience
                        </p>
						@endif		
						
						<p class="fw-bold">
                          Keys
                        </p>
                        <p>
						<?php
							$postname="";
							$requiredPosts=array();
							if(!empty($event->post_id)){
								$requiredPosts=\App\Models\Posts::whereIn("id",unserialize($event->post_id))->get();
								foreach($requiredPosts as $post){
									$postname.= $post->name . ", ";
								}
							}
						$postname=rtrim($postname, ", ");
						?>
						{{$postname}}
                        </p>
                      </address>
                    </div>
                    <div class="col-md-12">
					 <div class="card-body">
					  <h4 class="card-title">Description</h4>
					  <div class="card-description">
						 {{$event->description ?? "n/a"}} 
					  </div>
					  
					</div>
					</div>
                  </div>
				</div>

						</div>
			  
		  </div>
		  <div class="tab-pane fade @if( $activeTab=='add_fields') show active @endif" id="nav-add_fields" role="tabpanel" aria-labelledby="nav-add_fields-tab">
				  <div class="card">
						<div class="card-header">Additional fields</div>

						<div class="card-body">
							<div class="row">
							<div class="col-12">
							<div class="event-form-build-wrap form-wrapper-div" id="event-form-build-wrap"></div>

							</div>
							</div>
						</div>
					</div>
			  
		  </div>  
		  <div class="tab-pane fade @if( $activeTab=='hr_manager') show active @endif" id="nav-hr_manager" role="tabpanel" aria-labelledby="nav-hr_manager-tab">
				  <div class="card">
						<div class="card-header">Hr Manager</div>

						<div class="card-body">
									<div class="row">
							  <div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-striped">
								  <thead>
									<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									</tr>
								  </thead>
								  <tbody>
									@if(isset($event_team) && !empty($event_team))
									@foreach($event_team as $user)
									@if($user->role_id=="6")
									@continue
									@endif
										<tr>
											<td>{{ $user->name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{\App\Models\Role::find($user->role_id)->name ?? "n/a"}}</td>
										</tr>
									@endforeach
								@else
										<tr><td colspan="3">n/a</td></tr>
								@endif
								  </tbody>
								</table>
								
						  </div>
					  
							  </div>
							</div>	
						</div>
					</div>
			  
		  </div>
		 <div class="tab-pane fade @if( $activeTab=='interviewer') show active @endif" id="nav-interviewer" role="tabpanel" aria-labelledby="nav-interviewer-tab">
				  <div class="card">
						<div class="card-header">Interviewer</div>

						<div class="card-body">
									<div class="row">
							  <div class="col-sm-12">
								 <div class="accordion" id="interViewerAccordian">
								  <a href="javascript:void(0)" class="intervieweraccordian_tab @if( $activeTab!='interviewer') collapsed @endif"  type="button" data-toggle="collapse" data-target="#collapseinterviewer" aria-expanded="false" aria-controls="collapseinterviewer">
									  Add Interviewer
								  </a>
									<div id="collapseinterviewer" class="collapse @if( $activeTab=='interviewer') show @endif" aria-labelledby="headingThree" data-parent="#interViewerAccordian">
										 <form method="POST" action="{{ route('admin.users') }}/interviewer/save">
											@csrf
															<input type="hidden" name="event_id" value="{{ $event->id }}"> 
											 <input type="hidden" name="company_id" value="{{ $event->company_id }}"> 											<div class="row mb-3">
												<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('FirstName') }}<span class="required_star">*</span></label>

												<div class="col-md-6">
													<input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

													@error('firstname')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>   
											<div class="row mb-3">
												<label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('LastName') }}<span class="required_star">*</span></label>

												<div class="col-md-6">
													<input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

													@error('lastname')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											
											<div class="row mb-3">
												<label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}<span class="required_star">*</span></label>

												<div class="col-md-6 d-flex">
													<div class="custom-control custom-radio custom-control-inline px-2">
													  <input type="radio" id="genderm" name="gender" value="male" class="form-check-input @error('gender') is-invalid @enderror" required autocomplete="gender" checked>
													  <label class="custom-control-label" for="genderm">Male</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline px-2">
													<input id="genderw" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="female" required autocomplete="gender">
													  <label class="custom-control-label" for="genderw">Female</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline px-2">
													 <input id="gendero" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="others" required autocomplete="gender">

													  <label class="custom-control-label" for="gendero">OTHERS</label>
													</div>

													@error('gender')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}<span class="required_star">*</span></label>

												<div class="col-md-6">
													<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

													@error('email')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>

											<div class="row mb-3">
												<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}<span class="required_star">*</span></label>

												<div class="col-md-6">
													<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

													@error('password')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											  <div class="row mb-3">
												<label for="contactno" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>

												<div class="col-md-6">
													<input id="contactno" type="text" class="form-control @error('contactno') is-invalid @enderror" name="contactno" value="{{ old('contactno') }}" autocomplete="contactno">

													@error('contactno')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>  
											<div class="row mb-3" style="display:none">
												<label for="whatsapp" class="col-md-4 col-form-label text-md-end">{{ __('Whatsapp') }}</label>

												<div class="col-md-6">
													<input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" autocomplete="whatsapp">

													@error('whatsapp')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											  <div class="row mb-0 submit_btn_row">
												<div class="col-md-12 d-flex">
													<button type="submit" class="btn btn-primary">
														Submit
													</button> 
												</div>  
											</div>
										 
										</form>
					
									</div>
								</div>
							<div class="table-responsive">
								<table class="table table-striped">
								  <thead>
									<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>Action</th>

									</tr>
								  </thead>
								  <tbody>
									@if(isset($event_team) && !empty($event_team))
									@foreach($event_team as $user)
									@if($user->role_id=="5")
									@continue
									@endif
										<tr>
											<td>{{ $user->name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{\App\Models\Role::find($user->role_id)->name ?? "n/a"}}</td>
											<td class="td-action-icons">
											<span class="delete_record btn-danger h3" data-id="{{$user->id}}" data-action="{{ route('admin.users') }}/event_admin/delete"><i class="menu-icon mdi mdi-delete"></i></span>
											</td>
										</tr>
									@endforeach
								@else
										<tr><td colspan="4">n/a</td></tr>
								@endif
								  </tbody>
								</table>
								
						  </div>
					  
							  </div>
							</div>	
						</div>
					</div>
			  
		  </div>
		 </div>
		 </div>
	</div>
</div>
@endsection

@section('footer')
<?php
$formdata=[];
if(isset($event->form_elements) && !empty($event->form_elements)){
	$formdata=json_encode(unserialize($event->form_elements));
?>
		<script>
		
		
    jQuery(function() {

  var code = document.getElementById("event-form-build-wrap");
  var formData ='<?php echo $formdata ?>';	
   var addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");

  var $markup = $("<div/>");
  $markup.formRender({ formData });

  code.innerHTML = addLineBreaks($markup.formRender("html")); 

});
		
	</script>
<?php
}
?>
@endsection
