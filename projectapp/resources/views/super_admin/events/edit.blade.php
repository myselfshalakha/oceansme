@extends('layouts.app')
@section('content') 
<?php
$tabArr=["details","add_fields","interview_questions","hr_manager","interviewer","schedule"];
$activeTab="details";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        ['name', 'start_date', 'end_date', 'featured_image', 'company', 'eventadmin'], 
        [], 
		[],
        ['firstname', 'lastname', 'email', 'gender', 'contactno'],
        ['firstname', 'lastname', 'email', 'gender', 'contactno'],
        ['schedule', 'location']
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
			<button class="nav-link @if( $activeTab=='interview_questions') active @endif" id="nav-interview_questions-tab" data-bs-toggle="tab" data-bs-target="#nav-interview_questions" type="button" role="tab" aria-controls="nav-interview_questions" @if( $activeTab=='interview_questions') aria-selected="true" @else aria-selected="false" @endif>Interview Questions</button>
			<button class="nav-link @if( $activeTab=='hr_manager') active @endif" id="nav-hr_manager-tab" data-bs-toggle="tab" data-bs-target="#nav-hr_manager" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='hr_manager') aria-selected="true" @else aria-selected="false" @endif>Hr Manager</button>
			<button class="nav-link @if( $activeTab=='interviewer') active @endif" id="nav-interviewer-tab" data-bs-toggle="tab" data-bs-target="#nav-interviewer" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='interviewer') aria-selected="true" @else aria-selected="false" @endif>Interviewer</button>
			<button class="nav-link @if( $activeTab=='schedule') active @endif" id="nav-schedule-tab" data-bs-toggle="tab" data-bs-target="#nav-schedule" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='schedule') aria-selected="true" @else aria-selected="false" @endif>Schedule & Locations</button>

		</div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
		  <div class="tab-pane fade @if( $activeTab=='details') show active @endif" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
				  <div class="card">
						<div class="card-header">Event Details</div>
						<div class="card-body">
							<form action="{{route('admin.events',['param'=>'save'])}}" method="post"   enctype="multipart/form-data">
						
						
							{{csrf_field()}}
							@if(isset($event)) <input type="hidden" name="id" value="{{ $event->id }}"> @endif
							
							<div class="row mb-3">
								<label for="name" class="col-md-4 col-form-label text-md-end">Event Name<span class="required_star">*</span></label>
								<div class="col-md-6">
								<input type="text" name="name" class="form-control" placeholder="Event Name" value="@if(isset($event)) {{ $event->name }} @else{{ old('name') }}@endif">
								@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
								<label for="start_date" class="col-md-4 col-form-label text-md-end">Start Date<span class="required_star">*</span> </label>
								<div class="col-md-6">
								<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Event Start Date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@else{{ old('start_date') ??  old('start_date') ?? date('m/d/Y') }}@endif" autocomplete="off">
								@error('start_date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>	
							<div class="row mb-3">
								<label for="end_date" class="col-md-4 col-form-label text-md-end">End Date<span class="required_star">*</span></label>
								<div class="col-md-6">
								<input type="text" name="end_date" id="end_date" class="form-control" placeholder="Event End Date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->end_date)) }}@else{{ old('end_date') ??  old('end_date') ?? date('m/d/Y')  }}@endif"  autocomplete="off">
								@error('end_date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
								<label  class="col-md-4 col-form-label text-md-end">Featured Image</label>
								<div class="col-md-6">
									@if(isset($event) && !empty($event->featured_image))
									<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"  class="frm-img frm-featured-img"> 
									@endif
									<input type="file" name="featured_image" id="featured_image" class="form-control">
									@error('featured_image')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror

								</div>
							</div>
							<div class="row mb-3">
									<label for="departments" class="col-md-4 col-form-label text-md-end">Department</label>
									<div class="col-md-6">
									<?php
										$departmentname=array();
										if(!empty($event->dep_id)){
											$departmentname= unserialize($event->dep_id);
										}
									?>
									<select class="form-control" name="departments[]" id="ev_departments" data-action="{{route('admin.events',['param'=>'getpost_and_evls'])}}" multiple="multiple">
										@if(!empty($departments))
											@foreach($departments as $department)
												<option  value="{{ $department->id }}" @if(in_array($department->id,$depname)) selected @endif >{{$department->name}}</option>
											@endforeach
										@endif
									</select>
									@error('departments')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
									</div>
								</div>
							<div class="row mb-3">
								<label for="post" class="col-md-4 col-form-label text-md-end">Post</label>
								<div class="col-md-6">
								<?php
									$postname=array();
									if(!empty($event->post_id)){
										$postname= unserialize($event->post_id);
									}
								?>
								<select class="form-control" name="post[]" id="ev_post" multiple="multiple">
									@if(!empty($posts))
										@foreach($posts as $post)
											<option @if(in_array($post->id,$postname)) selected  @endif value="{{ $post->id }}">{{$post->name}}</option>
										@endforeach

									@endif
								</select>
								@error('post')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							
							<div class="row mb-3">
								<label for="restrictedCountries" class="col-md-4 col-form-label text-md-end">Restricted Countries</label>
								<div class="col-md-6">
								<?php
									$restrictedCountriesArr=array();
									if(!empty($event->restrictedCountries)){
										$restrictedCountriesArr= unserialize($event->restrictedCountries);
									}
								?>
								<select class="form-control" name="restrictedCountries[]" id="restrictedCountries" multiple="multiple">
									@if(!empty($countries))
										@foreach($countries as $country)
											<option @if(in_array($country->id,$restrictedCountriesArr)) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
										@endforeach

									@endif
								</select>
								@error('restrictedCountries')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
								<label for="company" class="col-md-4 col-form-label text-md-end">Company<span class="required_star">*</span></label>
								<div class="col-md-6">
								<select class="form-control" name="company" id="ev_company">
									@if(!empty($companies))
										@foreach($companies as $company)
											<option @if(isset($event) && $event->company_id == $company->id) selected  @endif value="{{ $company->id }}">{{$company->name}}</option>
										@endforeach

									@endif
								</select>
								@error('company')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
										<label for="minAge" class="col-md-4 col-form-label text-md-end">Age Required </label>
									<div class="row col-md-6">
										<div class="col">
										<input type="text" name="minAge" class="form-control" placeholder="Min Age. Ex: 20, 21 ..." value="@if(isset($event)){{ $event->minAge }}@else{{ old('minAge') }}@endif" >
										@error('minAge')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
										<div class="col">
										<input type="text" name="maxAge" class="form-control" placeholder="Max Exp. Ex: 0, 1.5 ..." value="@if(isset($event)){{ $event->maxAge }}@else{{ old('maxAge') }}@endif" >
										@error('maxAge')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>	
									</div>
							</div>	
							<div class="row mb-3">
										<label for="minExp" class="col-md-4 col-form-label text-md-end">Experience Required (years)  </label>
									<div class="row col-md-6">
										<div class="col">
										<input type="text" name="minExp" class="form-control" placeholder="Min Exp. Ex: 0, 1.5 ..." value="@if(isset($event)){{ $event->minExp }}@else{{ old('minExp') }}@endif" >
										@error('minExp')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
										<div class="col">
										<input type="text" name="maxExp" class="form-control" placeholder="Max Exp. Ex: 0, 1.5 ..." value="@if(isset($event)){{ $event->maxExp }}@else{{ old('maxExp') }}@endif" >
										@error('maxExp')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>	
									</div>
							</div>
							<div class="row mb-3">
								<label for="eventadmin" class="col-md-4 col-form-label text-md-end">Event Admin<span class="required_star">*</span></label>
								<div class="col-md-6">
								<select class="form-control" name="eventadmin" id="ev_eventadmin" required>
									@if(!empty($event_admins))
										@foreach($event_admins as $user)
											<option @if(isset($event) && $event->eventadmin_id == $user->id) selected  @endif value="{{ $user->id }}">{{$user->name}}</option>
										@endforeach

									@endif
								</select>
								@error('eventadmin')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
						<div class="row mb-3">
								<label for="evaluator" class="col-md-4 col-form-label text-md-end">Evaluator</label>
								<div class="col-md-6">
									<select class="form-control" name="evaluator[]" id="ev_evaluator" multiple="multiple">
									@if(!empty($evaluators))
										@foreach($evaluators as $user)
											@php
											$selected="";
											@endphp
											@if(!empty($event_evaluators))
												@foreach($event_evaluators as $item)
													@if($user->id==$item->id)
														@php
														$selected="selected";
														@endphp
													@endif
												@endforeach
											@endif
											<option value="{{ $user->id }}" {{$selected}}>{{$user->name}}</option>
										@endforeach

									@endif
									@if(!empty($evaluators))
										@foreach($evaluators as $user)
											@if(!empty($user->dep_id))
												<?php
													$selected="";
													$evlshow=false;
													$userdeps=unserialize($user->dep_id);
													foreach($depname as $dep){
														if(in_array($dep,$userdeps))
														{
															$evlshow=true;
															break;
														}
													}
												?>
													
														@if($evlshow==true)
														@if(!empty($event_evaluators))
																@if(in_array($user->id,$event_evaluators))
																	<?php
																	$selected="selected";
																	?>
																@endif
														@endif
														<option value="{{ $user->id }}" {{$selected}}>{{$user->name}}</option>
														@endif
													
											@endif
										@endforeach
									@endif
								</select>
								@error('evaluator')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
								<label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
								<div class="col-md-6">
								<textarea class="form-control" name="description" rows="10">@if(isset($event)) {{ $event->description }} @else{{ old('description') }}@endif</textarea>
								@error('description')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>
							</div>
							<div class="row mb-3">
								<label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
								<div class="col-md-6">
								<select class="form-control" name="status" id="ev_status">
								<?php
								$status=get_event_status();
								?>
									@if(!empty($status))
										@foreach($status as $k=>$v)
											<option @if(isset($event) && $event->status == $k) selected  @endif value="{{ $k }}">{{$v}}</option>
										@endforeach
									@endif
								</select>
								@error('status')
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
									<a href="{{ route('admin.events') }}" class="btn btn-secondary">
										Cancel
									</a>
								</div>  
							</div>
								
						</form>
								
						</div>
					</div>
			  
		  </div>
		  <div class="tab-pane fade @if( $activeTab=='add_fields') show active @endif" id="nav-add_fields" role="tabpanel" aria-labelledby="nav-add_fields-tab">
				  <div class="card">
						<div class="card-header">Additional fields</div>

						<div class="card-body">
							<div class="row">
							<div class="col-12">
							<div class="row">
							<div class="col-md-12 d-flex">
								<a href="{{ route('admin.events') }}/custom_form?id={{$event->id}}" class="btn btn-primary">
									Custom Fileds 
								</a>
							</div>  
							</div>
							</div>
							</div>
							<div class="row">
							<div class="col-12">
							<div class="event-form-build-wrap form-wrapper-div" id="event-form-build-wrap"></div>

							</div>
							</div>
						</div>
					</div>
			  
		  </div>  
		  <div class="tab-pane fade @if( $activeTab=='interview_questions') show active @endif" id="nav-interview_questions" role="tabpanel" aria-labelledby="nav-interview_questions-tab">
				  <div class="card">
						<div class="card-header">Interview Questions</div>

						<div class="card-body">
							<div class="row">
							<div class="col-12">
							<div class="row">
							
								<form action="{{route('admin.events',['param'=>'save_interview_questions'])}}" method="post">
								{{csrf_field()}}
								<input type="hidden" name="id" value="{{$event->id}}">
								<div class="row  questions_bank repouter">
									@if(isset($event) && !empty($event->interview_questions))
											<?php
											$i=1;
											foreach(unserialize($event->interview_questions) as $question){
												?>
													<div class="addonfields row mb-3 clscount{{$i}}">
													<div class="row mb-3">
														<label class="col-md-4 col-form-label text-md-end">Question<span class="required_star">*</span></label>
														<div class="col-md-6">
														<input type="text" name="interview_questions[]" class="form-control" placeholder="Question" value="{{$question['question']}}" required="">
														</div>
													</div>
														<a href="javascript:void(0)" class="actionremove col-12" data="{{$i}}">Remove</a>
													</div>
													<?php
													$i++;
											}
											?>
									@endif
									</div>
									<div class="row mb-3">
										<div class="col-md-12">
										 <a class="clonebut_abs" href="javascript:void(0);">(+) Add Questions</a>
										</div>
									</div>
									<div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											<a href="{{ route('admin.events',['param'=>'edit']) }}?id={{$event->id}}" class="btn btn-secondary">
												Cancel
											</a>
										</div>  
									</div>
								</form>
								<div class="repeat_html" style="display:none;">
									<div class="row mb-3">
									<label class="col-md-4 col-form-label text-md-end">Question<span class="required_star">*</span></label>
									<div class="col-md-6">
									<input type="text" name="interview_questions[]" class="form-control" placeholder="Question" value="" required>
									</div>
									</div>	
								
								</div>
							
							</div>
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
								 <div class="accordion" id="accordionExample">
								  <a href="javascript:void(0)" class="hr_manageraccordian_tab @if( $activeTab!='hr_manager') collapsed @endif"  type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									  Add Hr Manager
								  </a>
									<div id="collapseThree" class="collapse @if( $activeTab=='hr_manager') show @endif" aria-labelledby="headingThree" data-parent="#accordionExample">
										 <form method="POST" action="{{ route('admin.users') }}/hr_manager/save">
											@csrf
											 <input type="hidden" name="event_id" value="{{ $event->id }}"> 
											 <input type="hidden" name="company_id" value="{{ $event->company_id }}"> 
											<div class="row mb-3">
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
									<th>Action</th>

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
										
											<td class="td-action-icons"> 
											<a href="{{ route('admin.users') }}/hr_manager/edit?id={{$user->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
											<span class="delete_record btn-danger h3" data-id="{{$user->id}}" data-action="{{ route('admin.users') }}/hr_manager/delete"><i class="menu-icon mdi mdi-delete"></i></span>
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
											@if(isset($event)) <input type="hidden" name="event_id" value="{{ $event->id }}"> @endif
											<div class="row mb-3">
												<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('FirstName') }}<span class="required_star">*</span></label>
												<input type="hidden" name="event_id" value="{{ $event->id }}"> 
											 <input type="hidden" name="company_id" value="{{ $event->company_id }}"> 
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
											<a href="{{ route('admin.users') }}/event_admin/edit?id={{$user->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
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
		  <div class="tab-pane fade @if( $activeTab=='schedule') show active @endif" id="nav-schedule" role="tabpanel" aria-labelledby="nav-schedule-tab">
				  <div class="card">
						<div class="card-header">Event Schedule and Locations</div>

						<div class="card-body">
									<div class="row">
							  <div class="col-sm-12">
								 <div class="accordion" id="schedule_accordion">
								  <a href="javascript:void(0)" class="scheduleaccordian_tab @if( $activeTab!='schedule') collapsed @endif"  type="button" data-toggle="collapse" data-target="#schedule_collapse" aria-expanded="false" aria-controls="schedule_collapse">
									  Add Event Schedule and Locations
								  </a>
									<div id="schedule_collapse" class="collapse @if( $activeTab=='schedule') show @endif" aria-labelledby="headingThree" data-parent="#schedule_accordion">
										 <form method="POST" action="{{route('admin.schedule',['param'=>'save'])}}" >
											@csrf
											 <input type="hidden" name="event_id" value="{{ $event->id }}"> 
											<div class="row mb-3">
												<label for="schedule" class="col-md-4 col-form-label text-md-end">{{ __('Schedule') }}</label>

												<div class="col-md-6">
													<input id="schedule_date" data-start="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@endif" data-end="@if(isset($event)){{ date('m/d/Y',strtotime($event->end_date)) }}@endif" type="text" class="form-control @error('schedule') is-invalid @enderror" name="schedule" value="{{ date('m/d/Y',strtotime($event->start_date)) }}" autocomplete="schedule" autofocus>

													@error('schedule')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div> 
											<div class="row mb-3">
												<label for="schedule_time" class="col-md-4 col-form-label text-md-end">{{ __('Schedule Time') }}</label>

												<div class="col-md-6">
													<input id="schedule_time" type="text" class="form-control @error('schedule_time') is-invalid @enderror" name="schedule_time" value="{{ date('h:i:s a') }}" autocomplete="schedule_time" autofocus>

													@error('schedule_time')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>   
											<div class="row mb-3">
												<label for="location_link" class="col-md-4 col-form-label text-md-end">{{ __('Location Map Link') }}</label>

												<div class="col-md-6">
													<input id="location_link" type="text" class="form-control @error('location_link') is-invalid @enderror" name="location_link" value="{{ old('location_link') }}" placeholder="Add google map location url like this: https://goo.gl/maps/SZsedgqf8Sh2WN9u5"  autocomplete="location_link" autofocus>

													@error('location_link')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Location Full Address') }}</label>

												<div class="col-md-6">
													<input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" placeholder="Add location Full Address"  autocomplete="location" autofocus>

													@error('location')
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
									<th>Schedule</th>
									<th>Location Full Address</th>
									<th>Location Map Link</th>
									<th>Action</th>

									</tr>
								  </thead>
								  <tbody>
									@if(isset($schedules) && !empty($schedules))
									@foreach($schedules as $schedule)
										<tr>
											<td>{{ date("d-m-Y h:i a" , strtotime($schedule->schedule)) }}</td>
											<td>{{ $schedule->location }}</td>
											<td>{{ $schedule->location_link }}</td>
										
											<td class="td-action-icons"> 
											<a href="{{ route('admin.schedule') }}/edit?id={{$schedule->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
											<span class="delete_record btn-danger h3" data-id="{{$schedule->id}}" data-action="{{ route('admin.schedule') }}/delete"><i class="menu-icon mdi mdi-delete"></i></span>
											</td>
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
<?php } ?>

@endsection
