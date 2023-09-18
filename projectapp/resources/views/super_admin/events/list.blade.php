@extends('layouts.app')

@section('content') 
<div class="cstm_events_admin_createalist cstm_common_admin">
	<div class="row justify-content-center">

		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All Events</div>

                <div class="card-body">
				
				
                                	<div class="table-responsive">
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
                                     @if(isset($events) && count($events)!=0)
										@foreach($events as $event)
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
														 <a href="{{ route('admin.events',['param'=>'edit']) }}?id={{$event->id}}" class="btn-info h3"  title="Edit"><i class="menu-icon mdi mdi-pencil"></i></a> 	
														 <a href="{{ route('admin.events',['param'=>'applicants']) }}?id={{$event->id}}" class="btn-user h3" title="Applicant"><i class="fa fa-users" aria-hidden="true"></i></a> 
														 <span class="delete_record text-danger h3" data-id="{{$event->id}}" data-action="{{route('admin.events',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>

												</td>
											</tr>
                                    	@endforeach
									@else
										<tr colspan="7">No Results</tr>
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