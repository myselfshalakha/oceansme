@extends('layouts.app')
@section('content') 
	<div class="row justify-content-center">
                        <div class="col-md-12">
                           <form class="card card-sm" action="{{ route('admin.events') }}/search_applicant" method="get">
									  {{csrf_field()}}

                                <div class="card-body row no-gutters align-items-center">
                               
                                    <!--end of col-->
                                    <div class="col-10">
										 <input type="text" class="form-control form-control-lg" name="id" placeholder="Enter the Regid" value="{{ $_GET['id'] ?? '' }}" required>
                                    </div>
                                    <!--end of col-->
                                    <div class="col-2">
										<button type="submit" class="btn btn-primary me-2">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
<div class="row justify-content-center">
<?php
$user_response_status=get_user_response_status(2);
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
															 {{$department->name ?? ''}} - {{$post->name}}
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
									@if(!empty($requiredPosts))
										@foreach($requiredPosts as $post)
											<option  @if($post->id==$applicant->post_assigned)) selected @endif  value="{{ $post->id }}">{{$post->name}}</option>
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
	  <div id="file-preview"></div>

      </div>
     
    </div>
  </div>
</div>
@if($applicant->att_status!=9)
<script>

function page_locked_for_others(){
	var req_url="{{route('admin.events',['param'=>'page_locked'])}}";
	var id="{{$_GET['id']}}";
	jQuery.ajax({
			method:'POST',  
			url : req_url,
			data : {id:id},
			dataType: 'JSON',
			success: function(data){
				
			}   
		});
}
jQuery(document).ready(function(){
	page_locked_for_others();
	setInterval(function(){
		page_locked_for_others();
	},5000);
});

</script>
@endif
@endsection
