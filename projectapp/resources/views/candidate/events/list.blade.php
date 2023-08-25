@extends('layouts.app')

@section('content') 
<div class="row justify-content-center">
     <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Events Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.events') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.events') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		  <div class="col-md-12">

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
		</div>
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All Events</div>

                <div class="card-body">
				
				
                                	<div class="table-responsive">
                                    	<table class="table table-striped">
                                    		<thead>
                                    			<th>Name</th>
                                    			<th>StartDate</th>
                                    			<th>EndtDate</th>
                                    			<th>Company</th>
                                    			<th>Event Admin</th>
                                    			<th>Evaluator</th>
                                    			<th>Post</th>
                                    			<th>Actions</th>
                                    		</thead>
                                    		<tbody>
                                    			@if(isset($events) && !empty($events))
                                    				@foreach($events as $event)
                                    					<tr>
                                    						<td>{{ $event->name }}</td>
                                    						<td>{{ $event->start_date }}</td>
                                    						<td>{{ $event->end_date }}</td>
                                    						<td>{{ \App\Models\Company::find($event->company_id	)->name }}</td>
                                    						<td>{{ \App\Models\User::find($event->eventadmin_id)->name  ?? "n/a"  }}</td>
                                    						<td class="text-wrap">
															<?php
																$evaluatorname="";
																if(!empty($event->evaluator_id)){
																	foreach(unserialize($event->evaluator_id) as $evaluator){
																		$evaluatorname.= \App\Models\User::find($evaluator)->name . ", ";
																	}
																}
															$evaluatorname=rtrim($evaluatorname, ", ");
															?>
															{{$evaluatorname}}
															</td>
                                    						<td class="text-wrap">
															<?php
																$postname="";
																if(!empty($event->post_id)){
																	foreach(unserialize($event->post_id) as $post_id){
																		$postname.= \App\Models\Posts::find($post_id)->name . ", ";
																	}
																}
															$postname=rtrim($postname, ", ");
															?>
															{{$postname}}
															</td>
                                    						<td class="td-action-icons">
																 <a href="{{ route('admin.events',['param'=>'edit']) }}?id={{$event->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																 <span class="delete_record text-danger h3" data-id="{{$event->id}}" data-action="{{route('admin.events',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>
															</td>
                                    					</tr>
                                    				@endforeach
                                    			@else
                                    				<tr colspan="7">No Results</tr>
                                    			@endif
                                    		</tbody>
                                    	</table>
									<div class="total_pages">

                                    @if(isset($events) && !empty($events))
                                        Total: {{ $events->total() }}
                                            {{ $events->onEachSide(5)->links() }}
                                    @endif
                                    </div>
                                    </div>
				</div>
			</div>
		</div>
	</div>
@endsection