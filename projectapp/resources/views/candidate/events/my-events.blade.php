@extends('layouts.app')
@section('content') 
<?php
$user_response_status=get_user_response_status();

  $applicant_salary =(isset($applicant->salary_final))?get_company_salaryBy_Id($applicant->salary_final):null; 

?>
 @if(isset($event) && !empty($event)&& isset($profilestatus) && $profilestatus>='100') 
	 
					<div class="row">
                      <div class="col-lg-12 d-flex flex-column">
                            <div class="card">
                               <div class="card-body">
									<div class="progress-container">
									  <ul class="progressbar">
										<li class="active">Applied</li>
										<li class="@if(in_array($event->uev_status,[3,5,6,7,9])) active @endif">Application @if($event->uev_status==3) rejected @else selected @endif</li>
										<li class="@if(in_array($event->uev_status,[5,9,7])) active @endif @if($event->uev_status==5) danger @elseif($event->uev_status==7) waiting @elseif($event->uev_status==9) success @endif">Interview Attending?
										<span>@if($event->uev_status==5) no @elseif($event->uev_status==7) no response @elseif($event->uev_status==9) yes @endif </span>
										</li>
										@if(isset($eventAttendings) && !empty($eventAttendings))
										<li class="active">Interview</li>
										<li class="@if(in_array($eventAttendings->status,[2,3,4,5,7])) active @endif">@if($eventAttendings->status==5) Rejected @else Selected @endif</li>
										<li class="@if(in_array($eventAttendings->status,[2,4])) active @endif   @if($eventAttendings->status==2) danger @endif">LOI Accepted? 
										<span>@if($eventAttendings->status==4) yes @elseif($eventAttendings->status==2) no @endif</span>
										</li>
										<li class="@if(in_array($eventAttendings->status,[4])) active @endif">Completed</li>
										@else
										<li class="">Interview</li>
										<li class="">Selected</li>
										<li class="">LOI Accepted?</li>
										<li class="">Completed</li>
										@endif
									  </ul>
									</div>
                               </div>
                            </div>
                      </div>
                    </div>
				
	 <div class="row">

		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">Event Application-@if(isset($event)) <span class="text-primary event_labelname">{{ $event->name }}</span> @endif 
					<?php echo get_event_status_badge($event->status) ?>
				
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
					@if(isset($user_events) && count($user_events)!=0) 
						<p class="card-description event_status description"><span class="badge badge-success">Applied</span></p> 
					@else
						<p class="card-description event_status description">
							
								<div class="row mb-0 submit_btn_row">
									<div class="col-md-12 d-flex">
										<button type="button" class="btn btn-primary hasEventFields event_apply_btn">
											Apply
										</button> 
									
									</div>  
								</div>
						</p> 
					@endif
					
                      </address>
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
						@if(isset($event)) {{$event->description}} @endif
					  </div>
					  
					</div>
					</div>
                  </div>
             		
				</div>
			</div>
		</div>
		<div class="col-12 grid-margin stretch-card" id="required_infosection">
			<div class="card">
				<div class="card-header">Applied Information</div>
				
				 <div class="card-body">
				
					@if(isset($user_events) && count($user_events)!=0)
					   <?php
						$formdata=[];
						if((isset($event)) && $event->status=="1"  && !empty($event->form_elements)){
							$formdata=unserialize($event->form_elements);
						}
						$user_eventsFormdata=unserialize($user_events[0]->event_info);
						?>
						<div class="row">
							<div class="col-md-4 grid-margin stretch-card">
												<div class="card-body">
												  <h4 class="card-title">Application status</h4>
												  <div class="media">
													<div class="media-body">
													<?php
													$status=get_user_status();
													?>
													  <p class="card-text">
													  <span class="badge badge-info">{{$status[$user_events[0]->status]}}</span>
													  @if($user_events[0]->status=="6")
														  <span class="cm-card-note">Please check your email and give your resposne asap.</span>
													  @elseif($user_events[0]->status=="2")
														  <span class="cm-card-note text-danger">Your Profile is not completed 100%.</span>
														  @if($user_events[0]->request=="0")
															  <a href="javascript:void(0)" data-action="{{route('admin.events',['param'=>'request_to_recheck'])}}" data-request="1"data-id="{{$user_events[0]->id}}" class="text-info request_to_recheck">Request for recheck application</a>
														  @else
															  <p class="cm-card-note text-success">Request Submitted</p>
														  @endif
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
												  $schedule= \App\Models\EventSchedule::find($user_events[0]->schedule);
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
							
								
									<div class="col-md-4 grid-margin stretch-card">
											<div class="card-body">
											  <h4 class="card-title">Position Applying For</h4>
											  <div class="media">
												<div class="media-body">
												  <p class="card-text">
												  @if(!empty($user_events[0]->post_apply))
														@foreach($requiredPosts as $post)
															 @if($user_events[0]->post_apply==$post->id)
																{{\App\Models\Department::find($user_events[0]->dep_id)->name}} - {{$post->name}}
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
	
				
						
				
						@if(isset($applicant->salary_final))
	<div class="col-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-header">Interview Process</div>
					 <div class="card-body">
						
						<div class="row event__applicant__info">
							<div class="col-md-6 grid-margin stretch-card">
									<div class="card-body">
									  <h4 class="card-title">Interview status</h4>
									  <div class="media">
										  <div class="media">
										<div class="media-body">
										<?php
										$status=get_user_attending_status();
										?>
										  <p class="card-text">
										  @if(isset($applicant->att_status))
										   @if($applicant->att_status=="3" || in_array($applicant->att_status,$user_response_status))
											  <span class="badge badge-info">
												{{$status['3']}}
											  </span>
											@endif
										  <span class="badge badge-info">
											 @if($applicant->status=="3")
												 {{$status['7']}}
											 @else
												 {{$status[$applicant->status]}}
											 @endif
										  </span>
										@endif
										
										  </p>
										</div>
									  </div>
								
									  </div>
									</div>
							</div>
							<div class="col-md-6 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Position Assigned</h4>
								  <div class="media">
									<div class="media-body">
									  <p class="card-text">
									    @if(isset($applicant->att_status) && in_array($applicant->att_status,[2,3,4]))
											@if(!empty($requiredPosts))
												@foreach($requiredPosts as $post)
												@if($post->id==$applicant->post_assigned) 
												<span class="">
													{{$post->name}}
												  </span>
												   @endif 
												@endforeach
											@else
												n/a
											@endif
										@else
											n/a
										@endif
									
									</p>
									</div>
								  </div>
								</div>
							</div>
							 
							
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Salary System</h4>
								  <div class="media">
									<div class="media-body salary_details_applicant">
									 @if(isset($applicant->att_status) && in_array($applicant->att_status,[2,3,4]))
									  <?php echo make_table_with_salary_info($applicant_salary) ?>
									@else
											n/a
										@endif
									
									</div>
								  </div>
								</div>
							</div>		
						
							
						</div>	
				  
					
					</div>
			</div>
			</div>
	@endif
						

	</div>
	@elseif(isset($profilestatus) && $profilestatus<='99') 
		

				<div class="row">
							  <div class="col-lg-12 d-flex flex-column">
									<div class="card">
									   <div class="card-body">
									   
										<div class="row">
										  <div class="col-sm-12">
											 <div class="accordion" id="accordionExample">
											  <h2 class="profile__percentage collapsed"  type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
												  <p class="card-description profile_top_heading">Profile Completion Status: 
												   @if(isset($profilestatus))
												   <span class="@if($profilestatus>='80') text-success @elseif($profilestatus>='50') text-warning @elseif($profilestatus>='30') text-info @elseif($profilestatus>='0') text-danger @endif">
												   {{round($profilestatus)}}%
												   </span>
												   @endif
												   <a href="{{route('admin.profile') }}">View Profile</a>
												   </p>
												   <p class="card-description">To apply any event, you need to make sure that your profile completion percentage is 100% <a href="javascript:void(0)">Click here to see how it works</a></p>
											  </h2>
											
												<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
													<div id="chartContainer" style="min-height: 350px;width: 100%;"></div>
												</div>
											</div>
									 
										  </div>
										</div>
									  </div>
									</div>
							  </div>
						  
							</div>
	@else
		 <div class="row">
	<div class="col-lg-12 d-flex flex-column">
		<div class="row home__events_row">
			<h2 class="main-card-title">My Event</h2>
			<p class="card-description">No results found.</p>
		</div>
	</div>
	</div>
	@endif
	
@endsection

