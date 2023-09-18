@extends('layouts.app')

@section('content')
<div class="cstm_evaluator_admin_home cstm_common_admin">
  <div class="row dash-board-count-box">

        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Events Assigned</h6>
                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span>{{$events}}</span></h2>
                </div>
            </div>
        </div>
        
        
	</div>
 
        <div class="row flex-grow">
                          <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                              <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-start">
                                  <div>
                                    <h4 class="card-title card-title-dash">Events List</h4>
                                  </div>
                                 
                                </div>
                                <div class="table-responsive  mt-1">
                                   <table class="table select-table">
                                    <thead>
                                      <tr>
                                       <th>Name</th>
										<th>StartDate</th>
										<th>EndtDate</th>
										<th>Company</th>
										<th>Event Admin</th>
										<th>Evaluator</th>
										<th>Postitions</th>
										<th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     @if(isset($eventList) && count($eventList)!=0)
										  
										@foreach($eventList as $event)
											<tr>
												<td>{{ $event->name }}
					<?php echo get_event_status_badge($event->status) ?>
															
												</td>
												<td>{{ $event->start_date }}</td>
												<td>{{ $event->end_date }}</td>
												<td>{{ \App\Models\Company::find($event->company_id	)->name }}</td>
												<td>{{ \App\Models\User::find($event->eventadmin_id)->name  ?? "n/a" }}</td>
												<td class="text-wrap">
												{{getEvalauatorName($event->id)}}
												</td>
												<td class="text-wrap">
															<?php
																$postname="";
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
															<span class="w-50">{{$postname}}</span>
												</td>
												<td class="td-action-icons">
													
													 <a href="{{ route('admin.events',['param'=>'applicants']) }}?id={{$event->id}}" class="btn-user h3" title="Applicant"><i class="fa fa-users" aria-hidden="true"></i></a> 
												</td>
											</tr>
                                    	@endforeach
									@else
										<tr><td colspan="8">n/a</td></tr>
									@endif
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
</div>
@endsection
