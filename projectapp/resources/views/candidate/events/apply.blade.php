@extends('layouts.app')
@section('content') 
<?php
$user_response_status=get_user_response_status();

  $applicant_salary =(isset($applicant->salary_final))?get_company_salaryBy_Id($applicant->salary_final):null; 


?>
<div class="row justify-content-center">
	<div class="col-12">
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
	@if(session()->has('info'))
		<div class="alert alert-info">
			{{ session()->get('info') }}
		</div>
	@endif
	@if(session()->has('error'))
		<div class="alert alert-danger">
			{{ session()->get('error') }}
		</div>
	@endif
	</div>
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">Event Application-@if(isset($event)) <span class="text-primary event_labelname">{{ $event->name }}</span> @endif 
				 @if(isset($event)) 
					 <?php echo get_event_status_badge($event->status) ?>
				@endif
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
							
								
									
									
									
								
						</div>	
						
			
						
						
				
	
						
						
					@elseif(isset($eventRestrictions) && count($eventRestrictions)!=0)
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title text-danger">You are not elligible for this event. The reasons are given below:</h4>
								  <div class="media">
									<ul class="media-body error_list_with_dots">
									
									@foreach($eventRestrictions as $dataitem)
									  <li class="card-text"><p class="text-danger">{{$dataitem["message"]}}</p></li>
									 @endforeach
									</ul>
								  </div>
								</div>
							</div>
						</div>
					@else		
						<div class="row">
								<div class="col-12">
									<form action="{{route('admin.events',['param'=>'applyevent'])}}" id="applyeventForm" method="post"   enctype="multipart/form-data">
									@csrf
									@if(isset($event) && $event->status=="1"  && !empty($event->form_elements))
										{{csrf_field()}}
										<div id="applyevent" class="additionalform">
										
										</div>
									@endif
									@if(isset($event)) <input type="hidden" name="id" value="{{ $event->id }}"> @endif
									<div class="row mb-3">
										<label for="post" class="col-md-12 col-form-label text-md-end">Position Applying For<span class="required_star">*</span></label>
										<div class="col-md-12">
										<select class="form-control" name="post" required>
											<option value="">Choose any one option</option>
											@if(!empty($requiredPosts))
												@foreach($requiredPosts as $post)
													<option  value="{{ $post->id }}">{{$post->name}}</option>
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
									<?php
									/*
									<div class="row mb-3">
										<label for="salary_required" class="col-md-12 col-form-label text-md-end">Salary Required in ($)<span class="required_star">*</span></label>
										<div class="col-md-12">
										<input id="salary_required" type="number" class="form-control" name="salary_required" placeholder="0" required>

										@error('salary_required')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									*/
									?>
										<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary" id="event_apply_action_btn" >
													Apply
												</button>
												<span class="invalid-feedback apply_error bottom_alert" role="alert">
													
												</span>											
											</div>  
										</div>
									</form>
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
	<span id="checkuserevent" style="display:none;" data-id="{{$_GET['id']}}" data-action="{{route('admin.events',['param'=>'checkuserevent'])}}"></span>
@endsection

@section('footer')
@if(isset($eventRestrictions) && count($eventRestrictions)==0)
<?php
$formdata=[];
if(isset($user_events) && count($user_events)==0 && isset($event) && $event->status=="1"  && !empty($event->form_elements)){
	$formdata=json_encode(unserialize($event->form_elements));
?>
<script>
  jQuery(function() {
  var code = document.getElementById("applyevent");
  var formData ='<?php echo $formdata ?>';	
   var addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");
  var $markup = $("<div/>");
  $markup.formRender({ formData });
  code.innerHTML += addLineBreaks($markup.formRender("html")); 
});
</script>
<?php
}
?>
@endif
@endsection
