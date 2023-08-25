@extends('layouts.app')

@section('content')
		  <div class="row">
				<div class="col-md-12">
					  @if(session()->has('success'))
					<div class="alert alert-success">
						{{ session()->get('success') }}
					</div>
				@endif
				</div>
			</div>
               	 <div class="row">
                      <div class="col-lg-12 d-flex flex-column">
                            <div class="card">
                               <div class="card-body">
							   
                                <div class="row">
                                  <div class="col-sm-12">
								     <div class="accordion" id="accordionExample">
									  <h2 class="profile__percentage" >
										  <p class="card-description profile_top_heading">Profile Completion Status: 
										   @if(isset($profilestatus))
										   <span class="@if($profilestatus>='80') text-success @elseif($profilestatus>='50') text-warning @elseif($profilestatus>='30') text-info @elseif($profilestatus>='0') text-danger @endif">
										   {{round($profilestatus)}}%
										   </span>
										   @endif
										   <a href="{{route('admin.profile') }}">View Profile</a>
										   </p>
										   <p class="card-description">To apply any event, you need to make sure that your profile completion percentage is 100% <a href="javascript:void(0)" class="collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Click here to see how it works</a></p>
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
 @if(isset($event) && !empty($event)&& isset($profilestatus) && $profilestatus>='100') 
					<div class="row">
                      <div class="col-lg-12 d-flex flex-column">
                            <div class="card">
                               <div class="card-body">
							   <div class="card-description">You have applied for <strong>{{$event->name}}</strong></div>
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
					@endif
			  @if(isset($profilestatus) && $profilestatus>='100') 		
			<div class="row">
			 <div class="col-lg-12 d-flex flex-column">
				<div class="card">
					<div class="row home__events_row">
								<h2 class="main-card-title">New Live Events</h3>
					@if(isset($eventList) && count($eventList)!=0)
						<?php
								$user_eventArr=array();
								foreach($user_events as $item){
									$user_eventArr[]=$item->id;
								}
						?>
							@foreach($eventList as $event)
							   <div class="col-md-4 grid-margin grid-margin-md-0 stretch-card">
								
									<div class="card-body">
									  <h4 class="card-title"><a href="{{route('admin.events') }}/apply?id={{$event->id}}">{{ $event->name }} </a></h4>
									 @if(!empty($user_eventArr) && in_array($event->id,$user_eventArr)) 
									  <p class="card-description">
										<span class="badge badge-success">Applied</span>
									  </p>
									  @endif
									  <p class="card-description"><code>{{ date('d M,Y',strtotime($event->start_date)) }}</code> to <code>{{ date('d M,Y',strtotime($event->end_date)) }}</code></p>
									 <p class="card-description card-image">
										 @if(!empty($event->featured_image))
											<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"> 
											@else
											<img src="{{ asset('/assets/images/frontpage/explora_gold_logo.png') }}">
										@endif
									</p>
									 <?php
										$postname="";
										if(!empty($event->post_id)){
											foreach(unserialize($event->post_id) as $post_id){
												$postname.= \App\Models\Posts::find($post_id)->name . ", ";
											}
										}
									$postname=rtrim($postname, ", ");
									?>
									 <p class="card-description">Company Name: <strong><code>{{ \App\Models\Company::find($event->company_id	)->name }}</code></strong></p>
									 <p class="card-description">Keys: <code>{{$postname}}</code></p>
									
									</div>
								 
								</div>
							@endforeach
						@else
							<p class="card-description">No results found.</h3>
						@endif
					   </div>
				   </div>
				   </div>
			   </div>
	@endif
@endsection
