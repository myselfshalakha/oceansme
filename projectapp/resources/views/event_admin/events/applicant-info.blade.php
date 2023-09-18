@extends('layouts.app')
@section('content') 
<?php
$hiddenStatus=getHiddenUserEventStatus();
$user_response_status=get_user_response_status();
  $applicant_salary =(isset($applicant->salary_final))?get_company_salaryBy_Id($applicant->salary_final):null; 

?>
<div class="row justify-content-center">
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">RegNo-@if(isset($applicant)) <span class="text-info event_labelname">#{{ $applicant->uev_id }}</span> @endif 
				<a href="{{ route('admin.events',['param'=>'applicants']) }}?id={{$event->id}}" class="go__back btn-user h3" title="Applicant">Go Back</a> 
				</div>

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
									$postname.= $post->name;
									if(!empty($post->rank)){
										$postname.= " - ".$post->rank;
									}
									if(!empty($post->rank_position)){
										$postname.= " - ".$post->rank_position;
									}
									$postname.= ", ";
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
						@if(isset($event)) {{$event->description}} @endif
					  </div>
					  
					</div>
					</div>
                  </div>
             		
				</div>
			</div>
		</div>
<div class="col-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-header">Applicant Status</div>

		<div class="card-body">
		@if(isset($applicant) && !empty($applicant))
				
		<div class="row event__applicant__info">
		
@if(isset($eventRestrictions) && count($eventRestrictions)!=0)
			<div class="col-md-12 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title text-danger">Applicant is not elligible for this event. The reasons are given below:</h4>
								  <div class="media">
									<div class="media-body">
									<ul class="media-body error_list_with_dots">
									
									@foreach($eventRestrictions as $dataitem)
									  <li class="card-text"><p class="text-danger">{{$dataitem["message"]}}</p></li>
									 @endforeach
									</ul>
									</div>
								  </div>
								</div>
			</div>	
@endif	
			<div class="col-md-4 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Application status</h4>
								  <div class="media">
									<div class="media-body">
									
									  <p class="card-text">
									  @if(isset($applicant->uev_status)) 
										
									   <?php echo get_applicant_status_badge($applicant->uev_status,$user_response_status)  ?>
										
									 @endif
									  <!-- Button trigger modal -->
										<a href="javascript:void(0)" class="text-info" data-toggle="modal" data-target="#applicant_email_modal">Send Notify</a>
											

									  </p>
									</div>
								  </div>
								</div>
			</div>
			<div class="col-md-4 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Request Status</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">@if($applicant->request=="1")<span class="badge badge-info">Requested</span>
									  <a href="javascript:void(0)" data-action="{{route('admin.events',['param'=>'request_to_recheck'])}}" data-request="0"data-id="{{$applicant->uev_id}}" class="text-info request_to_recheck">Request reset</a>
									  @else 
										  n/a 
									  @endif
									</p>
									</div>
								  </div>
								</div>
			</div>
<div class="col-md-4 grid-margin stretch-card">
											<div class="card-body">
											  <h4 class="card-title">Schedule</h4>
											  <div class="media">
												<div class="media-body">
												  <p class="card-text">
												  <?php
												  $schedule= \App\Models\EventSchedule::find($applicant->schedule);
												  ?>
												  @if(!empty($schedule))
												  {{ date("d-m-Y h:i a" , strtotime($schedule->schedule)) ?? "n/a"}}
													@else 
														n/a
													  @endif
													</p>
												</div>
											  </div>
											</div>
									</div>
									<div class="col-md-4 grid-margin stretch-card">
											<div class="card-body">
											  <h4 class="card-title">Interview Location</h4>
											  <div class="media">
												<div class="media-body">
												  <p class="card-text">
												   {{ $schedule->location ?? "n/a"}}
													</p>
												</div>
											  </div>
											</div>
									</div>
									@if(!empty($schedule->location_link))
										<div class="col-md-4 grid-margin stretch-card">
												<div class="card-body">
												  <h4 class="card-title">Interview Location Link</h4>
												  <div class="media">
													<div class="media-body">
													  <p class="card-text">
													   <div class="mapouter"><div class="gmap_canvas"><iframe width="400" height="300" id="gmap_canvas" src="{{$schedule->location_link}}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div>
														</p>
													</div>
												  </div>
												</div>
										</div>
									@endif
			
			</div>
		@endif
		</div>
	</div>
</div>
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-header">Applicant Details</div>
				
				 <div class="card-body">
					@if(isset($applicant) && !empty($applicant))
								
						<div class="row event__applicant__info">
								<div class="col-md-6 grid-margin stretch-card">
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
						<div class="col-md-6 grid-margin stretch-card">
							<div class="card-body">
							  
									@if(!empty($applicant->resume))
									<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="btn btn-primary resume_icon_btn resume_icon_preview">View CV</a>
									<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="btn btn-primary resume_icon_btn" download>Download CV</a>
									@else 
										 n/a
									@endif
								 
							</div>
						</div>
							<?php
							/*
							<div class="col-md-3 grid-margin stretch-card">
									<div class="card-body">
									  <h4 class="card-title">Code</h4>
									  <div class="media">
										<div class="media-body">
										  <p class="card-text">
										  @if(!empty($applicant->interviewcode))
											{{$applicant->interviewcode}}
											@endif
										  </p>
										</div>
									  </div>
									</div>
							</div>
							*/
							?>
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
														 <?php
															$postdetails=\App\Models\Posts::find($applicant->post_apply);
															echo \App\Models\Department::find($postdetails->dep_id)->name." - ";
															echo $postdetails->name;
															if(!empty($postdetails->rank)){
																echo " - ".$postdetails->rank;
															}
															if(!empty($postdetails->rank_position)){
																echo " - ".$postdetails->rank_position;
															}
															?>
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
		
	
	</div>
@endsection

@section('footer')
 
<!-- Modal for Notify Applicant -->
<div class="modal fade" id="applicant_email_modal" tabindex="-1" role="dialog" aria-labelledby="applicant_email_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicant_email_modalLabel">Notify Applicant</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="applicantnotifyform">
		  <div class="form-group">
			<label for="Message">Message</label>
			<textarea class="form-control notify_message" ></textarea>
		  </div> 
		  <div class="form-group">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-id="{{$applicant->uev_id}}" data-action="{{route('admin.events',['param'=>'send_event_notify'])}}"  id="send_event_notify">Send Notify</button>
		  </div>
		</form>
      </div>
     
    </div>
  </div>
</div>

<?php
 /* 
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
					$status=get_user_status();
				?>
				@foreach($status as $k=>$v)
					<option value="{{$k}}" @if( $applicant->uev_status==$k) selected @endif>{{$v}}</option>
				@endforeach
			</select>
		  </div> 
		  <div class="form-group">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-id="{{$applicant->uev_id}}" data-action="{{route('admin.events',['param'=>'change_status'])}}"  id="save__applicant_status">Save</button>
		  </div>
		</form>
      </div>
     
    </div>
  </div>
</div>
*/

?>
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
@endsection
