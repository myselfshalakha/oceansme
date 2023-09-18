@extends('layouts.app')
@section('content') 
<?php
$user_response_status=get_user_response_status(2);
  $applicant_salary =get_company_salaryBy_Id($applicant->post_assigned);
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
<div class="row justify-content-center">
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
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
			<div class="card-header">Basic Details</div>
				 <div class="card-body">
					@if(isset($applicant) && !empty($applicant))
						<div class="row event__applicant__info">
							<div class="col-md-6 grid-margin stretch-card">
							<div class="row">
								<div class="col-md-12 grid-margin stretch-card">
								 <div class="table-responsive">
									<table class="table table-user-information">
										<tbody>
											<tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Application status                                                
													</strong>
												</td>
												<td class="text-primary">
													<?php
												$status=get_user_status();
												?>
												 
												   @if(isset($applicant->uev_status)) 
													 @if($applicant->uev_status=="6" || in_array($applicant->uev_status,$user_response_status))
													  <span class="badge badge-info">
															{{$status['6']}}
													  </span>
													@endif
													 @if($applicant->uev_status!='6')
													  <span class="badge badge-info">
															{{$status[$applicant->uev_status]}}
													  </span>
													@endif
													
												 @endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Profile                                            
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->profileimage))
															<img src="{{ url('/') }}/assets/images/userprofile/{{$applicant->profileimage}}" class="profileimage applicant-img">
														@else 
															<img src="{{ url('/') }}/assets/images/user-image.png" class="profileimage applicant-img">
														@endif
												  <h5 class="text-primary"><strong>{{$applicant->name}}</strong></h5>
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Date of birth                                               
													</strong>
												</td>
												<td class="text-primary">
													@if(!empty($applicant->birthdate))
													{{date('d M,Y',strtotime($applicant->birthdate))}}
													@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Age                                               
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->birthdate))
										{{date('Y') - date('Y',strtotime($applicant->birthdate))}}
										@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Gender                                            
													</strong>
												</td>
												<td class="text-primary">
													{{ucfirst($applicant->gender)}}
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Country                                            
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->country))
													{{\App\Models\Country::find($applicant->country)->name ?? "n/a"}}
													@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Nationality                                              
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->nationality))
													{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}
													@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Address                                                
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->address))
													{{$applicant->address}}
													@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Contact                                               
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->contactno))
													{{$applicant->contactno}}
													@endif
												</td>
											</tr>
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Email                                                
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->email))
													{{$applicant->email}}
													@endif
												</td>
											</tr>   
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Languages Known                                              
													</strong>
												</td>
												<td class="text-primary">
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
												</td>
											</tr>   
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Current Position                                                
													</strong>
												</td>
												<td class="text-primary">
													 @if(!empty($applicant->position))
														{{$applicant->position}}
														@endif
												</td>
											</tr>   
											  <tr>        
												<td>
													<strong>
														<span class="glyphicon glyphicon-asterisk text-primary"></span>
														Total Experience                                               
													</strong>
												</td>
												<td class="text-primary">
													{{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}
												</td>
											</tr>   
											                            
										</tbody>
									</table>
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
															 {{\App\Models\Department::find($post->dep_id)->name ?? ''}} - {{$post->name}}
															<?php
															if(!empty($post->rank)){
																echo " - ".$post->rank;
															}
															if(!empty($post->rank_position)){
																echo " - ".$post->rank_position;
															}
															?>
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
			
				<div class="card-header">Interview Process</div>
				 <div class="card-body">
				 <form action="{{route('admin.events',['param'=>'saveApplicantSalary'])}}" method="post">
						{{csrf_field()}}
						<input type="hidden" name="uevatt_id" value="{{ $applicant->uevatt_id }}">
						<input type="hidden" name="uev_id" value="{{ $applicant->uev_id }}">
						<input type="hidden" name="event_id" value="{{ $event->id }}">
				
					<div class="row event__applicant__info">
						
						<div class="col-md-6 grid-margin stretch-card">
							<div class="card-body">
							  <h4 class="card-title">Interview Questions</h4>
							  <div class="media">
								<div class="media-body">
									@if(isset($applicant) && !empty($applicant->att_event_info))
											<?php
											$i=0;
											foreach(unserialize($applicant->att_event_info) as $question){
												?>
													<div class="row mb-3">
														<div class="col-md-12">{{$question['question']}}</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="1" @if($question['answer']==1) checked @endif > 1
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="2" @if($question['answer']==2) checked @endif  > 2
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="3" @if($question['answer']==3) checked @endif  > 3
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="4" @if($question['answer']==4) checked @endif  > 4
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="5" @if($question['answer']==5) checked @endif  > 5
														</div>
													</div>
													<?php
													$i++;
											}
											?>
									@elseif(isset($event) && !empty($event->interview_questions))
											<?php
											$i=0;
											foreach(unserialize($event->interview_questions) as $question){
												?>
													<div class="row mb-3">
														<div class="col-md-12">{{$question['question']}}</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="1" > 1
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="2" > 2
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="3" > 3
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="4" > 4
														</div>
														<div class="col-md-2">
														<input type="radio" name="answer_{{$i}}" class=""  value="5" > 5
														</div>
													</div>
													<?php
													$i++;
											}
											?>
									@endif
								</div>
							  </div>
							</div>
						</div>
						<div class="col-md-6 grid-margin stretch-card">
							<div class="card-body">
							  <h4 class="card-title">Technical Questions</h4>
							  <div class="media">
								<div class="media-body">
								<div class="shuffle_question_items">
								<?php echo getDepartmentQuestionsHtmlShuffle($department) ?>
								</div>
								<div class="row mb-3 "><div class="col-md-12">
								<button type="button" class="button btn btn-primary" id="shuffle_btn">Shuffle</button></div></div>
								</div>
							  </div>
							</div>
						</div>	
						
					</div>	
			  	<div class="row event__applicant__info">
					<div class="col-md-6 grid-margin stretch-card">
								<div class="card-body">
								  <h4 class="card-title">Interview status</h4>
								  <div class="media">
									<div class="media-body">
									<?php
									$status=get_user_attending_status();
									?>
									  <p class="card-text">
									  <!-- Button trigger modal -->
										<select class="form-control applicanteventStatus" name="status"> 
											<?php
												$status=get_user_attending_status(true); 
											?>
											@foreach($status as $k=>$v)
												<option value="{{$k}}" @if( $applicant->att_status==$k) selected @endif  @if($k=="3" && in_array($applicant->att_status,$user_response_status))  selected @endif>{{$v}}</option>
											@endforeach
										</select>
									  </p>
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
								<select class="form-control post_assign_select" data-id="{{$event->company_id}}" data-action="{{route('admin.events',['param'=>'salary_details_applicant'])}}" name="post_assigned">
									<option value="">Choose One Position</option>
								<?php
								$requiredPosts=\App\Models\CompanySalarySystem::whereIn("post_id",unserialize($event->post_id))->where("company_id",$event->company_id)->get();
								?>
									@if(!empty($requiredPosts))
										@foreach($requiredPosts as $salary)
									<?php
											$post=\App\Models\Posts::find($salary->post_id);
									?>
											<option  @if($salary->id==$applicant->post_assigned) selected @endif  value="{{ $salary->id }}">{{$post->name}}
											@if(!empty($post->rank))
												- {{$post->rank}}
											@endif
											@if(!empty($post->rank_position))
												- {{$post->rank_position}}
											@endif
											@if(!empty($post->rank_position))
												- {{$post->rank_position}}
											@endif
											@if(!empty($salary->seniority_range))
												- ({{$salary->seniority_range}})
											@endif
											</option>
										@endforeach
									@endif
								</select>
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
								  <?php echo make_table_with_salary_info($applicant_salary) ?>
								</div>
							  </div>
							</div>
						</div>	
						<div class="col-md-12 grid-margin stretch-card">
							<div class="card-body">
								 <div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Save Changes
												</button> 
											
											</div>  
								</div>
							</div>
						</div>
					</div>
				</form>
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
			<textarea class="form-control notify_message" name="notify_message" ></textarea>
		  </div>
		  <div class="form-group">
			<label for="Message">LOI Attachment</label>
			<input type="file" class="form-control notify_attach" name="notify_attach" />
		  </div> 
		  <div class="form-group">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" data-id="{{$applicant->uev_id}}" data-action="{{route('admin.events',['param'=>'send_applicant_notify'])}}"  id="send_applicant_notify">Send Notify</button>
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
