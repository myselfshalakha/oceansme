@extends('layouts.app')
@section('content') 
<div class="row justify-content-center">
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

	/*
			 <div class="col-12 grid-margin stretch-card">
			   <div class="card">
					<div class="card-header">Applicant Details</div>

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
							@if(!empty($event->restrictedCountries))
							<p class="fw-bold">
							  Not Applicable Countries
							</p>
							<p>
							<?php
								$countriesName="";
								$restrictedCountries=array();
								$restrictedCountries=\App\Models\Country::whereIn("id",unserialize($event->restrictedCountries))->get();
								foreach($restrictedCountries as $country){
										$countriesName.= $country->name . ", ";
								}
								
							$countriesName=rtrim($countriesName, ", ");
							?>
							{{$countriesName ?? "n/a"}}
							</p>
							@endif
							<p class="fw-bold">
							  Keys
							</p>
							<p>
							
							{{$postname ?? "n/a"}}
							</p>
						  </address>
						</div>
						<div class="col-md-12">
						 <div class="card-body">
						  <h4 class="card-title">Description</h4>
						  <div class="card-description">
							@if(isset($event)) {{$event->description ?? "n/a"}} @endif
						  </div>
						  
						</div>
						</div>
					  </div>
						
					</div>
				</div>
			</div>
	*/
	?>
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-header">Applicant Information</div>
				
				 <div class="card-body">
					@if(isset($applicant) && !empty($applicant))
						<div class="row event__applicant__info">
							<div class="col-md-6 grid-margin stretch-card">
								<div class="card-body">
							  <h4 class="card-title">Application status</h4>
							  <div class="media">
								<div class="media-body">
								<?php
								$status=get_user_status();
								?>
								  <p class="card-text">@if(isset($applicant->uev_status))<span class="badge badge-info">{{$status[$applicant->uev_status]}}</span>@endif
								  </p>
								</div>
							  </div>
							</div>
							</div>
							<div class="col-md-6 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">View Resume</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text resume__btns">
										@if(!empty($applicant->resume))<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn resume_icon_preview"><i class="mdi mdi-eye menu-icon"></i></a>
										<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn" download><i class="mdi mdi-download menu-icon"></i></a>
										@else 
											 n/a
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Profile</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									   @if(!empty($applicant->profileimage))
												<img src="{{ url('/') }}/assets/images/userprofile/{{$applicant->profileimage}}" class="profileimage applicant-img">
											@else 
												<img src="{{ url('/') }}/assets/images/user-image.png" class="profileimage applicant-img">
											@endif
									  <h5 class="text-primary"><strong>{{$applicant->name}}</strong></h5>
									  </p>
									</div>
								  </div>
								</div>
							</div>	
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Date of birth</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  @if(!empty($applicant->birthdate))
										{{date('d M,Y',strtotime($applicant->birthdate))}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>	
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Age</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  @if(!empty($applicant->birthdate))
										{{date('Y') - date('Y',strtotime($applicant->birthdate))}}
										@endif
										</p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Gender</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">{{$applicant->gender}}</p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Country</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  
									 @if(!empty($applicant->country))
										{{\App\Models\Country::find($applicant->country)->name ?? "n/a"}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Nationality</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  
									  @if(!empty($applicant->nationality))
										{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>
								

							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Address</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  @if(!empty($applicant->address))
										{{$applicant->address}}
										@endif
										</p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Contact</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									   @if(!empty($applicant->contactno))
										{{$applicant->contactno}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Email</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									   @if(!empty($applicant->email))
										{{$applicant->email}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Languages Known</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  <?php
									   
											$ulanguage="";
											if(!empty($applicant->languages)){
												$languages= unserialize($applicant->languages);
												foreach ($languages as $language){
												$ulanguage.= $language.", ";  	
												}
												 $ulanguage=rtrim($ulanguage,", ");
											}
											?>
											{{$ulanguage}}
									  </p>
									</div>
								  </div>
								</div>
							</div>
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Current Position</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									   @if(!empty($applicant->position))
										{{$applicant->position}}
										@endif
									  </p>
									</div>
								  </div>
								</div>
							</div>	
							
							<div class="col-md-3 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Total Experience</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									  {{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}
									  </p>
									</div>
								  </div>
								</div>
							</div>
						</div>
				   @endif
				</div>
			</div>
		</div>
	<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-header">Applicant Submitted Information</div>
				 <div class="card-body">
					@if(isset($applicant) && !empty($applicant))
					   <?php
						$formdata=[];
							$formdata=unserialize($event->form_elements);
						
						$user_eventsFormdata=unserialize($applicant->event_info);
						?>
								
						<div class="row event__applicant__info">
							@if(!empty($formdata)&&is_array($formdata))
							@foreach($formdata as $dataitem)
								@if(isset($dataitem->name)&&!in_array($dataitem->type,getNonEventInput()))
									<div class="col-md-4 grid-margin stretch-card">
											<div class="card-body">
											  <h4 class="card-title">{{str_replace('<br>'," ",htmlspecialchars_decode($dataitem->label))}}</h4>
											  <div class="media">
												<div class="media-body">
												  <p class="card-text">
												   @if(isset($user_eventsFormdata[$dataitem->name]))
													 @if(is_array($user_eventsFormdata[$dataitem->name]))  
														  <?php
															  $vfrmvalue="";
															  foreach($user_eventsFormdata[$dataitem->name] as $vval){
																 $vfrmvalue.= $vval.", ";  
															  }
															  $vfrmvalue=rtrim($vfrmvalue,", ");
															?>
															{{$vfrmvalue}}
													  @else 
														{{$user_eventsFormdata[$dataitem->name]}}
													  @endif
											  @else 
												 n/a
											  @endif
													  </p>
												</div>
											  </div>
											</div>
									</div>
								@endif
							@endforeach	
						@endif
							<div class="col-md-4 grid-margin stretch-card">
											<div class="card-body">
											  <h4 class="card-title">Position Applying For</h4>
											  <div class="media">
												<div class="media-body">
												  <p class="card-text">
												  @if(!empty($applicant->post_apply))
														@foreach($requiredPosts as $post)
															 @if($applicant->post_apply==$post->id)
																{{\App\Models\Department::find($applicant->uev_dep_id)->name}} - {{$post->name}}
															
																@if(!empty($post->rank))
																	- {{$post->rank}}
																@endif
																@if(!empty($post->rank_position))
																	- {{$post->rank_position}}
																@endif
															@endif
														@endforeach
													@else
														n/a
													@endif
													</p>
												</div>
											  </div>
											</div>
									</div>
						</div>	
				   @endif
				</div>
			</div>
		</div>
	<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-header">Interview Process</div>
				 <div class="card-body">
					<div class="row event__applicant__info">
						<div class="col-md-4 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Interview status</h4>
								  <div class="media">
									<div class="media-body">
									<?php
									$status=get_user_attending_status();
									?>
									  <p class="card-text">@if(isset($applicant->att_status))<span class="badge badge-info">{{$status[$applicant->att_status]}}</span>@endif
									  <!-- Button trigger modal -->
											<a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#applicant_event_modal">Change Status</a>
									  </p>
									</div>
								  </div>
								</div>
						</div>
						<div class="col-md-4 grid-margin stretch-card">
							<div class="card-body">
							  <h4 class="card-title">Final Salary After Negotiate</h4>
							  <div class="media">
								<div class="media-body">
								  <p class="card-text">
								  $ {{ $applicant->salary_final ?? "0.00" }}
								  <a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#applicant_salary_modal">Change</a>
								</p>
								</div>
							  </div>
							</div>
						</div>
						<div class="col-md-4 grid-margin stretch-card">
							<div class="card-body">
							  <h4 class="card-title">Questions</h4>
							  <div class="media">
								<div class="media-body">
								  <p class="card-text">
								  <a href="{{ url('/') }}/assets/files/posts/{{$post->questions ?? 'sample.pdf'}}" class="text-info" target="_blank">Question Bank</a>
								</p>
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

<!-- Modal for Change Status Appliccant -->
<div class="modal fade" id="applicant_event_modal" tabindex="-1" role="dialog" aria-labelledby="applicant_event_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicant_event_modalLabel">Change event Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="changeapplicantstatus">
		  <div class="form-group">
			<label for="Status">Status</label>
			<select class="form-control applicanteventStatus">
			  	<?php
					$status=get_user_attending_status();
				?>
				@foreach($status as $k=>$v)
					<option value="{{$k}}" @if( $applicant->att_status==$k) selected @endif>{{$v}}</option>
				@endforeach
			</select>
		  </div> 
		  <div class="form-group">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-id="{{$applicant->uevatt_id}}" data-action="{{route('admin.events',['param'=>'change_attending_status'])}}"  id="save__attending_status">Save</button>
		  </div>
		</form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal for Change Status Appliccant -->
<div class="modal fade" id="applicant_salary_modal" tabindex="-1" role="dialog" aria-labelledby="aapplicant_salary_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="aapplicant_salary_modalLabel">Final Salary with negotiate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="changesalary">
		  <div class="form-group">
			<label for="salary_final">Salary in ($)</label>
			<input type="text" name="salary_final" class="form-control salary_final" placeholder="10000" value="{{ $applicant->salary_final ?? '0' }}">
		  </div> 
		  <div class="form-group">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-id="{{$applicant->uev_id}}" data-action="{{route('admin.events',['param'=>'save__salary'])}}"  id="save__salary">Save</button>
		  </div>
		</form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal for Resume Preview -->
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

<?php
/*
<!-- Modal for Questions Preview -->
<div class="modal fade" id="applicant_questions_modal" tabindex="-1" role="dialog" aria-labelledby="applicant_questions_modalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicant_questions_modalLabel">Questions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	   @if(!empty($applicant->post_apply))
			@foreach($requiredPosts as $post)
				 @if($applicant->post_apply==$post->id)
					<iframe  src="https://docs.google.com/viewer?embedded=true&url={{ url('/') }}/assets/files/posts/{{$post->questions ?? 'sample.pdf'}}"  id="question_preview_area" class="question_preview_area" height="600" width="100%">
				@endif
			@endforeach
		@else
			n/a
		@endif
      </div>
     
    </div>
  </div>
</div>
*/
?>
@endsection
