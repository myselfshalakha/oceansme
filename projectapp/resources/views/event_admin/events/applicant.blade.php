@extends('layouts.app')
@section('content') 
<?php
$eventID=isset($_GET["id"])?$_GET["id"]:"";
$userEventStatus=isset($_GET["status"])?$_GET["status"]:"";
$user_response_status=get_user_response_status();
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
							@if($k==6)
								@php $totaleventsCount=get_applicantCountbyStatus($k,$event->id); @endphp
							@else
								@foreach($eventStatusCountData as $statusData)
									@if($statusData->status==$k)
										@php
											$totaleventsCount=$statusData->total;
										@endphp
										@break
									@endif
								@endforeach
							@endif
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
                            <div id="schedule_bydept">
                                     @if(isset($applicants) && count($applicants)!=0)
									 <select id="departmentFilter" class="form-control">
										<option value="">All Department</option>
									@foreach($departments as $dep)
										<option value="{{$dep->dep_id}}">{{\App\Models\Department::find($dep->dep_id)->name }}</option>
									@endforeach
									  </select>
									 @endif  
									 @if(isset($applicants) && count($applicants)!=0)
									 <select id="scheduleFilter" class="form-control">
										<option value="">Choose anyone schedule...</option>
												@if(isset($schedules) && !empty($schedules))
													@foreach($schedules as $schedule)
													<option value="{{ $schedule->id }}">{{ $schedule->location }} - {{ date("d-m-Y h:i a" , strtotime($schedule->schedule)) }}</option>
													@endforeach
												@endif
									  </select>
									 @endif
									<button name="schedule_bydept" class="schedule_bydept" data-action="{{route('admin.schedule',['param'=>'change_schedule'])}}" type="button">Send Schedule</button>

									 </div>
                              <div class="card-body">
                               
                                <div class="table-responsive  mt-1 applicant_list_table">
                                   <table class="table select-table">
                                    <thead>
                                      <tr>
									   	<th><input type="checkbox" name="select_all" value="1" id="rows-select-all"></th>
                                       <th>Department</th>
                                       <th>RegNo</th>
                                       <th>Name</th>
										<th>Email</th>
										<th>Nationality</th>
										<th>Current Position</th>
										<th>Applying Position</th>
										<th>Eperience</th>
										<!--th>Schedule</th-->
										<th>Resume</th>
                                      </tr>
                                    </thead>
                                    <tbody>
									<?php
									$status=get_user_status();
									?>
                                     @if(isset($applicants) && count($applicants)!=0)
										@foreach($applicants as $applicant)
											<tr>
											 <td>{{$applicant->uev_id}}</td>
												<td>
												{{$applicant->dep_id}}
												</td>
												<td>
												<a href="{{ route('admin.events',['param'=>'applicant-info']) }}?id={{$applicant->uev_id}}" class="text-info" title="Regid">#{{$applicant->uev_id}}</a> 

												</td>
												<td>{{ $applicant->name }}
													 @if(isset($applicant->status)) 
													<p class="card-text">
													 <?php echo get_applicant_status_badge($applicant->status,$user_response_status)  ?>
													 </p>
													 @endif
												</td>
												
												<td>{{ $applicant->email }}</td>
												<td>{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}</td>

												<td>{{ $applicant->position ?? 'n/a'}}</td>
												<td>{{ \App\Models\Posts::find($applicant->post_apply)->name}}</td>
												<td>{{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}</td>
												<!--td>
												<select>
												<option value="">Choose anyone schedule...</option>
												
												@if(isset($schedules) && !empty($schedules))
													@foreach($schedules as $schedule)
													<option value="{{ $schedule->id }}" {{ ($schedule->id == $applicant->schedule) ? 'selected' : '' }}>{{ $schedule->location }} - {{ date("d-m-Y h:i a" , strtotime($schedule->schedule)) }}</option>
													@endforeach
												@endif
												</select>
												<button name="change_schedule" class="change_schedule" data-id="{{$applicant->uev_id}}" data-action="{{route('admin.schedule',['param'=>'change_schedule'])}}" type="button">Send Schedule</button>

												</td-->

												<td>
												@if(!empty($applicant->resume))
													<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn resume_icon_preview"><i class="mdi mdi-eye menu-icon"></i></a>
													@else 
														Not Uploaded Yet. 
												@endif
												
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
      </div>
     
    </div>
  </div>
</div>
<script src="{{ asset('/assets/common/js/events/datatable.js') }}"></script>

@endsection
