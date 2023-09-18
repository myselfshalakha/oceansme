@extends('layouts.app')
@section('content') 
<?php
$eventID=isset($_GET["id"])?$_GET["id"]:"";
$userEventStatus=isset($_GET["status"])?$_GET["status"]:"";
?>
  <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
              
                  <div>
                    <div class="btn-wrapper">
					 @php
						$userStatus=get_user_status();
						$totaleventsCount=0;
					@endphp
						@foreach($eventStatusCountData as $statusData)
									@php
									$totaleventsCount+=$statusData->total;
									@endphp
						@endforeach
                      <a href="{{ url('/') }}/{{Request::path()}}?id={{$event->id}}" class="@if(empty($userEventStatus)) btn btn-primary text-white me-0 @else btn btn-otline-dark align-items-center @endif">All ({{$totaleventsCount}})</a>
						@foreach($userStatus as $k=>$v)
							@php 
								$totaleventsCount=0;
							@endphp
							@foreach($eventStatusCountData as $statusData)
								@if($statusData->status==$k)
									@php
										$totaleventsCount=$statusData->total;
									@endphp
									@break
								@endif
							@endforeach
							@if($userEventStatus==$k)
								<a href="{{ url('/') }}/{{Request::path()}}?id={{$event->id}}&status={{$k}}" class="btn btn-primary text-white me-0">{{$v}} ({{$totaleventsCount}})</a>
							@else
								<a href="{{ url('/') }}/{{Request::path()}}?id={{$event->id}}&status={{$k}}" class="btn btn-otline-dark align-items-center">{{$v}} ({{$totaleventsCount}})</a>
							@endif
						@endforeach
                      <!--a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
  </div>
<div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
							    <div class="card-header">Event @if(isset($event))<span class="text-primary event_labelname"> {{ $event->name }} </span> @endif Applicants List
								 @if(isset($event)) 
									<?php echo get_event_status_badge($event->status) ?>
								@endif
								</div>
                              <div class="card-body">
                               
                                <div class="table-responsive  mt-1">
                                   <table class="table select-table">
                                    <thead>
                                      <tr>
                                       <th>RegNo</th>
                                       <th>Name</th>
										<th>Email</th>
										<th>Nationality</th>
										<th>Current Position</th>
										<th>Applying Position</th>
										<th>Eperience</th>
										<th>Schedule</th>
										<th>Resume</th>
										<th>Change Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
									<?php
									$status=get_user_status();
									?>
                                     @if(isset($applicants) && count($applicants)!=0)
										@foreach($applicants as $applicant)
											<tr>
												<td>
												<a href="{{ route('admin.events',['param'=>'applicant-info']) }}?id={{$applicant->uev_id}}" class="text-info" title="Regid">#{{$applicant->uev_id}}</a> 

												</td>
												<td>{{ $applicant->name }}
													 @if(isset($applicant->status)) <p class="card-text"><span class="badge badge-info">{{$status[$applicant->status]}}</span></p>@endif
												</td>
												
												<td>{{ $applicant->email }}</td>
												<td>{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}</td>

												<td>{{ $applicant->position ?? 'n/a'}}</td>
												<td>
													<?php $post= \App\Models\Posts::find($applicant->post_apply) ?>
													{{ $post->name}}
													@if(!empty($post->rank))
														- {{$post->rank}}
													@endif
													@if(!empty($post->rank_position))
														- {{$post->rank_position}}
													@endif
												
												</td>
												<td>{{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}</td>
												<td>n/a</td>

												<td>
												@if(!empty($applicant->resume))
													<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn resume_icon_preview"><i class="mdi mdi-eye menu-icon"></i></a>
													@else 
														Not Uploaded Yet. 
												@endif
												</td>
												<td>
												<select  class="applicanteventStatus">
													@foreach($status as $k=>$v)
														<option value="{{$k}}" @if( $applicant->status==$k) selected @endif>{{$v}}</option>
													@endforeach
												</select>
												<a href="javascript:void(0)"  data-id="{{$applicant->uev_id}}" data-action="{{route('admin.events',['param'=>'change_status'])}}" class="change_status text-primary">Change</a>
												<a href="javascript:void(0)" data-id="{{$applicant->uev_id}}" class="text-info applicant_email_modal_link">Send Notify</a>
												</td>
											</tr>
                                    	@endforeach
									@else
										<tr><td colspan="10">n/a</td></tr>
									@endif
                                    </tbody>
                                  </table>
                                </div>
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
			<button type="button" class="btn btn-primary" data-id="" data-action="{{route('admin.events',['param'=>'send_event_notify'])}}"  id="send_event_notify">Send Notify</button>
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
@endsection
