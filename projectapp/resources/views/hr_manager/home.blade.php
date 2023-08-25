@extends('layouts.app')

@section('content')
<?php
$tabArr=["company","event","interviewer","agencies","applicant"];
$activeTab="company";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        [], 
        [], 
        ['firstname', 'lastname', 'email', 'gender', 'contactno'],
        ['name', 'email', 'phone', 'address','countries'],
        []
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
 <div class="row dash-board-count-box">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card cmtab_dashboard_click" data-id="company_description">
                <div class="card-block">
                    <h6 class="text-right"><i class="fa fa-building f-left"></i><span>Show Company Info</span></h6>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card cmtab_dashboard_click" data-id="event_description">
                <div class="card-block">
                    <h6 class="text-right"><i class="fa fa-rocket f-left"></i><span>Show Event Info</span></h6>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card cmtab_dashboard_click @if( $activeTab=='interviewer') active @endif" data-id="invigilator_description">
                <div class="card-block">
                    <h6 class="text-right"><i class="fa fa-user-secret f-left"></i><span>Show Interviewer</span></h6>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card cmtab_dashboard_click" data-id="agencies">
                <div class="card-block">
                    <h6 class="text-right"><i class="fa fa-user f-left"></i><span>Agencies</span></h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card cmtab_dashboard_click" data-id="applicant_description">
                <div class="card-block">
                    <h6 class="text-right"><i class="fa fa-user f-left"></i><span>Show Applicant</span></h6>
                </div>
            </div>
        </div>
	</div>
	
  <div class="row dash-board-count-box_description">
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
			<div class="row company_info disp_none" id="company_description">
			<div class="card">
		 <div class="card-body">
						<div class="col-md-12">
							<div class="row">
						<div class="col-md-3">
						  <div class="card-description featured_image">
							 	 <img src="{{ url('/') }}/assets/images/company/{{ $company->logo ?? 'default.jpg' }}" class="profile__img">

						  </div>
						</div>
					
						<div class="col-md-3">
						<address class="text-primary">
								<p class="fw-bold">
								  <strong>Company Information</strong>
								</p>
							</address>
						  <address class="text-primary">
								
								<p class="mb-2">
								</p>
								 <p class="fw-bold">
								  Name: 
								</p>
								<p class="mb-2">
								{{ $company->name }} 
								</p>
								 <p class="fw-bold">
								  Email: 
								</p>
								<p class="mb-2">
								{{ $company->email }} 
								</p>
								 <p class="fw-bold">
								  Phone: 
								</p>
								<p class="mb-2">
								{{ $company->phone }} 
								</p>
								 <p class="fw-bold">
								  Website: 
								</p>
								<p class="mb-2">
								{{ $company->website_link }} 
								</p>
						</address>
						</div>
						<div class="col-md-6">
							 <address class="text-primary">
							 <p class="fw-bold">
								  Addresss
								</p>
								<p>
								
								{{$company->address ?? "n/a"}}
								</p>
								<p class="fw-bold">
								  Landmark
								</p>
								<p>
								{{$company->address2 ?? "n/a"}}
								</p>
								<p class="fw-bold">
								  Country
								</p>
								<p>
									@if($company->country_id=="other")
										Other
									@else
									{{ \App\Models\Country::find($company->country_id)->name ?? "n/a"}}
									@endif
								</p>
								<p class="fw-bold">
								  State
								</p>
								<p>
								@if($company->state_id=="other")
									Other
								@else
								{{ \App\Models\State::find($company->state_id)->name ?? "n/a"}}
								@endif
								</p>
								<p class="fw-bold">
								  City
								</p>
								<p>
								@if($company->city_id=="other")
									Other
								@else
								{{ \App\Models\City::find($company->city_id)->name ?? "n/a"}}
								@endif
								</p>
							</address>
						</div>
						<div class="col-md-12">
							 <address class="text-primary">
									<p class="fw-bold">
									  Description
									</p>
									<div>
									{{$company->description  ?? "n/a"}} 
									</div>
							</address>
						</div>
						</div>
						</div>
			
			</div>
			</div>
			</div>
        
		<div class="row event_info disp_none" id="event_description">
		<div class="card">
		 <div class="card-body">
					<div class="col-md-12">
						<div class="row">
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
			</div>
        
			<div class="row invigilator_info disp_none @if( $activeTab=='interviewer') active @endif" id="invigilator_description">
			<div class="card">
		 <div class="card-body">
				<div class="col-md-12">
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
												 <input type="hidden" name="company_id" value="{{ $event->company_id }}">
												 <div class="row mb-3">
													<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('FirstName') }}<span class="required_star">*</span></label>

													<div class="col-md-8">
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

													<div class="col-md-8">
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

													<div class="col-md-8 d-flex">
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

													<div class="col-md-8">
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

													<div class="col-md-8">
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

													<div class="col-md-8">
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

													<div class="col-md-8">
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
			
	
			<div class="row agencies_info disp_none @if( $activeTab=='agencies') active @endif" id="agencies">
			<div class="card">
		 <div class="card-body">
				<div class="col-md-12">
					<div class="row">
								  <div class="col-sm-12">
									 <div class="accordion" id="agencies_Accordian">
									  <a href="javascript:void(0)" class="agencies_accordian_tab @if( $activeTab!='agencies') collapsed @endif"  type="button" data-toggle="collapse" data-target="#collapseagencies" aria-expanded="false" aria-controls="collapseagencies">
										  Add Agency
									  </a>
										<div id="collapseagencies" class="collapse @if( $activeTab=='agencies') show @endif" aria-labelledby="headingThree" data-parent="#agencies_Accordian">
											 <form method="POST" action="{{ route('admin.agency') }}/save">
												@csrf
												
												<input type="hidden" name="event_id" value="{{ $event->id }}"> 
												 <div class="row mb-3">
													<label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}<span class="required_star">*</span></label>

													<div class="col-md-8">
														<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

														@error('name')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>   
											
												
												<div class="row mb-3">
													<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}<span class="required_star">*</span></label>

													<div class="col-md-8">
														<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

														@error('email')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>

												  <div class="row mb-3">
													<label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

													<div class="col-md-8">
														<input id="phoneno" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">

														@error('phone')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>  
												<div class="row mb-3">
													<label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

													<div class="col-md-8">
														<textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>

														@error('address')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>
												<div class="row mb-3">
													<label for="country_id" class="col-md-4 col-form-label text-md-end">{{ __('Countries') }}</label>

													<div class="col-md-8">
														
												<select class="form-control @error('country_id') is-invalid @enderror" name="country_id[]" id="agency_country_id" multiple="multiple">
																@if(!empty($countries))
																	@foreach($countries as $country)
																		<option  value="{{ $country->id }}">{{$country->name}}</option>
																	@endforeach

																@endif
															</select>
														@error('country_id')
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
										<th>Phone</th>
										<th>Assigned Applicants</th>
										<th>Countries</th>
										<th>Action</th>

										</tr>
									  </thead>
									  <tbody>
										@if(isset($agencies) && !empty($agencies))
										@foreach($agencies as $agency)
											<?php
												$country_idArr=array();
												if(!empty($agency->country_id)){
													$country_idArr= unserialize($agency->country_id);
												}
												$countryNames = App\Models\Country::whereIn('id', $country_idArr)->pluck('name');
												?>
											<tr>
												<td>{{ $agency->name }}</td>
												<td>{{ $agency->email }}</td>
												<td>{{ $agency->phone }}</td>		
												<td>Total {{ getAgenciesUsers(true,$country_idArr,$agency->event_id ) }} applicants, selected {{ getAgenciesUsers(true,$country_idArr, $agency->event_id,true)}}</td>		
												<td>{{ implode(', ', $countryNames->toArray()) }}</td>	
												<td class="td-action-icons">
												 <a href="{{ route('admin.agency',['param'=>'edit']) }}?id={{$agency->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
												<span class="delete_record btn-danger h3" data-id="{{$agency->id}}" data-action="{{ route('admin.agency') }}/delete"><i class="menu-icon mdi mdi-delete"></i></span>
												<span title="Send Sheet to Agency" class="send_csv_agency btn-info h3" data-id="{{$agency->id}}" data-action="{{ route('admin.events') }}/send_csv_agency"><i class="menu-icon mdi mdi-email"></i></span>
												</td>
											</tr>
										@endforeach
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
			
			
		<div class="row invigilator_info disp_none @if( $activeTab=='applicant') active @endif" id="applicant_description">
			<div class="card">
		 <div class="card-body">
				<div class="col-md-12">
					<div class="row">
								  <div class="col-sm-12">
										<div id="download_csvlist_btn" class="card-title download_csvlist_btn">
										<a href="{{ route('admin.events') }}/get_applied_user?id={{$event->id}}" class="btn btn-primary btn-sm">Download Csv</a>
								
										</div>	
										<div id="loi_pdfbtn" class="card-title loi_pdfbtn">
										
									<?php
									$status=get_user_attending_status();
									?>
									  <p class="card-text">
									  	<a href="{{ route('admin.events') }}/send_applicant_notify" class="btn btn-primary btn-sm send_applicant_notify">Send LOI selected user</a>
									  <!-- Button trigger modal -->
										<select class="form-control sortbyStatus" id="sortbyStatus" name="status"> 
												<option value="">All</option>
											<?php
												$status=get_user_attending_status(true); 
											?>
											@foreach($status as $k=>$v)
												<option value="{{$k}}">{{$v}}</option>
											@endforeach
										</select>
									  </p>
										</div>
								
								   <div class="table-responsive  mt-1 applicant_list_table">
                                   <table class="table select-table">
                                    <thead>
                                      <tr>
                                      	<th><input type="checkbox" name="select_all" value="1" id="rows-select-all"></th>
                                       <th></th>
                                       <th>Status</th>
									   
                                       <th>Name</th>
										<th>Email</th>
										<th>Nationality</th>
										<th>Current Position</th>
										<th>Position Applying</th>
										<th>Experience</th>
										<th>Schedule</th>
										<th>Resume</th>
										<?php 
										// <th>Assign Interviewer</th>
										?>
                                      </tr>
                                    </thead>
                                    <tbody>
									<?php
									$status=get_user_attending_status();
									
									?>
                                     @if(isset($applicants) && count($applicants)!=0)
										@foreach($applicants as $applicant)
											<tr>
												 <td>{{$applicant->uev_id}}</td>
												<td>
												<a href="{{ route('admin.events',['param'=>'applicant-info']) }}?id={{$applicant->uev_id}}" class="text-info" title="View">View Applicant</a> 

												</td>
												 <td>{{$applicant->att_status}}</td>
												<td>{{ $applicant->name }} @if(isset($applicant->att_status))</br><span class="badge badge-info">{{$status[$applicant->att_status]}}</span> @endif</td>
												<td>{{ $applicant->email }}</td>
												<td>{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}</td>

												<td>{{ $applicant->position ?? 'n/a'}}</td>
												<td>{{ \App\Models\Posts::find($applicant->post_apply)->name}}</td>
											
												<td>{{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}</td>
												<td>
												 <?php
											  $schedule= \App\Models\EventSchedule::find($applicant->schedule);
											  ?>
											  @if(!empty($schedule))
											  {{ date("d-m-Y h:i a" , strtotime($schedule->schedule)) ?? "n/a"}} ,  {{ $schedule->location ?? "n/a"}}
												@else 
												n/a
											  @endif
												</td>
												<td>
												@if(!empty($applicant->resume))
													<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn resume_icon_preview"><i class="mdi mdi-eye menu-icon"></i></a>
												@else 
													Not Uploaded Yet. 
												@endif
												</td>
												<?php
												/*
												<td>
												<select  class="applicantInterViewerSelect">
													<option value="" >choose any one interviewer</option>
													@if(isset($event_team) && !empty($event_team))
														@foreach($event_team as $user)
														@if($user->role_id=="5")
														@continue
														@endif
															<option value="{{ $user->id }}" @if( $applicant->interviewer_id==$user->id) selected @endif>{{ $user->name }}</option>
														@endforeach
													@endif
												</select>
												<a href="javascript:void(0)"  data-id="{{$applicant->uevatt_id}}" data-action="{{route('admin.events',['param'=>'change_interviewer'])}}" class="change_interviewer text-primary">Change</a>
												</td>
												*/
												?>
											</tr>
                                    	@endforeach
									
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
@endsection
@section('footer')

<div class="modal fade" id="applicant_resume_modal" tabindex="-1" role="dialog" aria-labelledby="applicant_resume_modalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicant_resume_modalLabel">Resume Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
     
    </div>
  </div>
</div>

<script src="{{ asset('/assets/common/js/hr_manager/datatable.js') }}"></script>
@endsection
